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
                'image' => "https://www.allrecipes.com/thmb/Vg2cRidr2zcYhWGvPD8M18xM_WY=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/11973-spaghetti-carbonara-ii-DDMFS-4x3-6edea51e421e4457ac0c3269f3be5157.jpg", 
                'name' => 'Spaghetti Carbonara',
                'description' => 'Classic Italian pasta with creamy sauce and bacon.',
                'nutrition_value' => 'Calories: 400, Protein: 15g, Fat: 20g',
                'price' => 75000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                "image" => "https://newmansown.com/wp-content/uploads/2022/03/Homemade-lasagna-1200x675.png", // Pasta
                'name' => 'Lasagna',
                'description' => 'Layered pasta with meat, tomato sauce, and cheese.',
                'nutrition_value' => 'Calories: 600, Protein: 25g, Fat: 30g',
                'price' => 90000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2, // Salads
                "image" => "https://www.feastingathome.com/wp-content/uploads/2021/10/Caesar-salad_-4.jpg",
                'name' => 'Caesar Salad',
                'description' => 'Crispy romaine lettuce with Caesar dressing and croutons.',
                'nutrition_value' => 'Calories: 250, Protein: 10g, Fat: 15g',
                'price' => 45000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3, // Desserts
                "image" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTqfuLtObCclDCWUvXi2w0g12lmHY5ramkyYQ&s",
                'name' => 'Oat Cookies',
                'description' => 'Oat cookies are chewy, wholesome treats made with rolled oats.',
                'nutrition_value' => 'Calories: 150, Protein: 8g, Fat: 10g',
                'price' => 25000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 4, // Beverages
                "image" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ1kKTXfptyHt2VxVVqO5iHxBb9qyKP2cQ9uQ&s",
                'name' => 'Fresh Orange Juice',
                'description' => 'Freshly squeezed orange juice with no added sugar.',
                'nutrition_value' => 'Calories: 120, Protein: 2g, Fat: 0g',
                'price' => 30000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 5, // Seafood
                "image" => "https://res.cloudinary.com/hksqkdlah/image/upload/41765-sfs-grilled-salmon-10664.jpg",
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
