<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FixAmpSignature
{
    /**
     * Handle an incoming request.
     * 
     * Fixes the issue where email clients don't properly decode &amp; to & in HTML links.
     * This causes the signature parameter to be received as "amp;signature" instead of "signature".
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if we have the malformed "amp;signature" parameter
        if ($request->has('amp;signature') && !$request->has('signature')) {
            // Get the malformed signature value
            $signature = $request->query('amp;signature');

            // Build the corrected URL
            $query = $request->query();
            unset($query['amp;signature']);
            $query['signature'] = $signature;

            // Build corrected full URL
            $correctedUrl = $request->url() . '?' . http_build_query($query);

            // Redirect to the corrected URL
            return redirect($correctedUrl);
        }

        return $next($request);
    }
}
