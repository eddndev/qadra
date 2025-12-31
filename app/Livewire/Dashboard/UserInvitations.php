<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class UserInvitations extends Component
{
    public function render()
    {
        $invitations = \App\Models\TeamInvitation::where('email', \Illuminate\Support\Facades\Auth::user()->email)
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->with('tenant')
            ->get();

        return view('livewire.dashboard.user-invitations', [
            'invitations' => $invitations
        ]);
    }
}
