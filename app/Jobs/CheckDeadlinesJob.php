<?php

namespace App\Jobs;

use App\Models\Deadline;
use App\Notifications\DeadlineApproachingNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckDeadlinesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Find pending deadlines
        // We iterate through all active tenants conceptually, but since this runs in background,
        // we can just query all pending deadlines regardless of tenant, 
        // assuming the relationships (case->leadLawyer) are correct.
        // Note: TenantScoped might apply global scope if not careful. 
        // In jobs, usually auth is not set, so global scope "tenant" (checking auth) won't apply filters,
        // which is GOOD here because we want to check ALL deadlines system-wide.
        
        $deadlines = Deadline::with(['case.leadLawyer'])
            ->where('status', 'pendiente')
            ->where('expires_at', '>', now()) // Not already expired
            ->get();

        Log::info("CheckDeadlinesJob: Checking " . $deadlines->count() . " pending deadlines.");

        foreach ($deadlines as $deadline) {
            $config = $deadline->reminder_config;
            if (!$config || !isset($config['days_before']) || !is_array($config['days_before'])) {
                continue;
            }

            $daysLeft = (int) now()->diffInDays($deadline->expires_at, false);
            
            Log::info("Deadline {$deadline->id} (Title: {$deadline->title}): Expires at {$deadline->expires_at} (Now: " . now() . "). Days left: {$daysLeft}. Config: " . json_encode($config['days_before']));
            
            // If daysLeft is negative, it's expired (handled by query above, but double check)
            // If daysLeft is 0, it means same day (less than 24h, but date part diff is 0)
            
            // Special check for exact day matching if we run this daily at 8 AM.
            // Carbon diffInDays rounds down. 
            // If expires_at is tomorrow 10am, and now is today 8am. Diff is 1 day and 2 hours -> 1 day.
            // If expires_at is today 5pm, and now is today 8am. Diff is 9 hours -> 0 days.
            
            if (in_array($daysLeft, $config['days_before'])) {
                // Prevent duplicate notifications for same day?
                // Ideally we should track "last_notified_at" or similar.
                // For MVP, assuming job runs ONCE per day prevents most dupes.
                // Or we can use cache lock.
                
                $lawyer = $deadline->case->leadLawyer;
                
                if ($lawyer) {
                    Log::info("Sending notification for deadline {$deadline->id} to user {$lawyer->id}");
                    $lawyer->notify(new DeadlineApproachingNotification($deadline, $daysLeft));
                }
            }
        }
    }
}