<?php

namespace App\Livewire\Deadlines;

use App\Models\LegalCase;
use Livewire\Component;

class CaseDeadlinesList extends Component
{
    public LegalCase $case;

    protected $listeners = ['deadline-created' => '$refresh', 'deadline-updated' => '$refresh'];

    public function mount(LegalCase $case)
    {
        $this->case = $case;
    }

    public function render()
    {
        $deadlines = $this->case->deadlines()
            ->orderBy('expires_at', 'asc') // Sooner deadlines first
            ->get();

        return view('livewire.deadlines.case-deadlines-list', [
            'deadlines' => $deadlines
        ]);
    }
}
