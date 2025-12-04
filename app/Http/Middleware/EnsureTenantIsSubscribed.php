<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Tenant;

class EnsureTenantIsSubscribed
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = Tenant::getGlobalTenant();

        // 1. Si no hay tenant identificado (login global o error), dejar pasar o manejar error.
        // Asumimos que EnsureTenantScope ya corrió antes.
        if (!$tenant) {
            return $next($request);
        }

        // 2. Excepciones: Rutas a las que SIEMPRE pueden entrar (Billing, Logout, Perfil)
        if ($request->routeIs('billing.*') || 
            $request->routeIs('profile.*') || 
            $request->routeIs('logout') ||
            $request->routeIs('team.index')) { // Permitir ver equipo para invitar? O bloquear todo? Mejor bloquear.
            return $next($request);
        }

        // 3. Verificar Trial
        if ($tenant->onTrial()) {
            return $next($request);
        }

        // 4. Verificar Suscripción Activa (incluye periodo de gracia si canceló pero no ha expirado)
        if ($tenant->subscribed('default')) {
            // Opcional: Verificar si el pago falló (past_due)
            if ($tenant->subscription('default')->hasIncompletePayment()) {
                return redirect()->route('billing.index')->with('error', 'Tu último pago falló. Por favor actualiza tu tarjeta.');
            }
            return $next($request);
        }

        // 5. Si llegó aquí, no tiene acceso.
        return redirect()->route('billing.index')->with('error', 'Tu periodo de prueba terminó o no tienes una suscripción activa. Por favor selecciona un plan.');
    }
}