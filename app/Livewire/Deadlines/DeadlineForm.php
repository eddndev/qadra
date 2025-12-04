<?php

namespace App\Livewire\Deadlines;

use App\Models\Deadline;
use App\Models\LegalCase;
use Livewire\Component;

class DeadlineForm extends Component
{
    public LegalCase $case;
    public ?Deadline $deadline = null;

    // Form Fields
    public $title;
    public $description;
    public $expires_at;
    public $is_fatal = false;
    public $status = 'pendiente';
    
    // Reminder Config
    public $remind_7_days = true;
    public $remind_3_days = true;
    public $remind_1_day = true;
    public $remind_0_day = true;

    protected $listeners = ['edit-deadline' => 'loadDeadline'];

    public function mount(LegalCase $case)
    {
        $this->case = $case;
    }

    public function loadDeadline($deadlineId)
    {
        $this->deadline = Deadline::findOrFail($deadlineId);
        $this->title = $this->deadline->title;
        $this->description = $this->deadline->description;
        $this->expires_at = $this->deadline->expires_at->format('Y-m-d\TH:i');
        $this->is_fatal = $this->deadline->is_fatal;
        $this->status = $this->deadline->status;
        
        $config = $this->deadline->reminder_config ?? ['days_before' => []];
        $days = $config['days_before'] ?? [];
        
        $this->remind_7_days = in_array(7, $days);
        $this->remind_3_days = in_array(3, $days);
        $this->remind_1_day = in_array(1, $days);
        $this->remind_0_day = in_array(0, $days);

        $this->dispatch('open-modal', 'deadline-form-modal');
    }

    public function resetForm()
    {
        $this->deadline = null;
        $this->title = '';
        $this->description = '';
        $this->expires_at = null;
        $this->is_fatal = false;
        $this->status = 'pendiente';
        
        $this->remind_7_days = true;
        $this->remind_3_days = true;
        $this->remind_1_day = true;
        $this->remind_0_day = true;
    }

    public function save()
    {
        $validated = $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'expires_at' => 'required|date|after:yesterday',
            'is_fatal' => 'boolean',
            'status' => 'required|in:pendiente,cumplido,vencido',
        ]);

        // Build reminder config
        $days = [];
        if ($this->remind_7_days) $days[] = 7;
        if ($this->remind_3_days) $days[] = 3;
        if ($this->remind_1_day) $days[] = 1;
        if ($this->remind_0_day) $days[] = 0;

        $validated['reminder_config'] = ['days_before' => $days];

        if ($this->deadline) {
            // Check if completed
            if ($this->status === 'cumplido' && $this->deadline->status !== 'cumplido') {
                $validated['completed_at'] = now();
                $validated['completed_by'] = auth()->id();
            }
            
            $this->deadline->update($validated);
            $event = 'deadline-updated';
        } else {
            $validated['case_id'] = $this->case->id;
            // If fatal, ensure at least one reminder? US-14 says "Si es fatal, obligar al menos una alerta".
            if ($this->is_fatal && empty($days)) {
                $this->addError('remind_1_day', 'Los plazos fatales requieren al menos una alerta.');
                return;
            }
            
            Deadline::create($validated);
            $event = 'deadline-created';
        }

        $this->dispatch('close-modal', 'deadline-form-modal');
        $this->dispatch($event);
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.deadlines.deadline-form');
    }
}
