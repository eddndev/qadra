<?php

namespace App\Policies;

use App\Models\TeamInvitation;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Auth\Access\Response;

class TeamInvitationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('team.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('team.invite');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TeamInvitation $invitation): bool
    {
        return $user->belongsToTenant($invitation->tenant) && $user->hasPermissionTo('team.invite');
    }
}