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
        // For now, let's assume the tenant is identified by a subdomain
        // Example: {tenant_slug}.qadra.test
        $hostname = $request->getHost();
        $domainParts = explode('.', $hostname);

        // This logic needs to be refined based on actual domain structure (e.g., local setup vs production)
        // For local development with `qadra.test` or similar
        // if ($request->getHost() === config('app.central_domain')) { // e.g., qadra.test
        //     // If it's the central domain, perhaps show a marketing page or registration
        //     return $next($request);
        // }
        
        if (count($domainParts) > 2) { // Assuming subdomain.domain.tld
            $slug = $domainParts[0];
        } else { // No subdomain, might be central domain or no tenant context
            // Default to no tenant or handle central domain specific routes
            session()->forget('current_tenant_id');
            session()->forget('current_tenant_slug');
            Tenant::setGlobalTenant(null); // Clear global static tenant if set

            // Allow access to routes that don't require a tenant (e.g., public pages, registration)
            return $next($request);
        }

        $tenant = Tenant::where('slug', $slug)->first();

        if (!$tenant) {
            // If tenant not found, redirect to central registration or error page
            return redirect(config('app.url') . '/register')->withErrors('Tenant not found.');
        }

        // Set the current tenant in the session
        session()->put('current_tenant_id', $tenant->id);
        session()->put('current_tenant_slug', $tenant->slug);
        
        // Also set a global static property for easy access throughout the app
        Tenant::setGlobalTenant($tenant);

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