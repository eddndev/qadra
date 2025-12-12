<?php

namespace App\Http\Controllers;

use App\Models\LegalCase;
use App\Models\Deadline;
use App\Models\Hearing;

class DashboardController extends Controller
{
    public function index()
    {
        // Active cases (all non-closed cases scoped to tenant via HasTenants trait)
        $activeCasesCount = LegalCase::where('status', '!=', 'closed')->count();

        // Recent cases with lead lawyer relationship
        $recentCases = LegalCase::with('leadLawyer')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Today's hearings
        $todaysHearingsCount = Hearing::whereDate('scheduled_at', today())->count();

        // Upcoming deadlines (next 72 hours, pending only)
        $upcomingDeadlinesCount = Deadline::where('expires_at', '>=', now())
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
