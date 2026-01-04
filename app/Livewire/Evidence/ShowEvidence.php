<?php

namespace App\Livewire\Evidence;

use App\Models\Evidence;
use Livewire\Component;

class ShowEvidence extends Component
{
    public Evidence $evidence;

    public function mount(Evidence $evidence)
    {
        // Load relationships: Case, Custody Chain (ordered), and Media
        $this->evidence = $evidence->load([
            'legalCase',
            'chainOfCustodyEntries.registeredBy', // Corrected relationship name
            'media'
        ]);
    }

    public function render()
    {
        return view('livewire.evidence.show-evidence')
            ->layout('layouts.app', ['header' => 'Detalle de Evidencia']);
    }
}