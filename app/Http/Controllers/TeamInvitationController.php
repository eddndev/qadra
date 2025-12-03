<?php

namespace App\Http\Controllers;

use App\Events\MemberJoined;
use App\Mail\TeamInvitationMail;
use App\Models\TeamInvitation;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TeamInvitationController extends Controller
{
    /**
     * Show the form for creating a new invitation.
     */
    public function create()
    {
        // Ensure user has permission to invite (Check Policy via Gate in route or here)
        // $this->authorize('create', TeamInvitation::class);
        
        return view('team.invite');
    }

    /**
     * Store a newly created invitation in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'role' => ['required', 'string', 'in:litigante,asociado,paralegal,administrativo'],
        ]);

        // Get current tenant from session or global scope
        $tenant = Tenant::getGlobalTenant();

        if (!$tenant) {
            abort(404, 'No tenant context.');
        }

        // Check for pending invitations
        $existingInvitation = TeamInvitation::where('tenant_id', $tenant->id)
            ->where('email', $request->email)
            ->first();

        if ($existingInvitation) {
            return back()->withErrors(['email' => 'Ya existe una invitación pendiente para este correo.']);
        }

        // Check if user is already a member
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser && $existingUser->belongsToTenant($tenant)) {
            return back()->withErrors(['email' => 'Este usuario ya es miembro del equipo.']);
        }

        $invitation = TeamInvitation::create([
            'tenant_id' => $tenant->id,
            'email' => $request->email,
            'role' => $request->role,
            'token' => Str::uuid(),
            'invited_by' => Auth::id(),
            'expires_at' => now()->addDays(7),
        ]);

        // Send Email
        Mail::to($invitation->email)->send(new TeamInvitationMail($invitation));

        return redirect()->route('dashboard')->with('status', 'invitation-sent');
    }

    /**
     * Accept the invitation.
     */
    public function accept(Request $request, $token)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'Link inválido o expirado.');
        }

        $invitation = TeamInvitation::where('token', $token)->firstOrFail();

        if ($invitation->expires_at->isPast()) {
            abort(403, 'La invitación ha expirado.');
        }

        // Logic:
        // If user is logged in:
        //   - If email matches -> Join
        //   - If email differs -> Logout and ask to login with correct email? Or allow mapping? 
        //     Usually, invite is strictly for that email.
        
        // Simplest MVP:
        if (!Auth::check()) {
            // Check if user exists
            if (User::where('email', $invitation->email)->exists()) {
                // Redirect to login with intended url so they come back here? 
                // Or just tell them to login.
                // Ideally: Login -> Redirect back to THIS accept route.
                session(['url.intended' => url()->full()]); // Return here after login
                return redirect()->route('login')->with('status', 'Por favor inicia sesión para aceptar la invitación.');
            } else {
                // User does NOT exist -> Go to custom registration
                return redirect()->route('register.invited', ['token' => $token]);
            }
        }

        $user = Auth::user();

        if ($user->email !== $invitation->email) {
            // For security, invite email usually must match user email
            // But for MVP testing we might allow it or show error
            return redirect()->route('dashboard')->with('error', 'El correo de la invitación no coincide con tu cuenta.');
        }

        // Join Logic
        DB::transaction(function () use ($invitation, $user) {
            $tenant = $invitation->tenant;

            // Attach user to tenant
            if (!$user->tenants->contains($tenant->id)) {
                $tenant->users()->attach($user->id, [
                    'role' => $invitation->role,
                    'is_active' => true,
                    'joined_at' => now(),
                    'invited_by' => $invitation->invited_by,
                ]);
                
                // Assign Spatie Role
                setPermissionsTeamId($tenant->id);
                $user->assignRole($invitation->role);
            }

            $invitation->update(['accepted_at' => now()]);
            $invitation->delete(); // Or keep as history with soft delete if implemented

            event(new MemberJoined($tenant, $user));
        });

        // Switch to new tenant context?
        session(['current_tenant_id' => $invitation->tenant_id]);
        
        return redirect()->route('dashboard')->with('status', 'joined-team');
    }
}