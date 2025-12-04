<?php

namespace App\Livewire\Solutions;

use App\Models\AlternativeSolution;
use App\Models\LegalCase;
use App\Models\Deadline;
use Livewire\Component;

class AlternativeSolutionForm extends Component
{
    public LegalCase $case;
    public $solutionId;
    
    // Form Fields
    public $type;
    public $proposal_date;
    public $approved_at;
    public $judge_name;
    public $conditions;
    public $compliance_deadline;
    public $status = 'propuesta'; // Default

    public $isEditing = false;
    public $showForm = false;

    protected $rules = [
        'type' => 'required|string',
        'proposal_date' => 'required|date',
        'approved_at' => 'nullable|date',
        'judge_name' => 'nullable|string|max:255',
        'conditions' => 'required|string',
        'compliance_deadline' => 'nullable|date|after:proposal_date',
    ];

    public function mount(LegalCase $case)
    {
        $this->case = $case;
    }

    public function create()
    {
        $this->reset(['type', 'proposal_date', 'approved_at', 'judge_name', 'conditions', 'compliance_deadline', 'status', 'solutionId', 'isEditing']);
        $this->proposal_date = now()->format('Y-m-d');
        $this->showForm = true;
    }

    public function cancel()
    {
        $this->showForm = false;
    }

    public function updatedApprovedAt($value)
    {
        if ($value) {
            $this->status = 'aprobada';
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $solution = AlternativeSolution::find($this->solutionId);
            $solution->update([
                'type' => $this->type,
                'proposal_date' => $this->proposal_date,
                'approved_at' => $this->approved_at,
                'judge_name' => $this->judge_name,
                'conditions' => $this->conditions,
                'compliance_deadline' => $this->compliance_deadline,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Solución actualizada.');
        } else {
            $solution = AlternativeSolution::create([
                'tenant_id' => $this->case->tenant_id,
                'case_id' => $this->case->id,
                'type' => $this->type,
                'proposal_date' => $this->proposal_date,
                'approved_at' => $this->approved_at,
                'judge_name' => $this->judge_name,
                'conditions' => $this->conditions,
                'compliance_deadline' => $this->compliance_deadline,
                'status' => $this->status,
            ]);

            // Create Deadline Alert if approved and has deadline
            if ($this->status === 'aprobada' && $this->compliance_deadline) {
                Deadline::create([
                    'tenant_id' => $solution->tenant_id,
                    'case_id' => $solution->case_id,
                    'title' => 'Cumplimiento: ' . $solution->type,
                    'description' => 'Fecha límite para cumplir condiciones de solución alterna.',
                    'expires_at' => $this->compliance_deadline,
                    'is_fatal' => true,
                    'status' => 'pendiente',
                    'reminder_config' => json_encode(['30_days', '7_days', '1_day']),
                ]);
            }

            session()->flash('message', 'Solución registrada.');
        }

        $this->showForm = false;
    }

    public function edit($id)
    {
        $s = AlternativeSolution::findOrFail($id);
        $this->solutionId = $s->id;
        $this->type = $s->type;
        $this->proposal_date = $s->proposal_date->format('Y-m-d');
        $this->approved_at = $s->approved_at ? $s->approved_at->format('Y-m-d') : null;
        $this->judge_name = $s->judge_name;
        $this->conditions = $s->conditions;
        $this->compliance_deadline = $s->compliance_deadline ? $s->compliance_deadline->format('Y-m-d') : null;
        $this->status = $s->status;
        
        $this->isEditing = true;
        $this->showForm = true;
    }
    
    public function markCompleted($id)
    {
        $s = AlternativeSolution::findOrFail($id);
        $s->update([
            'status' => 'cumplida',
            'completed_at' => now()
        ]);
        session()->flash('message', 'Solución marcada como cumplida exitosamente.');
    }

    public function render()
    {
        $solutions = AlternativeSolution::where('case_id', $this->case->id)
            ->orderByDesc('proposal_date')
            ->get();

        return view('livewire.solutions.alternative-solution-form', [
            'solutions' => $solutions
        ]);
    }
}