<?php

namespace App\Livewire\Team;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class TeamManagement extends Component
{
    use WithPagination;

    public $confirmingUserRemoval = false;
    public $userToRemoveId;

    public function mount()
    {
        // Verify permission (simple check for now, ideally use Gate/Policy)
        // In Tenant context, we check pivot role or Spatie role
        // For now, let's allow access to view, but restrict actions
    }

    public function updateRole($userId, $newRole)
    {
        // Validate Role
        if (!in_array($newRole, ['litigante', 'asociado', 'paralegal', 'administrativo', 'owner'])) {
            return;
        }

        $tenant = Tenant::find(session('current_tenant_id'));
        
        // Only Owner can change roles
        // Check if current user is owner of this tenant
        $currentUserPivot = $tenant->users()->where('user_id', Auth::id())->first()->pivot;
        if ($currentUserPivot->role !== 'owner') {
            session()->flash('error', 'No tienes permisos para cambiar roles.');
            return;
        }

        // Update Pivot
        $tenant->users()->updateExistingPivot($userId, ['role' => $newRole]);

        // Update Spatie Role
        $user = User::find($userId);
        setPermissionsTeamId($tenant->id);
        $user->syncRoles([$newRole]);

        session()->flash('status', 'Rol actualizado correctamente.');
    }

    public function confirmUserRemoval($userId)
    {
        $this->confirmingUserRemoval = true;
        $this->userToRemoveId = $userId;
    }

    public function removeUser()
    {
        $tenant = Tenant::find(session('current_tenant_id'));
        
        // Permission Check
        $currentUserPivot = $tenant->users()->where('user_id', Auth::id())->first()->pivot;
        if ($currentUserPivot->role !== 'owner') {
            session()->flash('error', 'No tienes permisos para eliminar usuarios.');
            $this->confirmingUserRemoval = false;
            return;
        }

        // Prevent removing oneself
        if ($this->userToRemoveId == Auth::id()) {
             session()->flash('error', 'No puedes eliminarte a ti mismo. Usa la opción de abandonar despacho.');
             $this->confirmingUserRemoval = false;
             return;
        }

        // Detach
        $tenant->users()->detach($this->userToRemoveId);
        
        // Remove Spatie Roles for this team
        $user = User::find($this->userToRemoveId);
        setPermissionsTeamId($tenant->id);
        $user->roles()->detach(); // Removes roles for this team_id

        $this->confirmingUserRemoval = false;
        session()->flash('status', 'Usuario eliminado del despacho.');
    }

    public function render()
    {
        $tenant = Tenant::find(session('current_tenant_id'));
        
        $users = $tenant ? $tenant->users()->paginate(10) : collect();

        return view('livewire.team.team-management', [
            'users' => $users,
            'currentUserRole' => $tenant->users()->where('user_id', Auth::id())->first()->pivot->role ?? 'unknown'
        ]);
    }
}
