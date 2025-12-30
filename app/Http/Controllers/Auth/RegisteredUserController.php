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
use App\Rules\ValidRfc;

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
        // 1. Validate User Info (Always Required)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Check if registering a Firm (Optional)
        $hasFirm = $request->filled('company_name');

        if ($hasFirm) {
            $request->validate([
                'company_name' => ['required', 'string', 'max:255'],
                'tax_id' => ['required', 'string', 'max:13', new ValidRfc],
                'plan_id' => ['required', 'exists:subscription_tiers,id'],
            ]);
        }

        // 3. Create User (Always)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 4. Create Tenant (If applicable)
        if ($hasFirm) {
            $tenant = DB::transaction(function () use ($request, $user) {
                $slug = Str::slug($request->company_name);
                if (Tenant::where('slug', $slug)->exists()) {
                    $slug = $slug . '-' . Str::random(4);
                }

                $tenant = Tenant::create([
                    'name' => $request->company_name,
                    'slug' => $slug,
                    'tax_id' => strtoupper($request->tax_id),
                    'subscription_tier_id' => $request->plan_id,
                    'status' => 'trial',
                    'trial_ends_at' => now()->addDays(30),
                    'current_users_count' => 1,
                ]);

                event(new TenantCreated($tenant));

                // Attach User as Owner
                $tenant->users()->attach($user->id, [
                    'role' => 'owner',
                    'is_active' => true,
                    'joined_at' => now(),
                ]);

                setPermissionsTeamId($tenant->id);
                $user->assignRole('owner');

                return $tenant;
            });

            // Redirect to Tenant Dashboard
            $centralDomain = parse_url(config('app.url'), PHP_URL_HOST) ?? config('app.url');
            $protocol = request()->secure() ? 'https://' : 'http://';
            $tenantUrl = $protocol . $tenant->slug . '.' . $centralDomain . '/dashboard';

            // Refresh user to ensure relationships are loaded for the Registered event (Verification URL)
            $user->refresh();

            event(new Registered($user));
            Auth::login($user);

            return redirect()->to($tenantUrl);
        }

        // 5. No Firm -> Redirect to User Portal
        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('portal');
    }
}