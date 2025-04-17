<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(6)->create();

        $this->call([
            UserSeeder::class,
            AddOnSeeder::class,
            CategorySeeder::class,
            CustomerSeeder::class,
            EmployeeSeeder::class,
            FoodSeeder::class,
            ModifierSeeder::class,
            PaymentSeeder::class,
            OrderSeeder::class,
            OrderDetailSeeder::class,
        ]);
    }
}
