<?php

namespace App\Livewire\Cases;

use App\Models\CrimeType;
use App\Models\LegalCase;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use App\Enums\CaseParticipantRole;
use App\Models\DeadlineType;

class CreateCaseForm extends Component
{
    // Authorities
    public $court_name;
    public $prosecutor_name;
    public $judge_name;
    public $prosecutor_name_specific; // Added to match view input

    // Core Fields (Restored)
    public $internal_folio;
    public $nuc;
    public $case_alias;
    public $crime_type;
    public $crime_severity; // Risk Level
    public $stage = 'inv_inicial';
    public $status = 'activo';
    public $start_date;
    public $notes;

    // Defendant (Imputado)
    public $defendant_name;
    public $defendant_rfc;
    public $defendant_defender;
    public $defendant_alias; // New
    public $defendant_is_detained = false; // New

    // Victim (Víctima) - NEW
    public $victim_name;
    public $victim_rfc;

    // Measures
    public $selected_measures = []; // ['pris_prev', 'firma', ...]
    
    // UI State
    public $activeParticipantTab = 'imputado'; // imputado | victima

    // Catalogues
    public $crimeTypes;
    public $deadlineTypes; // New

    public function getRules($isDraft = false)
    {
        $rules = [
            'internal_folio' => 'required|string|max:100',
            'nuc' => 'nullable|string|max:100',
            'case_alias' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            // Defendant
            'defendant_name' => 'nullable|string|max:255',
            'defendant_rfc' => 'nullable|string|max:20',
            'defendant_defender' => 'nullable|string|max:255',
            // Victim
            'victim_name' => 'nullable|string|max:255',
            'victim_rfc' => 'nullable|string|max:20',
        ];

        if (!$isDraft) {
            $rules = array_merge($rules, [
                'crime_type' => 'required|string|exists:crime_types,name',
                'stage' => 'required|in:inv_inicial,inv_complementaria,intermedia,juicio,ejecucion',
                'start_date' => 'required|date',
                'court_name' => 'required|string|max:255',
                // Optional but validated if present
                'prosecutor_name' => 'nullable|string|max:255',
                'judge_name' => 'nullable|string|max:255',
            ]);
        } else {
            $rules = array_merge($rules, [
                'crime_type' => 'nullable|string|exists:crime_types,name',
                'stage' => 'nullable|in:inv_inicial,inv_complementaria,intermedia,juicio,ejecucion',
                'start_date' => 'nullable|date',
                'court_name' => 'nullable|string|max:255',
            ]);
        }

        return $rules;
    }

    public function mount()
    {
        $this->start_date = now()->format('Y-m-d');
        $this->crimeTypes = CrimeType::orderBy('name')->get();
        $this->deadlineTypes = DeadlineType::orderBy('name')->get();
    }

    public function saveAsDraft()
    {
        $this->validate($this->getRules(true));
        $this->persistCase('borrador');
    }

    public function save()
    {
        $this->validate($this->getRules(false));
        // Logic check: Ensure we don't exceed limits even for active save
        $this->persistCase('activo');
    }

