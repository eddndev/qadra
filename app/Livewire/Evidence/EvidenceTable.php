<?php

namespace App\Livewire\Evidence;

use App\Models\Evidence;
use Livewire\Component;
use Livewire\WithPagination;

class EvidenceTable extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $typeFilter = '';
    
    // Contextual Filter
    public $caseId = null;

    // Reset pagination when filters change
    public function updatedSearch() { $this->resetPage(); }
    public function updatedStatusFilter() { $this->resetPage(); }
    public function updatedTypeFilter() { $this->resetPage(); }

    public function mount($caseId = null)
    {
        $this->caseId = $caseId;
    }

    public function render()
    {
        $evidences = Evidence::with('legalCase')
            // Filter by Case ID if provided (Contextual View)
            ->when($this->caseId, function($query) {
                $query->where('case_id', $this->caseId);
            })
            ->where(function($query) {
                $query->where('chain_of_custody_folio', 'like', '%'.$this->search.'%')
                      ->orWhere('description', 'like', '%'.$this->search.'%')
                      ->orWhereHas('legalCase', function($q) {
                          $q->where('internal_folio', 'like', '%'.$this->search.'%')
                            ->orWhere('case_alias', 'like', '%'.$this->search.'%');
                      });
            })
            ->when($this->statusFilter, function($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->typeFilter, function($query) {
                $query->where('type', $this->typeFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.evidence.evidence-table', [
            'evidences' => $evidences
        ]); // Removed layout() call here because it might be nested
    }
}
