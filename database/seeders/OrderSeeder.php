<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'payment_id' => 1,
                'customer_id' => 1,
                'date' => Carbon::now()->subMonths(6),
                'queue_number' => 'A001',
                'type' => 'Dine-in',
                'status' => 'finished'
            ],
            [
                'payment_id' => 2,
                'customer_id' => 1,
                'date' => Carbon::now()->subMonths(3),
                'queue_number' => 'A004',
                'type' => 'Takeaway',
                'status' => 'finished'
            ],
            [
                'payment_id' => 3,
                'customer_id' => 1,
                'date' => Carbon::now(),
                'queue_number' => 'A005',
                'type' => 'Takeaway',
                'status' => 'ready'
            ],
            
            [
                'payment_id' => 2,
                'customer_id' => 2,
                'date' => Carbon::now(),
                'queue_number' => 'A002',
                'type' => 'Takeaway',
                'status' => 'process'
            ],
            [
                'payment_id' => 3,
                'customer_id' => 3,
                'date' => Carbon::now(),
                'queue_number' => 'A003',
                'type' => 'Dine-in',
                'status' => 'finished'
            ]
        ]);
    }
}
