<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantScope
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = Tenant::getGlobalTenant();

        if (!$tenant) {
            // If no tenant is identified in the context, we can't scope access.
            // Depending on the app logic, this might be a 404 or redirect to central home.
            abort(404, 'No workspace found.');
        }

        if (auth()->check()) {
            $user = auth()->user();
            
            // Check if user belongs to this tenant using the HasTenants trait method
            if (!$user->belongsToTenant($tenant)) {
                abort(403, 'You do not have access to this workspace.');
            }
            
            // Optional: Check if the user is active in this tenant
            // $pivot = $user->tenants->find($tenant->id)->pivot;
            // if (!$pivot->is_active) {
            //     auth()->logout();
            //     return redirect()->route('login')->withErrors('Your access to this workspace has been deactivated.');
            // }
        }

        return $next($request);
    }
}