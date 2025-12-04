<?php

namespace App\Observers;

use App\Models\Hearing;
use App\Models\Deadline;

class HearingObserver
{
    /**
     * Handle the Hearing "created" event.
     */
    public function created(Hearing $hearing): void
    {
        Deadline::create([
            'tenant_id' => $hearing->tenant_id,
            'case_id' => $hearing->case_id,
            'hearing_id' => $hearing->id,
            'title' => 'Audiencia: ' . $hearing->type,
            'description' => 'Recordatorio automático de audiencia programada.',
            'expires_at' => $hearing->scheduled_at,
            'is_fatal' => true,
            'reminder_config' => ['days_before' => [7, 3, 1, 0]],
            'status' => 'pendiente',
        ]);
    }

    /**
     * Handle the Hearing "updated" event.
     */
    public function updated(Hearing $hearing): void
    {
        //
    }

    /**
     * Handle the Hearing "deleted" event.
     */
    public function deleted(Hearing $hearing): void
    {
        //
    }

    /**
     * Handle the Hearing "restored" event.
     */
    public function restored(Hearing $hearing): void
    {
        //
    }

    /**
     * Handle the Hearing "force deleted" event.
     */
    public function forceDeleted(Hearing $hearing): void
    {
        //
    }
}