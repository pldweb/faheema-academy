<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('db:backup-telegram')
    ->dailyAt('23.23')
    ->timezone('Asia/Jakarta');


