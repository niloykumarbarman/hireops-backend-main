<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use App\Models\Salary;
use Carbon\Carbon;

class GenerateMonthlySalary extends Command
{
    protected $signature = 'salary:generate';

    protected $description = 'Generate monthly salary for all employees';

    public function handle()
    {

        $employees = Employee::all();

        foreach ($employees as $employee) {

            Salary::create([
                'employee_id' => $employee->id,
                'amount' => $employee->salary,
                'salary_date' => Carbon::now(),
                'note' => 'Auto generated salary'
            ]);

        }

        $this->info('Monthly salary generated successfully.');

    }
}