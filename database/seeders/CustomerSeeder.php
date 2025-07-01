<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Customer;
use App\Models\User;
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
        $user_customer = User::where('role', 'customer')->get();

        foreach ($user_customer as $user)
        {
            $cust_name = strstr($user->email, '@', true);
            $cust_name = str_replace(['.', '_', '-'], ' ', $cust_name);
            $cust_name = ucwords($cust_name);

            Customer::create([
                'name' => $cust_name,
                'user_id' => $user->id,
                'member_start_date' => Carbon::now(),
                'member_end_date' => Carbon::now()->addYear(),
                'status' => 'member'
            ]);
        }
//        DB::table('customers')->insert([
//            [
//                'name' => 'Amber',
//                'user_id' => 1,
//                'member_start_date' => Carbon::now()->subYear(),
//                'member_end_date' => Carbon::now()->addYear(),
//                'status' => 'member',
//            ],
//            [
//                'name' => 'Michael',
//                'user_id' => 2,
//                'member_start_date' => Carbon::now()->subYear(),
//                'member_end_date' => Carbon::now()->addYear(),
//                'status' => 'member',
//            ],
//            [
//                'name' => 'Jackson',
//                'user_id' => 3,
//                'member_start_date' => Carbon::now()->subYear(),
//                'member_end_date' => Carbon::now()->addYear(),
//                'status' => 'non member',
//            ],
//        ]);
    }
}
