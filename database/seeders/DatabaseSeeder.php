<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::create([
            'email' => "test@gmail.com",
            'password' => Hash::make('password123'),
            'role' => "customer"
        ]);

        User::create([
            'email' => "employee@gmail.com",
            'password' => Hash::make('password123'),
            'role' => "employee"
        ]);

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
