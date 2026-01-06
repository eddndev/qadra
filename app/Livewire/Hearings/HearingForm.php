<?php

namespace App\Livewire\Hearings;

use App\Models\Hearing;
use App\Models\HearingType;
use App\Models\LegalCase;
use App\Models\Participant;
use Illuminate\Validation\Rule;
use Livewire\Component;

class HearingForm extends Component
{
    public ?LegalCase $case = null;
    public ?Hearing $hearing = null; // Null for create, set for edit

    // Form Fields
    public $type;
    public $scheduled_at;
    public $duration_minutes;
    public $courtroom;
    public $virtual_link;
    public $judge_participant_id;
    public $status = 'programada';
    public $result_summary;
    public $case_id; // For when case is not provided via mount

    protected $listeners = [
        'edit-hearing' => 'loadHearing',
        'create-hearing' => 'resetForm'
    ];

    public function mount(?LegalCase $case = null)
    {
        $this->case = $case;
        if ($case) {
            $this->case_id = $case->id;
        }
        $this->type = HearingType::orderBy('id')->first()?->name ?? 'Audiencia Inicial';
    }

    public function loadHearing($hearingId)
    {
        $this->hearing = Hearing::findOrFail($hearingId);
        $this->case = $this->hearing->case;
        $this->case_id = $this->case->id;
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

    public function resetForm($caseId = null)
    {
        $this->hearing = null;

        if ($caseId) {
            $this->case = LegalCase::find($caseId);
            $this->case_id = $caseId;
        } elseif (!$this->case && !$this->case_id) {
            // If used from general calendar and no case selected yet
            $this->case = null;
            $this->case_id = null;
        }

        $this->type = HearingType::orderBy('id')->first()?->name ?? 'Audiencia Inicial';
        $this->scheduled_at = null;
        $this->duration_minutes = null;
        $this->courtroom = null;
        $this->virtual_link = null;
        $this->judge_participant_id = null;
        $this->status = 'programada';
        $this->result_summary = null;

        $this->dispatch('open-modal', 'hearing-form-modal');
    }

    public function save()
    {
        $rules = [
            'type' => 'required|string|max:100',
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'nullable|integer|min:1',
            'courtroom' => 'nullable|string|max:255',
            'virtual_link' => 'nullable|url|max:500',
            'judge_participant_id' => 'nullable|exists:participants,id',
            'status' => 'required|in:programada,celebrada,cancelada,reprogramada',
            'result_summary' => 'nullable|string',
        ];

        if (!$this->case && !$this->case_id) {
            $rules['case_id'] = 'required|exists:legal_cases,id';
        }

        $validated = $this->validate($rules);

        if ($this->status !== 'programada' && empty($this->result_summary)) {
            $this->addError('result_summary', 'El resumen es obligatorio al registrar el resultado.');
            return;
        }

        if ($this->hearing) {
            $this->hearing->update($validated);
            $event = 'hearing-updated';
        } else {
            $validated['case_id'] = $this->case ? $this->case->id : $this->case_id;
            Hearing::create($validated);
            $event = 'hearing-created';
        }

        $this->dispatch('close-modal', 'hearing-form-modal');
        $this->dispatch($event);
        $this->resetForm($this->case_id);
    }

    public function render()
    {
        $judges = collect();
        if ($this->case || $this->case_id) {
            $currentCase = $this->case ?? LegalCase::find($this->case_id);
            if ($currentCase) {
                $judges = $currentCase->participants()
                    ->wherePivotIn('role', ['juez_control', 'juez_juicio'])
                    ->get();
            }
        }

        return view('livewire.hearings.hearing-form', [
            'judges' => $judges,
            'hearingTypes' => HearingType::orderBy('name')->get(),
            'cases' => $this->case ? collect() : LegalCase::orderBy('internal_folio')->get() // Only show all cases if none selected
        ]);
    }
}
