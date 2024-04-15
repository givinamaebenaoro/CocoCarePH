<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CouponSeeder extends Seeder
{
    public function run()
    {
        // Clear existing coupons
        DB::table('coupons')->truncate();

        // Seed new coupons
        DB::table('coupons')->insert([
            [
                'code' => 'abc123',
                'status' => 'active',
                'type' => 'fixed',
                'value' => 300,
            ],
            [
                'code' => Str::random(6), // Generate a random 6-character code
                'status' => 'active',
                'type' => 'percent',
                'value' => 10,
            ],
            // Add more coupons as needed
        ]);
    }
}