    protected function persistCase($targetStatus)
    {
        $tenant = Tenant::getGlobalTenant();

        if (!$tenant) {
            abort(404, 'No tenant context found.');
        }

        // Check Plan Limits only if activating
        if ($targetStatus === 'activo') {
            $maxCases = $tenant->subscriptionTier->max_active_cases;
            $currentActiveCases = LegalCase::where('tenant_id', $tenant->id)
                ->where('status', 'activo')
                ->count();

            if ($currentActiveCases >= $maxCases) {
                $this->addError('internal_folio', "Has alcanzado el límite de casos activos. Guarda como borrador o mejora tu plan.");
                return;
            }
        }

        // Prepend specific prosecutor to notes if present
        $finalNotes = $this->notes;
        if ($this->prosecutor_name_specific) {
            $finalNotes = "Fiscal a cargo: {$this->prosecutor_name_specific}\n\n" . $finalNotes;
        }

        $case = LegalCase::create([
            'tenant_id' => $tenant->id,
            'internal_folio' => $this->internal_folio,
            'nuc' => $this->nuc,
            'case_alias' => $this->case_alias,
            'crime_type' => $this->crime_type,
            'crime_severity' => $this->crime_severity, // Saved from risk select
            'stage' => $this->stage,
            'status' => $targetStatus,
            'start_date' => $this->start_date,
            'notes' => $finalNotes,
            'court_name' => $this->court_name,
            'prosecutor_name' => $this->prosecutor_name, // The Entity (Select)
            'judge_name' => $this->judge_name,
            'lead_lawyer_id' => Auth::id(),
        ]);

        // Save Defendant (Participant)
        $participantId = null;
        if ($this->defendant_name) {
            $participant = \App\Models\Participant::create([
                'tenant_id' => $tenant->id,
                'name' => $this->defendant_name,
                'rfc' => $this->defendant_rfc,
                'type' => 'physical', // Assuming individual
            ]);
            $participantId = $participant->id;

            $case->participants()->attach($participant->id, [
                'role' => CaseParticipantRole::IMPUTADO->value,
                'defense_attorney_name' => $this->defendant_defender,
                'alias' => $this->defendant_alias,
                'is_detained' => $this->defendant_is_detained,
            ]);
        }

        // Save Victim (Participant) - NEW
        if ($this->victim_name) {
            $victim = \App\Models\Participant::create([
                'tenant_id' => $tenant->id,
                'name' => $this->victim_name,
                'rfc' => $this->victim_rfc,
                'type' => 'physical', // Assuming individual for simplicity, could be moral
            ]);

            $case->participants()->attach($victim->id, [
                'role' => CaseParticipantRole::VICTIMA->value,
            ]);
        }

        // Save Measures
        // Logic: Checks `selected_measures` array values.
        // For MVP, we'll try to find a MeasureType by slug/name or create it if missing, then link it.
        // We will assume the checkboxes values are slugs: 'pris_prev', 'firma', etc.
        // We need the Participant ID to associate the measure (Measures are per person usually).
        // If no participant created, we can't strictly attach a measure to a person, might default to null participant or just skip.
        // Decision: Only save measures if we have a defendant (imputado).

        if ($participantId && !empty($this->selected_measures)) {
            foreach ($this->selected_measures as $measureSlug) {
                // Map slug to readable name for description/type creation
                $measureName = match ($measureSlug) {
                    'pris_prev' => 'Prisión Preventiva',
                    'firma' => 'Firma Periódica', // 'firma_periodica' in view?
                    'firma_periodica' => 'Firma Periódica',
                    'arraigo_nacional' => 'Arraigo Nacional',
                    'prohibicion_acercamiento' => 'Prohibición de Acercamiento',
                    default => ucfirst(str_replace('_', ' ', $measureSlug)),
                };

                // Ideally we'd look up a PrecautionaryMeasureType by slug/code.
                // Since types table is empty/stub, we'll create the measure record directly or use a stub type.
                // Let's create the measure record directly on the relationship to the Case/Participant. It seems `PrecautionaryMeasure` belongs to `measureType`.
                // We'll create a type on the fly or find one.
                $type = \App\Models\PrecautionaryMeasureType::firstOrCreate(
                    ['name' => $measureName],
                    ['description' => 'Generado automáticamente']
                );

                \App\Models\PrecautionaryMeasure::create([
                    'tenant_id' => $tenant->id,
                    'case_id' => $case->id,
                    'participant_id' => $participantId,
                    'measure_type_id' => $type->id,
                    'description' => $measureName,
                    'imposed_at' => now(), // Default to today
                    'status' => 'vigente',
                ]);
            }
        }

        // History
        $case->stageHistory()->create([
            'tenant_id' => $case->tenant_id,
            'new_stage' => $this->stage ?? 'inv_inicial', // Fallback for draft
            'new_status' => $targetStatus,
            'reason' => 'Creación de expediente (' . $targetStatus . ')',
            'changed_by' => Auth::id(),
        ]);

        return redirect()->route('cases.index')->with('status', 'Caso guardado exitosamente.');
    }

    public function render()
    {
        return view('livewire.cases.create-case-form')
            ->layout('layouts.app', ['header' => 'Apertura de Nuevo Caso']);
    }
}