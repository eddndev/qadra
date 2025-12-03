<?php

namespace App\Livewire\Team;

use App\Models\TeamInvitation;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Mail\TeamInvitationMail;

class InviteTeamMemberForm extends Component
{
    public $email;
    public $role = 'litigante';
    public $message;

    protected $rules = [
        'email' => 'required|email',
        'role' => 'required|in:litigante,asociado,paralegal,administrativo',
        'message' => 'nullable|string|max:500',
    ];

    public function invite()
    {
        $this->validate();

        $tenant = Tenant::find(session('current_tenant_id'));
        
        if (!$tenant) {
             $this->addError('email', 'No se ha identificado el despacho actual.');
             return;
        }

        // 1. Validar límites del plan
        // Contamos usuarios activos + invitaciones pendientes
        $pendingInvitationsCount = $tenant->invitations()
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->count();
            
        $currentCount = $tenant->users()->count() + $pendingInvitationsCount;
        $maxUsers = $tenant->subscriptionTier->max_users;

        if ($currentCount >= $maxUsers) {
            $this->addError('email', "Has alcanzado el límite de usuarios para tu plan ({$maxUsers}). Por favor actualiza a Professional.");
            return;
        }

        // 2. Validar si ya es miembro
        if ($tenant->users()->where('email', $this->email)->exists()) {
            $this->addError('email', 'Este usuario ya es miembro del despacho.');
            return;
        }

        // 3. Validar si ya tiene invitación pendiente
        if ($tenant->invitations()->where('email', $this->email)->whereNull('accepted_at')->where('expires_at', '>', now())->exists()) {
            $this->addError('email', 'Ya existe una invitación pendiente para este correo.');
            return;
        }

        // 4. Crear invitación
        $invitation = TeamInvitation::create([
            'tenant_id' => $tenant->id,
            'email' => $this->email,
            'role' => $this->role,
            'token' => Str::uuid(),
            'expires_at' => now()->addDays(7),
            'invited_by' => Auth::id(),
        ]);

        // 5. Enviar Email
        Mail::to($this->email)->send(new TeamInvitationMail($invitation, $this->message));
        
        session()->flash('status', 'Invitación enviada correctamente a ' . $this->email);
        
        $this->reset(['email', 'role', 'message']);
        
        // Emitir evento para actualizar lista de pendientes si estuviera en la misma página
        $this->dispatch('invitationSent');
    }

    public function render()
    {
        return view('livewire.team.invite-team-member-form');
    }
}
