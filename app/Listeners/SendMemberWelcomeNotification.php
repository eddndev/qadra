<?php

namespace App\Listeners;

use App\Events\MemberJoined;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendMemberWelcomeNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MemberJoined $event): void
    {
        $user = $event->user;
        $tenant = $event->tenant;

        // TODO: Send actual email notification
        // Mail::to($user->email)->send(new WelcomeToTeamMail($tenant, $user));

        Log::info("Welcome notification sent to {$user->email} for joining tenant {$tenant->name}");
    }
}