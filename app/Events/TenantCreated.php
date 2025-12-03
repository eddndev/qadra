<?php

namespace App\Events;

use App\Models\Tenant;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TenantCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The new tenant instance.
     *
     * @var \App\Models\Tenant
     */
    public $tenant;

    /**
     * Create a new event instance.
     */
    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }
}