<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule the DeleteExpiredInvitationsJob to run daily
Schedule::job(new \App\Jobs\DeleteExpiredInvitationsJob)->daily();

// Schedule the CheckDeadlinesJob to run daily at 8:00 AM to notify users
Schedule::job(new \App\Jobs\CheckDeadlinesJob)->dailyAt('08:00');