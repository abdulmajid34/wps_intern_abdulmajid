<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $director = Employee::create([
            'name' => 'Director Name',
            'email' => 'director@mail.com',
            'password' => bcrypt('director123'),
            'position' => 'Director',
        ]);

        $managerOps = Employee::create([
            'name' => 'Ops Manager Name',
            'email' => 'opsManager@mail.com',
            'password' => bcrypt('opsManager123'),
            'position' => 'Manager Operasional',
            'supervisor_id' => $director->id,
        ]);

        $managerFin = Employee::create([
            'name' => 'Finance Manager Name',
            'email' => 'financeManager@mail.com',
            'password' => bcrypt('financeManager123'),
            'position' => 'Manager Keuangan',
            'supervisor_id' => $director->id,
        ]);

        Employee::create([
            'name' => 'Ops Staff Name',
            'email' => 'opsStaff@mail.com',
            'password' => bcrypt('opsStaff123'),
            'position' => 'Staff Operasional',
            'supervisor_id' => $managerOps->id,
        ]);

        Employee::create([
            'name' => 'Finance Staff Name',
            'email' => 'financeStaff@mail.com',
            'password' => bcrypt('financeStaff123'),
            'position' => 'Staff Keuangan',
            'supervisor_id' => $managerFin->id,
        ]);
    }
}
