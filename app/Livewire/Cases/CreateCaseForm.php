<?php

namespace App\Livewire\Cases;

use App\Models\CrimeType;
use App\Models\LegalCase;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateCaseForm extends Component
{
    // Form Fields
    public $internal_folio;
    public $nuc;
    public $case_alias;
    public $crime_type;
    public $stage = 'inv_inicial'; // Default
    public $status = 'activo';
    public $start_date;
    public $notes;
    
    // Catalogues
    public $crimeTypes;

    protected $rules = [
        'internal_folio' => 'required|string|max:100',
        'nuc' => 'nullable|string|max:100',
        'case_alias' => 'nullable|string|max:255',
        'crime_type' => 'required|string|exists:crime_types,name',
        'stage' => 'required|in:inv_inicial,inv_complementaria,intermedia,juicio,ejecucion',
        'start_date' => 'required|date',
        'notes' => 'nullable|string',
    ];

    public function mount()
    {
        $this->start_date = now()->format('Y-m-d');
        $this->crimeTypes = CrimeType::orderBy('name')->get();
    }

    public function save()
    {
        $this->validate();

        $tenant = Tenant::getGlobalTenant();

        if (!$tenant) {
            abort(404, 'No tenant context found.');
        }

        // Check Plan Limits
        $maxCases = $tenant->subscriptionTier->max_active_cases;
        $currentActiveCases = LegalCase::where('tenant_id', $tenant->id)
            ->where('status', 'activo')
            ->count();

        if ($currentActiveCases >= $maxCases) {
            $this->addError('internal_folio', "Has alcanzado el límite de casos activos de tu plan ({$maxCases}). Actualiza tu suscripción para continuar.");
            return;
        }
        
        $case = LegalCase::create([
            'tenant_id' => $tenant->id, // Explicitly set tenant
            'internal_folio' => $this->internal_folio,
            'nuc' => $this->nuc,
            'case_alias' => $this->case_alias,
            'crime_type' => $this->crime_type,
            'stage' => $this->stage,
            'status' => $this->status,
            'start_date' => $this->start_date,
            'notes' => $this->notes,
            'lead_lawyer_id' => Auth::id(), // Assign creator as lead lawyer for MVP
            // 'tenant_id' will be auto-filled by HasTenants trait
        ]);
        
        // Create initial history record
        // This should ideally be in an Observer, but manual here is fine for explicit control
        $case->stageHistory()->create([
            'tenant_id' => $case->tenant_id, // Pass explicitly just in case
            'new_stage' => $this->stage,
            'new_status' => $this->status,
            'reason' => 'Apertura de expediente',
            'changed_by' => Auth::id(),
        ]);

        return redirect()->route('cases.index')->with('status', 'Caso creado exitosamente.');
    }

    public function render()
    {
        return view('livewire.cases.create-case-form')
            ->layout('layouts.app', ['header' => 'Apertura de Nuevo Caso']);
    }
}