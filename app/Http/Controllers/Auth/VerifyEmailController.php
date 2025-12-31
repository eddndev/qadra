<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectBasedOnRole($request->user());
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->redirectBasedOnRole($request->user());
    }

    protected function redirectBasedOnRole($user): RedirectResponse
    {
        // 1. If user has no tenants, go to Portal
        if ($user->tenants->isEmpty()) {
            return redirect()->route('portal')->with('verified', true);
        }

        // 2. If user has tenants, go to the latest tenant's dashboard
        $tenant = $user->tenants->sortByDesc('created_at')->first();

        $centralDomain = config('app.url');
        $domainHost = parse_url($centralDomain, PHP_URL_HOST) ?? $centralDomain;
        $protocol = request()->secure() ? 'https://' : 'http://';

        $tenantUrl = $protocol . $tenant->slug . '.' . $domainHost . '/dashboard?verified=1';

        return redirect($tenantUrl);
    }
}
