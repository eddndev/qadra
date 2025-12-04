<?php

namespace App\Livewire\Hearings;

use App\Models\LegalCase;
use Livewire\Component;

class CaseHearingsList extends Component
{
    public LegalCase $case;

    protected $listeners = ['hearing-created' => '$refresh', 'hearing-updated' => '$refresh'];

    public function mount(LegalCase $case)
    {
        $this->case = $case;
    }

    public function render()
    {
        $hearings = $this->case->hearings()
            ->orderBy('scheduled_at', 'desc')
            ->get();

        return view('livewire.hearings.case-hearings-list', [
            'hearings' => $hearings
        ]);
    }
}
