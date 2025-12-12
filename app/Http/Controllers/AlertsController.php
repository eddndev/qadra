<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Deadline;

class AlertsController extends Controller
{
    public function index()
    {
        // Expired deadlines (past due, not completed)
        $expiredDeadlines = Deadline::with('case')
            ->where('expires_at', '<', now())
            ->where('status', '!=', 'completed')
            ->orderBy('expires_at', 'desc')
            ->take(10)
            ->get();

        // Upcoming deadlines (next 72 hours)
        $upcomingDeadlines = Deadline::with('case')
            ->where('expires_at', '>=', now())
            ->where('expires_at', '<=', now()->addHours(72))
            ->where('status', '!=', 'completed')
            ->orderBy('expires_at', 'asc')
            ->take(10)
            ->get();

        // Recent activity from the Activity model instead of hardcoded alerts
        $recentActivities = Activity::with(['legalCase', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('alerts.index', [
            'expiredDeadlines' => $expiredDeadlines,
            'upcomingDeadlines' => $upcomingDeadlines,
            'recentActivities' => $recentActivities,
        ]);
    }
}
