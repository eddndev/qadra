<?php

namespace App\Livewire\Auth;

use App\Events\TenantCreated;
use App\Models\SubscriptionTier;
use App\Models\Tenant;
use App\Models\User;
use App\Rules\ValidRfc;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.blank')]
class RegisterWizard extends Component
{
    // Wizard State
    public int $step = 1;
    public ?bool $registerFirm = null;

    // Step 1: User Info
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    // Step 3: Firm Info
    public string $company_name = '';
    public string $tax_id = '';

    // Step 4: Plan
    public ?int $plan_id = null;

    public function mount()
    {
        // Preelect the first active plan by default
        $this->plan_id = SubscriptionTier::where('is_active', true)->orderBy('sort_order')->value('id');
    }

    public function nextStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        }

        if ($this->step === 3 && $this->registerFirm === true) {
            $this->validate([
                'company_name' => ['required', 'string', 'max:255'],
                'tax_id' => ['required', 'string', 'max:13', new ValidRfc],
            ]);
        }

        if ($this->step === 4 && $this->registerFirm === true) {
            // Validate plan before final submission (though usually handled in register())
            $this->validate([
                'plan_id' => ['required', 'exists:subscription_tiers,id'],
            ]);
            $this->register();
            return;
        }

        $this->step++;
    }

    public function prevStep()
    {
        $this->step--;
    }

    public function selectFirmOption(bool $choice)
    {
        $this->registerFirm = $choice;

        if ($choice === false) {
            // User chose NO firm, register immediately
            $this->register();
        } else {
            $this->nextStep();
        }
    }

    public function register()
    {
        // Final Validation (Safety net)
        if ($this->registerFirm === true) {
            $this->validate([
                'plan_id' => ['required', 'exists:subscription_tiers,id'],
            ]);
        }

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        if ($this->registerFirm === true) {
            $tenant = DB::transaction(function () use ($user) {
                $slug = Str::slug($this->company_name);
                if (Tenant::where('slug', $slug)->exists()) {
                    $slug = $slug . '-' . strtolower(Str::random(4));
                }

                $tenant = Tenant::create([
                    'name' => $this->company_name,
                    'slug' => $slug,
                    'tax_id' => strtoupper($this->tax_id),
                    'subscription_tier_id' => $this->plan_id,
                    'status' => 'trial',
                    'trial_ends_at' => now()->addDays(30),
                    'current_users_count' => 1,
                ]);

                event(new TenantCreated($tenant));

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

            // Refresh to ensure token generation works if needed by listeners
            $user->refresh();

            event(new Registered($user));
            Auth::login($user);

            return redirect()->to($tenantUrl);
        }

        // No Firm
        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('portal');
    }

    public function render()
    {
        return view('livewire.auth.register-wizard', [
            'plans' => SubscriptionTier::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }
}
