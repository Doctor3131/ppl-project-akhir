<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command("inspire", function () {
    $this->comment(Inspiring::quote());
})->purpose("Display an inspiring quote");

/**
 * Schedule the seller activity check command to run daily at 1:00 AM
 * This will:
 * - Send H-7 warning emails to sellers inactive for 23+ days
 * - Auto-deactivate sellers inactive for 30+ days
 */
Schedule::command('sellers:check-activity')
    ->daily()
    ->at('01:00')
    ->description('Check seller activity and send warnings/deactivate inactive accounts')
    ->withoutOverlapping()
    ->emailOutputOnFailure(env('ADMIN_EMAIL', 'admin@campusmarket.com'));

