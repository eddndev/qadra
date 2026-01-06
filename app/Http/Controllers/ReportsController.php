<?php

namespace App\Http\Controllers;

use App\Models\LegalCase;
use App\Models\Hearing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $timeRange = $request->get('time_range', '30'); // Default to last 30 days
        $startDate = match ($timeRange) {
            'this_year' => now()->startOfYear(),
            'last_year' => now()->subYear()->startOfYear(),
            default => now()->subDays((int) $timeRange),
        };
        $endDate = $timeRange === 'last_year' ? now()->subYear()->endOfYear() : now();

        // Base query for filtered results
        $baseQuery = LegalCase::whereBetween('created_at', [$startDate, $endDate]);

        // Optional Filters
        if ($request->filled('stage')) {
            $baseQuery->where('stage', $request->stage);
        }
        if ($request->filled('court')) {
            $baseQuery->where('court_name', 'like', '%' . $request->court . '%');
        }

        // --- Summary Stats ---
        $totalCases = (clone $baseQuery)->count();
        $closedCases = (clone $baseQuery)->where('status', 'closed')->count();
        $alertCases = (clone $baseQuery)->whereHas('deadlines', function ($q) {
            $q->where('expires_at', '<', now())->where('status', '!=', 'completed');
        })->count();
        $hearingsRealized = Hearing::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'held')
            ->count();

        // --- MoM Growth Calculation (Approximate) ---
        $prevStartDate = (clone $startDate)->subDays($startDate->diffInDays($endDate));
        $prevEndDate = (clone $startDate)->subSecond();

        $prevTotal = LegalCase::whereBetween('created_at', [$prevStartDate, $prevEndDate])->count();
        $totalGrowth = $prevTotal > 0 ? (($totalCases - $prevTotal) / $prevTotal) * 100 : 0;

        $prevClosed = LegalCase::whereBetween('created_at', [$prevStartDate, $prevEndDate])->where('status', 'closed')->count();
        $closedGrowth = $prevClosed > 0 ? (($closedCases - $prevClosed) / $prevClosed) * 100 : 0;

        // --- Chart Data: New Cases per Month (Last 6 months) ---
        $casesByMonth = LegalCase::where('created_at', '>=', now()->subMonths(6))
            ->get()
            ->groupBy(fn($case) => $case->created_at->format('Y-m'))
            ->map(fn($group) => $group->count())
            ->sortKeys();

        if ($casesByMonth->isEmpty()) {
            $chartLabels = collect();
            $chartData = collect();
            // Create empty months for a better look
            for ($i = 5; $i >= 0; $i--) {
                $chartLabels->push(now()->subMonths($i)->translatedFormat('M'));
                $chartData->push(0);
            }
        } else {
            $chartLabels = $casesByMonth->keys()->map(fn($k) => Carbon::parse($k)->translatedFormat('M'));
            $chartData = $casesByMonth->values();
        }

        // --- Case Results Distribution (Pie/Donut) ---
        $resultsQuery = (clone $baseQuery)->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // Ensure all keys exist for the chart consistency
        $allStats = [
            'acuerdo' => $resultsQuery->get('closed', 0), // Mapping closed to Ganado/Acuerdo for visual
            'ganado' => $resultsQuery->get('won', 0),
            'pendiente' => $resultsQuery->get('open', 0) + $resultsQuery->get('pending', 0),
            'perdido' => $resultsQuery->get('lost', 0),
        ];

        // --- Case Details Table ---
        $cases = $baseQuery->with('deadlines')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('reports.index', [
            'totalCases' => $totalCases,
            'totalGrowth' => round($totalGrowth, 1),
            'closedCases' => $closedCases,
            'closedGrowth' => round($closedGrowth, 1),
            'alertCases' => $alertCases,
            'hearingsRealized' => $hearingsRealized,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'resultsDistribution' => $allStats,
            'cases' => $cases,
            'filters' => [
                'time_range' => $timeRange,
                'stage' => $request->stage,
                'court' => $request->court,
            ]
        ]);
    }
}
