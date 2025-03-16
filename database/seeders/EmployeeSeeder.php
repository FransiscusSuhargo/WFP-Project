<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            [
                'name' => 'Adit',
                'user_id' => '4',
            ],
            [
                'name' => 'Dodit',
                'user_id' => '5',
            ],
            [
                'name' => 'Mika',
                'user_id' => '6',
            ]
        ]);
    }
}
