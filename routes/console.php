<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\SendDebtorReminderMail;

Schedule::command('payment:send-reminders')
    ->everyFiveMinutes()
    ->withoutOverlapping()
    ->runInBackground();

Schedule::command(SendDebtorReminderMail::class)
    ->weeklyOn(3, '08:00')
    ->timezone('Asia/Singapore');
