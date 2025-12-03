<?php

namespace App\Livewire\Components;

use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TenantSwitcher extends Component
{
    public $currentTenant;
    public $tenants;

    public function mount()
    {
        $this->tenants = Auth::user()->tenants;
        $this->currentTenant = Tenant::getGlobalTenant(); // Using the static helper
        
        if (!$this->currentTenant && session('current_tenant_id')) {
            $this->currentTenant = Tenant::find(session('current_tenant_id'));
        }
    }

    public function switchTenant($tenantId)
    {
        $tenant = $this->tenants->firstWhere('id', $tenantId);

        if ($tenant) {
            $centralDomain = parse_url(config('app.url'), PHP_URL_HOST) ?? config('app.url');
            $protocol = request()->secure() ? 'https://' : 'http://';
            
            // Redirect to the new subdomain
            return redirect()->to($protocol . $tenant->slug . '.' . $centralDomain . '/dashboard');
        }
    }

    public function render()
    {
        return view('livewire.components.tenant-switcher');
    }
}
