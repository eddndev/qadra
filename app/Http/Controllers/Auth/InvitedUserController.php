<?php

namespace App\Http\Controllers\Auth;

use App\Events\MemberJoined;
use App\Http\Controllers\Controller;
use App\Models\TeamInvitation;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class InvitedUserController extends Controller
{
    /**
     * Show the registration form for invited users.
     */
    public function create(Request $request): View
    {
        $token = $request->query('token'); // Or from session if passed that way
        
        if (!$token) {
            abort(404);
        }

        $invitation = TeamInvitation::where('token', $token)->firstOrFail();

        if ($invitation->expires_at->isPast()) {
            abort(403, 'La invitación ha expirado.');
        }

        return view('auth.register-invited', compact('invitation'));
    }

    /**
     * Handle an incoming registration request for an invited user.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'invitation_token' => ['required', 'exists:team_invitations,token'],
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $invitation = TeamInvitation::where('token', $request->invitation_token)->firstOrFail();

        if ($invitation->expires_at->isPast()) {
            abort(403, 'La invitación ha expirado.');
        }

        // Ensure user doesn't exist
        if (User::where('email', $invitation->email)->exists()) {
            return redirect()->route('login')->with('status', 'Ya existe una cuenta con este correo. Por favor inicia sesión.');
        }

        $user = DB::transaction(function () use ($request, $invitation) {
            // 1. Create User
            $user = User::create([
                'name' => $request->name,
                'email' => $invitation->email,
                'password' => Hash::make($request->password),
            ]);

            // 2. Attach to Tenant
            $tenant = $invitation->tenant;
            $tenant->users()->attach($user->id, [
                'role' => $invitation->role,
                'is_active' => true,
                'joined_at' => now(),
                'invited_by' => $invitation->invited_by,
            ]);

            // 3. Assign Spatie Role
            setPermissionsTeamId($tenant->id);
            $user->assignRole($invitation->role);

            // 4. Mark Invitation Accepted
            $invitation->update(['accepted_at' => now()]);
            $invitation->delete();

            event(new MemberJoined($tenant, $user));
            event(new Registered($user));

            return $user;
        });

        Auth::login($user);

        // Redirect to Tenant Dashboard
        $centralDomain = parse_url(config('app.url'), PHP_URL_HOST) ?? config('app.url');
        $protocol = request()->secure() ? 'https://' : 'http://';
        $tenantUrl = $protocol . $invitation->tenant->slug . '.' . $centralDomain . '/dashboard';

        return redirect()->to($tenantUrl);
    }
}
