<?php

namespace App\Livewire\Hearings;

use App\Models\Hearing;
use App\Models\LegalCase;
use App\Models\Participant;
use Illuminate\Validation\Rule;
use Livewire\Component;

class HearingForm extends Component
{
    public LegalCase $case;
    public ?Hearing $hearing = null; // Null for create, set for edit

    // Form Fields
    public $type = 'Audiencia Inicial';
    public $scheduled_at;
    public $duration_minutes;
    public $courtroom;
    public $virtual_link;
    public $judge_participant_id;
    public $status = 'programada';
    public $result_summary;
    public $notes; // Not in DB directly? Ah, hearing table doesn't have notes, but has result_summary. 
                   // US-11 says "Notas previas (textarea)". Checking migration... 
                   // Migration doesn't have 'notes'. It has 'result_summary'.
                   // I will stick to migration. Maybe 'notes' meant local logic or forgot to add.
                   // I'll assume no notes field for now or use result_summary if appropriate (but that's for AFTER).
                   // Let's check migration again.
                   
    // Constants
    public $types = [
        'Audiencia Inicial',
        'Formulación de Imputación',
        'Vinculación a Proceso',
        'Audiencia Intermedia',
        'Juicio Oral',
        'Revisión de Medidas Cautelares',
        'Audiencia de Prueba Anticipada',
        'Lectura de Sentencia',
        'Otra'
    ];

    protected $listeners = ['edit-hearing' => 'loadHearing'];

    public function mount(LegalCase $case)
    {
        $this->case = $case;
    }

    public function loadHearing($hearingId)
    {
        $this->hearing = Hearing::findOrFail($hearingId);
        $this->type = $this->hearing->type;
        $this->scheduled_at = $this->hearing->scheduled_at->format('Y-m-d\TH:i');
        $this->duration_minutes = $this->hearing->duration_minutes;
        $this->courtroom = $this->hearing->courtroom;
        $this->virtual_link = $this->hearing->virtual_link;
        $this->judge_participant_id = $this->hearing->judge_participant_id;
        $this->status = $this->hearing->status;
        $this->result_summary = $this->hearing->result_summary;
        
        $this->dispatch('open-modal', 'hearing-form-modal');
    }

    public function resetForm()
    {
        $this->hearing = null;
        $this->type = 'Audiencia Inicial';
        $this->scheduled_at = null;
        $this->duration_minutes = null;
        $this->courtroom = null;
        $this->virtual_link = null;
        $this->judge_participant_id = null;
        $this->status = 'programada';
        $this->result_summary = null;
    }

    public function save()
    {
        $validated = $this->validate([
            'type' => 'required|string|max:100',
            'scheduled_at' => 'required|date|after:yesterday',
            'duration_minutes' => 'nullable|integer|min:1',
            'courtroom' => 'nullable|string|max:255',
            'virtual_link' => 'nullable|url|max:500',
            'judge_participant_id' => 'nullable|exists:participants,id',
            'status' => 'required|in:programada,celebrada,cancelada,reprogramada',
            'result_summary' => 'nullable|string',
        ]);

        // US-12: If status is NOT programada, result_summary is mandatory? 
        // "Campo obligatorio: Resumen de acuerdos/resoluciones"
        if ($this->status !== 'programada' && empty($this->result_summary)) {
            $this->addError('result_summary', 'El resumen es obligatorio al registrar el resultado.');
            return;
        }

        // Auto-set status to 'celebrada' if summary provided and status still programada?
        // Or better trust user selection.
        // But we must ensure consistency.
        
        if ($this->hearing) {
            $this->hearing->update($validated);
            $message = 'Audiencia actualizada correctamente.';
            $event = 'hearing-updated';
        } else {
            $validated['case_id'] = $this->case->id;
            $validated['status'] = 'programada';
            Hearing::create($validated);
            $message = 'Audiencia programada correctamente.';
            $event = 'hearing-created';
        }

        $this->dispatch('close-modal', 'hearing-form-modal');
        $this->dispatch($event);
        $this->resetForm();
        
        // Optional: Flash message
        // session()->flash('status', $message);
    }

    public function render()
    {
        // Filter participants to find judges in this case
        // US says: "select de participants tipo juez_control o juez_juicio"
        // We need to look at case_participants pivot role.
        $judges = $this->case->participants()
            ->wherePivotIn('role', ['juez_control', 'juez_juicio'])
            ->get();

        // Fallback: If no judges assigned to case yet, maybe show all authorities?
        // For now strict to US.

        return view('livewire.hearings.hearing-form', [
            'judges' => $judges
        ]);
    }
}
