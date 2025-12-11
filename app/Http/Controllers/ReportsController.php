<?php

namespace App\Http\Controllers;

use App\Models\LegalCase;
use App\Models\Hearing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        // 1. Summary Stats
        $totalCases = LegalCase::count();
        $closedCases = LegalCase::where('status', 'closed')->count();
        $alertCases = LegalCase::whereHas('deadlines', function ($q) {
            $q->where('expires_at', '<', now());
        })->count();
        $hearingsRealized = Hearing::where('status', 'held')->count();

        // 2. Chart Data: New Cases per Month (Last 6 months)
        $casesByMonth = LegalCase::select(DB::raw("COUNT(*) as count"), DB::raw("strftime('%Y-%m', created_at) as month_name"))
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month_name')
            ->orderBy('month_name')
            ->get();
        
        // Mocking if empty for prototype visualization
        if ($casesByMonth->isEmpty()) {
            $months = collect(['Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov']);
            $chartLabels = $months;
            $chartData = collect([14, 21, 18, 24, 28, 25]);
        } else {
            $chartLabels = $casesByMonth->pluck('month_name');
            $chartData = $casesByMonth->pluck('count');
        }

        // 3. Chart Data: Case Results (Distribution)
        // Mock distribution based on prototype image (Acuerdo, Ganado, Pendiente, Perdido)
        $resultsDistribution = [
            'Acuerdo' => 15,
            'Ganado' => 25,
            'Pendiente' => 50,
            'Perdido' => 10
        ];

        // 4. Case Details Table (Pagination)
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
