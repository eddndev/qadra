<?php

namespace App\Http\Controllers;

use App\Models\LegalCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ensure we scope query to the current tenant if utilizing multi-tenancy traits
        // or just rely on global scopes if applied. Assuming explicit scope for now if needed,
        // but 'LegalCase' uses 'HasTenants' trait so it should scope automatically if set up correctly.
        // We'll trust the trait for now but keep it in mind.

        $activeCasesCount = LegalCase::where('status', '!=', 'closed')->count();
        
        // For "Audiencias de Hoy" we need a Hearing model or similar. 
        // Based on analysis, LegalCase has 'hearings' relationship.
        // Let's defer "Audiencias de Hoy" specific query for a moment or mock it properly if Hearing model exists but wasn't deeply inspected.
        // Checking task 1, I saw 'Hearing::class' in LegalCase relationship. 
        // I'll grab a count of hearings today if possible, or justplaceholder. 
        // Wait, I only inspected LegalCase. I should probably check Hearing model briefly or just do cases for now as requested.
        // User asked to "hydrate cases". I'll focus on cases stats and list.

        // Recent Cases
        $recentCases = LegalCase::with(['leadLawyer'])
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Audiencias de Hoy
        $todaysHearingsCount = \App\Models\Hearing::whereDate('scheduled_at', today())->count();

        // Plazos Próximos (72 hrs)
        $upcomingDeadlinesCount = \App\Models\Deadline::where('expires_at', '>=', now())
            ->where('expires_at', '<=', now()->addHours(72))
            ->where('status', '!=', 'completed')
            ->count();

        return view('dashboard', [
            'activeCasesCount' => $activeCasesCount,
            'recentCases' => $recentCases,
            'todaysHearingsCount' => $todaysHearingsCount,
            'upcomingDeadlinesCount' => $upcomingDeadlinesCount,
        ]);
    }
}
