<?php

namespace App\Livewire\Cases;

use App\Models\LegalCase;
use Livewire\Component;
use Livewire\WithPagination;

class CaseList extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStage = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = LegalCase::query();
        
        // HasTenants trait automatically applies tenant scope here.
        
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('internal_folio', 'like', '%' . $this->search . '%')
                  ->orWhere('nuc', 'like', '%' . $this->search . '%')
                  ->orWhere('case_alias', 'like', '%' . $this->search . '%')
                  ->orWhere('crime_type', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStage) {
            $query->where('stage', $this->filterStage);
        }

        $cases = $query->orderByDesc('created_at')->paginate(10);

        return view('livewire.cases.case-list', [
            'cases' => $cases
        ])->layout('layouts.app', ['header' => 'Expedientes Penales']);
    }
}