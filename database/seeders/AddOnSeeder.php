<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddOnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('addons')->insert([
            [
                'name' => 'Extra Cheese',
                'price' => 7000
            ],
            [
                'name' => 'Spicy Sauce',
                'price' => 3000
            ],
            [
                'name' => 'No Lettuce',
                'price' => 3000
            ]
        ]);
    }
}
