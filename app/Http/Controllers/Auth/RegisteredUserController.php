<?php

namespace App\Http\Controllers\Auth;

use App\Events\TenantCreated;
use App\Http\Controllers\Controller;
use App\Models\SubscriptionTier;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $plans = SubscriptionTier::where('is_active', true)->orderBy('sort_order')->get();
        return view('auth.register', compact('plans'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // Tenant Info
            'company_name' => ['required', 'string', 'max:255'],
            'tax_id' => [
                'required', 
                'string', 
                'max:13', 
                'regex:/^([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))([A-Z\d]{3})?$/i'
            ],
            'plan_id' => ['required', 'exists:subscription_tiers,id'],
            
            // User Info
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'tax_id.regex' => 'El RFC no tiene un formato válido.',
        ]);

        $tenant = DB::transaction(function () use ($request) {
            // 1. Create Tenant
            $slug = Str::slug($request->company_name);
            // Ensure unique slug (basic implementation)
            if (Tenant::where('slug', $slug)->exists()) {
                $slug = $slug . '-' . Str::random(4);
            }

            $tenant = Tenant::create([
                'name' => $request->company_name,
                'slug' => $slug,
                'tax_id' => strtoupper($request->tax_id),
                'subscription_tier_id' => $request->plan_id,
                'status' => 'trial', // Start as trial
                'trial_ends_at' => now()->addDays(30),
                'current_users_count' => 1,
            ]);

            // 2. Dispatch TenantCreated event (Creates Roles)
            // We dispatch it BEFORE creating the user relationship so roles exist
            event(new TenantCreated($tenant));

            // 3. Create User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // 4. Attach User to Tenant as Owner
            $tenant->users()->attach($user->id, [
                'role' => 'owner',
                'is_active' => true,
                'joined_at' => now(),
            ]);

            // 5. Assign Spatie Role (Scoped by Tenant)
            setPermissionsTeamId($tenant->id);
            $user->assignRole('owner');

            event(new Registered($user));

            Auth::login($user);

            return $tenant;
        });

        // Redirect to Tenant Subdomain
        $centralDomain = parse_url(config('app.url'), PHP_URL_HOST) ?? config('app.url');
        $protocol = request()->secure() ? 'https://' : 'http://';
        $tenantUrl = $protocol . $tenant->slug . '.' . $centralDomain . '/dashboard';

        return redirect()->to($tenantUrl);
    }
}