<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'name' => 'Amber',
                'user_id' => 1, 
                'member_start_date' => Carbon::now()->subYear(),
                'member_end_date' => Carbon::now()->addYear(),
                'status' => 'member',
            ],
            [
                'name' => 'Michael',
                'user_id' => 2, 
                'member_start_date' => Carbon::now()->subYear(),
                'member_end_date' => Carbon::now()->addYear(),
                'status' => 'member',
            ],
            [
                'name' => 'Jackson',
                'user_id' => 3, 
                'member_start_date' => Carbon::now()->subYear(),
                'member_end_date' => Carbon::now()->addYear(),
                'status' => 'non member',
            ],
        ]);
    }
}
