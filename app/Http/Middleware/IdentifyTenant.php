<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $hostname = $request->getHost();

        // Get central domain host from config
        // Removes protocol (http://) and path, keeps only host (domain.test.com)
        $centralDomain = parse_url(config('app.url'), PHP_URL_HOST) ?? config('app.url');

        // If we are on the central domain, skip tenant identification
        if ($hostname === $centralDomain) {
            session()->forget('current_tenant_id');
            session()->forget('current_tenant_slug');
            Tenant::setGlobalTenant(null);

            return $next($request);
        }

        // If NOT central domain, assume subdomain is tenant slug
        $domainParts = explode('.', $hostname);
        $slug = $domainParts[0];

        $tenant = Tenant::where('slug', $slug)->first();

        if (!$tenant) {
            // If tenant not found in subdomain, redirect to central domain home or register
            // Using route() ensures we use the APP_URL base
            // return redirect(config('app.url') . '/register')->withErrors('Tenant not found.');
            // Better: just 404 or let it pass as "no tenant" if that's valid? 
            // For now, redirect to central register to be safe and helpful
            return redirect(config('app.url') . '/register');
        }

        // Set the current tenant in the session
        session()->put('current_tenant_id', $tenant->id);
        session()->put('current_tenant_slug', $tenant->slug);

        // Also set a global static property for easy access throughout the app
        Tenant::setGlobalTenant($tenant);

        // Set Spatie Permission Team ID for scoped roles/permissions
        setPermissionsTeamId($tenant->id);

        // If a user is logged in, ensure they belong to this tenant
        if (auth()->check()) {
            if (!auth()->user()->tenants->contains($tenant->id)) {
                auth()->logout(); // Log out if user does not belong to this tenant
                return redirect(config('app.url') . '/login')->withErrors('You do not have access to this workspace.');
            }
        }

        return $next($request);
    }
}
