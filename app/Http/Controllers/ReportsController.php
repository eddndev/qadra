<?php

namespace App\Http\Controllers;

use App\Models\LegalCase;
use App\Models\Hearing;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        // Summary Stats
        $totalCases = LegalCase::count();
        $closedCases = LegalCase::where('status', 'closed')->count();
        $alertCases = LegalCase::whereHas('deadlines', function ($q) {
            $q->where('expires_at', '<', now())->where('status', '!=', 'completed');
        })->count();
        $hearingsRealized = Hearing::where('status', 'held')->count();

        // Chart Data: New Cases per Month (Last 6 months)
        // Using database-agnostic approach with Carbon for grouping
        $casesByMonth = LegalCase::where('created_at', '>=', now()->subMonths(6))
            ->get()
            ->groupBy(fn ($case) => $case->created_at->format('Y-m'))
            ->map(fn ($group) => $group->count())
            ->sortKeys();

        if ($casesByMonth->isEmpty()) {
            // Fallback placeholder data when no cases exist
            $chartLabels = collect(['Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov']);
            $chartData = collect([0, 0, 0, 0, 0, 0]);
        } else {
            $chartLabels = $casesByMonth->keys()->map(fn ($k) => \Carbon\Carbon::parse($k)->translatedFormat('M'));
            $chartData = $casesByMonth->values();
        }

        // Case Results Distribution (based on actual status field)
        $resultsDistribution = LegalCase::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Case Details Table with pagination
        $cases = LegalCase::with('deadlines')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('reports.index', [
            'totalCases' => $totalCases,
            'closedCases' => $closedCases,
            'alertCases' => $alertCases,
            'hearingsRealized' => $hearingsRealized,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'resultsDistribution' => $resultsDistribution,
            'cases' => $cases,
        ]);
    }
}
