<?php

namespace App\Livewire\Cases;

use App\Models\LegalCase;
use App\Models\Participant;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ParticipantManager extends Component
{
    public LegalCase $case;
    
    // Form Properties
    public $name;
    public $type = 'fisica';
    public $role = 'imputado';
    public $alias;
    public $is_detained = false;
    public $notes;
    
    public $isCreating = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'type' => 'required|in:fisica,moral,autoridad',
        'role' => 'required|string|max:50',
        'alias' => 'nullable|string|max:255',
        'is_detained' => 'boolean',
        'notes' => 'nullable|string',
    ];

    public function mount(LegalCase $case)
    {
        $this->case = $case;
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->dispatch('open-modal', 'create-participant');
    }

    public function closeCreateModal()
    {
        $this->dispatch('close-modal', 'create-participant');
    }

    public function resetForm()
    {
        $this->name = '';
        $this->type = 'fisica';
        $this->role = 'imputado';
        $this->alias = '';
        $this->is_detained = false;
        $this->notes = '';
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            // 1. Create Participant (or find logic could go here later)
            // For now, we assume creating a new record for the tenant
            $participant = Participant::create([
                'tenant_id' => $this->case->tenant_id,
                'name' => $this->name,
                'type' => $this->type,
                // Other fields like RFC, DOB left blank for simplified flow
            ]);

            // 2. Attach to Case
            $this->case->participants()->attach($participant->id, [
                'role' => $this->role,
                'alias' => $this->alias,
                'is_detained' => $this->is_detained,
                'notes' => $this->notes,
            ]);
        });

        $this->closeCreateModal();
        $this->dispatch('participant-added'); // Optional notification
    }

    public function delete($participantId)
    {
        // Detach only
        $this->case->participants()->detach($participantId);
    }

    public function render()
    {
        // Reload participants to get fresh list
        $participants = $this->case->participants()->orderByPivot('created_at', 'desc')->get();

        return view('livewire.cases.participant-manager', [
            'participants' => $participants
        ]);
    }
}