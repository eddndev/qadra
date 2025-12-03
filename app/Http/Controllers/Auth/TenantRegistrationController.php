<?php

namespace App\Http\Controllers\Auth;

use App\Events\TenantCreated;
use App\Http\Controllers\Controller;
use App\Models\SubscriptionTier;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TenantRegistrationController extends Controller
{
    /**
     * Show the form for creating a new tenant (for authenticated users).
     */
    public function create(): View
    {
        $plans = SubscriptionTier::where('is_active', true)->orderBy('sort_order')->get();
        return view('auth.create-tenant', compact('plans'));
    }

    /**
     * Handle an incoming tenant creation request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'tax_id' => [
                'required', 
                'string', 
                'max:13', 
                'regex:/^([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))([A-Z\d]{3})?$/i'
            ],
            'plan_id' => ['required', 'exists:subscription_tiers,id'],
        ], [
            'tax_id.regex' => 'El RFC no tiene un formato válido.',
        ]);

        $user = Auth::user();

        $tenant = DB::transaction(function () use ($request, $user) {
            // 1. Create Tenant
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
                'current_users_count' => 1, // The owner
            ]);

            // 2. Dispatch TenantCreated event (Creates Roles)
            event(new TenantCreated($tenant));

            // 3. Attach Current User to Tenant as Owner
            $tenant->users()->attach($user->id, [
                'role' => 'owner',
                'is_active' => true,
                'joined_at' => now(),
            ]);

            // 4. Assign Spatie Role for this new context
            setPermissionsTeamId($tenant->id);
            
            // Check if user already has 'owner' role for this team (unlikely as it's new, but safe check)
            if (!$user->hasRole('owner')) {
                $user->assignRole('owner');
            }

            return $tenant;
        });

        // Redirect to Tenant Subdomain
        $centralDomain = parse_url(config('app.url'), PHP_URL_HOST) ?? config('app.url');
        $protocol = request()->secure() ? 'https://' : 'http://';
        $tenantUrl = $protocol . $tenant->slug . '.' . $centralDomain . '/dashboard';

        return redirect()->to($tenantUrl);
    }
}
