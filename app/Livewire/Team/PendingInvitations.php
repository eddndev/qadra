<?php

namespace App\Livewire\Team;

use App\Models\TeamInvitation;
use App\Models\Tenant;
use Livewire\Component;

class PendingInvitations extends Component
{
    // Listen for the event emitted by InviteTeamMemberForm
    protected $listeners = ['invitationSent' => '$refresh'];

    public function cancel($invitationId)
    {
        $invitation = TeamInvitation::find($invitationId);

        if ($invitation && $invitation->tenant_id == session('current_tenant_id')) {
            $invitation->delete();
            session()->flash('status', 'Invitación cancelada correctamente.');
        }
    }

    public function render()
    {
        $tenant = Tenant::find(session('current_tenant_id'));
        
        $invitations = $tenant 
            ? $tenant->invitations()
                ->whereNull('accepted_at')
                ->where('expires_at', '>', now())
                ->orderBy('created_at', 'desc')
                ->get() 
            : collect();

        return view('livewire.team.pending-invitations', [
            'invitations' => $invitations
        ]);
    }
}
