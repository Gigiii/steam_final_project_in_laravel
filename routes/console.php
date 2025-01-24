<?php

use App\Console\Commands\NotifyUsersOfGameSales;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command(NotifyUsersOfGameSales::class)->dailyAt(18);
