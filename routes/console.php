<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('db:backup-telegram')
    ->dailyAt('23.23')
    ->timezone('Asia/Jakarta');
