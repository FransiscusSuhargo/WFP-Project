<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('foods')->insert([
            [
                'category_id' => 1, // Pasta
                'name' => 'Spaghetti Carbonara',
                'description' => 'Classic Italian pasta with creamy sauce and bacon.',
                'nutrition_value' => 'Calories: 400, Protein: 15g, Fat: 20g',
                'price' => 75000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1, // Pasta
                'name' => 'Lasagna',
                'description' => 'Layered pasta with meat, tomato sauce, and cheese.',
                'nutrition_value' => 'Calories: 600, Protein: 25g, Fat: 30g',
                'price' => 90000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2, // Salads
                'name' => 'Caesar Salad',
                'description' => 'Crispy romaine lettuce with Caesar dressing and croutons.',
                'nutrition_value' => 'Calories: 250, Protein: 10g, Fat: 15g',
                'price' => 45000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3, // Desserts
                'name' => 'Chocolate Lava Cake',
                'description' => 'Warm chocolate cake with a molten center.',
                'nutrition_value' => 'Calories: 500, Protein: 8g, Fat: 25g',
                'price' => 60000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 4, // Beverages
                'name' => 'Fresh Orange Juice',
                'description' => 'Freshly squeezed orange juice with no added sugar.',
                'nutrition_value' => 'Calories: 120, Protein: 2g, Fat: 0g',
                'price' => 30000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 5, // Seafood
                'name' => 'Grilled Salmon',
                'description' => 'Grilled salmon with lemon butter sauce.',
                'nutrition_value' => 'Calories: 450, Protein: 40g, Fat: 25g',
                'price' => 150000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
