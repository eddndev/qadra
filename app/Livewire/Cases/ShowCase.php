<?php

namespace App\Livewire\Cases;

use App\Models\LegalCase;
use App\Models\Tenant;
use Livewire\Component;

class ShowCase extends Component
{
    public LegalCase $case;
    public $activeTab = 'overview'; // overview, participants, hearings, etc.

    public function mount(LegalCase $case)
    {
        // Security Check: Ensure case belongs to current tenant
        // HasTenants trait handles global scope, so 404 if not found automatically in implicit binding?
        // Yes, Laravel implicit binding respects global scopes. 
        // But we double check to be safe and explicit or handle specific errors.
        
        $tenant = Tenant::getGlobalTenant();
        if ($case->tenant_id !== $tenant->id) {
            abort(404);
        }

        $this->case = $case;
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.cases.show-case')
            ->layout('layouts.app', ['header' => $this->case->internal_folio . ' - ' . ($this->case->case_alias ?? 'Expediente')]);
    }
}