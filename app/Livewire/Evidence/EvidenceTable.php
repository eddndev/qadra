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

    // Reset pagination when filters change
    public function updatedSearch() { $this->resetPage(); }
    public function updatedStatusFilter() { $this->resetPage(); }
    public function updatedTypeFilter() { $this->resetPage(); }

    public function render()
    {
        $evidences = Evidence::with('legalCase')
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
        ])->layout('layouts.app', ['header' => 'Inventario de Evidencias']);
    }
}