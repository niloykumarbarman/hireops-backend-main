<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Default Inspire Command
|--------------------------------------------------------------------------
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


/*
|--------------------------------------------------------------------------
| Automation Scheduler
|--------------------------------------------------------------------------
|
| This scheduler will automatically generate monthly salaries
| for all employees using the custom artisan command.
|
*/

Schedule::command('salary:generate')->monthly();