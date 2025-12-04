<?php

namespace App\Livewire\Measures;

use App\Models\LegalCase;
use App\Models\PrecautionaryMeasure;
use App\Models\PrecautionaryMeasureType;
use App\Models\Deadline;
use Livewire\Component;

class PrecautionaryMeasureForm extends Component
{
    public LegalCase $case;
    public $measureId; // For editing

    // Form Fields
    public $participant_id;
    public $measure_type_id;
    public $description;
    public $imposed_at;
    public $judge_name;
    public $review_date;
    public $expires_at;
    
    // Catalogs
    public $imputed_participants;
    public $measure_types;
    
    // UI State
    public $isEditing = false;
    public $showForm = false;

    protected $rules = [
        'participant_id' => 'required|exists:participants,id',
        'measure_type_id' => 'required|exists:precautionary_measure_types,id',
        'description' => 'required|string|max:1000',
        'imposed_at' => 'required|date',
        'judge_name' => 'nullable|string|max:255',
        'review_date' => 'nullable|date|after:imposed_at',
        'expires_at' => 'nullable|date|after:imposed_at',
    ];

    public function mount(LegalCase $case)
    {
        $this->case = $case;
        $this->loadCatalogs();
    }

    public function loadCatalogs()
    {
        // Only participants linked to this case with role 'imputado'
        $this->imputed_participants = $this->case->participants()
            ->wherePivot('role', 'imputado')
            ->get();
            
        $this->measure_types = PrecautionaryMeasureType::all();
    }

    public function create()
    {
        $this->reset(['participant_id', 'measure_type_id', 'description', 'judge_name', 'review_date', 'expires_at', 'measureId', 'isEditing']);
        $this->imposed_at = now()->format('Y-m-d');
        $this->showForm = true;
    }

    public function cancel()
    {
        $this->showForm = false;
    }

    // Dynamic Validation
    public function updatedMeasureTypeId($value)
    {
        $type = $this->measure_types->find($value);
        
        // If Prisión Preventiva (usually ID 14 or by name), suggest default logic
        // We'll check by name to be robust against seeder changes
        if ($type && stripos($type->name, 'Prisión Preventiva') !== false) {
            // Auto-suggest review in 2 years (constitutional limit) or sooner
            $this->review_date = now()->addYears(2)->subDays(1)->format('Y-m-d');
        }
    }

    public function save()
    {
        $this->validate();

        // Custom validation for Prisión Preventiva
        $type = $this->measure_types->find($this->measure_type_id);
        if ($type && stripos($type->name, 'Prisión Preventiva') !== false && empty($this->review_date)) {
            $this->addError('review_date', 'La fecha de revisión es obligatoria para Prisión Preventiva.');
            return;
        }

        if ($this->isEditing) {
            $measure = PrecautionaryMeasure::find($this->measureId);
            $measure->update([
                'participant_id' => $this->participant_id,
                'measure_type_id' => $this->measure_type_id,
                'description' => $this->description,
                'imposed_at' => $this->imposed_at,
                'judge_name' => $this->judge_name,
                'review_date' => $this->review_date,
                'expires_at' => $this->expires_at,
            ]);
            session()->flash('message', 'Medida actualizada correctamente.');
        } else {
            $measure = PrecautionaryMeasure::create([
                'tenant_id' => $this->case->tenant_id, // Explicit or via trait
                'case_id' => $this->case->id,
                'participant_id' => $this->participant_id,
                'measure_type_id' => $this->measure_type_id,
                'description' => $this->description,
                'imposed_at' => $this->imposed_at,
                'judge_name' => $this->judge_name,
                'review_date' => $this->review_date,
                'expires_at' => $this->expires_at,
                'status' => 'vigente',
            ]);
            
            // Create Automatic Deadline for Review
            if ($this->review_date) {
                Deadline::create([
                    'tenant_id' => $measure->tenant_id,
                    'case_id' => $measure->case_id,
                    'title' => 'Revisión de Medida: ' . $type->name,
                    'description' => 'Revisión obligatoria de medida cautelar impuesta a ' . $measure->participant->name,
                    'expires_at' => $this->review_date,
                    'is_fatal' => true, // Usually fatal to review imprisonment
                    'status' => 'pendiente',
                    'reminder_config' => json_encode(['30_days', '7_days', '1_day']),
                ]);
            }

            session()->flash('message', 'Medida registrada correctamente.');
        }

        $this->showForm = false;
        // Refresh list handled by render
    }
    
    public function edit($id)
    {
        $measure = PrecautionaryMeasure::findOrFail($id);
        $this->measureId = $measure->id;
        $this->participant_id = $measure->participant_id;
        $this->measure_type_id = $measure->measure_type_id;
        $this->description = $measure->description;
        $this->imposed_at = $measure->imposed_at->format('Y-m-d');
        $this->judge_name = $measure->judge_name;
        $this->review_date = $measure->review_date ? $measure->review_date->format('Y-m-d') : null;
        $this->expires_at = $measure->expires_at ? $measure->expires_at->format('Y-m-d') : null;
        
        $this->isEditing = true;
        $this->showForm = true;
    }

    public function revoke($id)
    {
        // Simple revoke for MVP, could be a modal with reason
        $measure = PrecautionaryMeasure::findOrFail($id);
        $measure->update([
            'status' => 'revocada',
            'revoked_at' => now(),
            'revoked_reason' => 'Revocación manual',
        ]);
    }

    public function render()
    {
        $measures = PrecautionaryMeasure::where('case_id', $this->case->id)
            ->with(['participant', 'measureType'])
            ->orderByDesc('imposed_at')
            ->get();

        return view('livewire.measures.precautionary-measure-form', [
            'measures' => $measures
        ]);
    }
}