<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class DebugSignature
{
    /**
     * Handle an incoming request.
     * DEBUG ONLY - Remove after fixing signature issue.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log everything about the current request related to signature validation
        Log::info('DebugSignature: Request Info', [
            'url' => $request->url(),
            'fullUrl' => $request->fullUrl(),
            'host' => $request->getHost(),
            'path' => $request->path(),
            'query' => $request->query(),
            'signature_param' => $request->query('signature'),
            'expires_param' => $request->query('expires'),
        ]);

        // Manually compute what the signature should be for comparison
        $ignoreQuery = ['signature'];
        $url = $request->url();
        $queryWithoutSig = collect($request->query())->except($ignoreQuery)->toArray();
        ksort($queryWithoutSig); // Sort for consistency
        $original = rtrim($url . '?' . http_build_query($queryWithoutSig), '?');

        Log::info('DebugSignature: Signature Base String', [
            'base_string' => $original,
        ]);

        // Check if signature is valid using Laravel's built-in method
        $hasValidSignature = URL::hasValidSignature($request);
        Log::info('DebugSignature: Validation Result', [
            'has_valid_signature' => $hasValidSignature,
        ]);

        return $next($request);
    }
}
