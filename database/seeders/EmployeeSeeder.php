<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employee_user = User::where('role', 'employee')->get();

        foreach ($employee_user as $user)
        {
            $employee_name = strstr($user->email, '@', true);
            $employee_name = str_replace(['.', '_', '-'], ' ', $employee_name);
            $employee_name = ucwords($employee_name);

            Employee::create([
                'name' => $employee_name,
                'user_id' => $user->id
            ]);
        }
//        DB::table('employees')->insert([
//            [
//                'name' => 'Adit',
//                'user_id' => '4',
//            ],
//            [
//                'name' => 'Dodit',
//                'user_id' => '5',
//            ],
//            [
//                'name' => 'Mika',
//                'user_id' => '6',
//            ]
//        ]);
    }
}
