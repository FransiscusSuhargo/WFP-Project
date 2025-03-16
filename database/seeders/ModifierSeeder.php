<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModifierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('modifiers')->insert([
            [
                'name' => 'Extra Cheese',
                'price' => 10000,
                'type' => 'ingredients'
            ],
            [
                'name' => 'Spicy Sauce',
                'price' => 5000,
                'type' => 'ingredients'
            ],
            [
                'name' => 'Double Meat',
                'price' => 20000,
                'type' => 'ingredients'
            ],
            [
                'name' => 'Large Portion',
                'price' => 15000,
                'type' => 'portion'
            ],
            [
                'name' => 'Small Portion',
                'price' => 0,
                'type' => 'portion'
            ],
        ]);
    }
}
