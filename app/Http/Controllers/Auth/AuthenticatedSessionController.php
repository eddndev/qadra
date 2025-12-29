<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect to user's first tenant subdomain if available
        // Redirect to user's first tenant subdomain if available
        if ($user->tenants->isNotEmpty()) {
            $tenant = $user->tenants->sortByDesc('created_at')->first(); // Get most recent or just first
            $centralDomain = parse_url(config('app.url'), PHP_URL_HOST) ?? config('app.url');
            $protocol = $request->secure() ? 'https://' : 'http://';

            $tenantUrl = $protocol . $tenant->slug . '.' . $centralDomain . '/dashboard';

            // Force redirect to the tenant dashboard, ignoring 'intended' if it was the central dashboard
            return redirect($tenantUrl);
        }

        // If user has no tenants, redirect to tenant creation as they cannot access dashboard
        return redirect()->route('tenant.create');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}