<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 20; $i++) {
            Coupon::create([
                'code' => Str::random(10),
                'type' => 'price',
                'value' => random_int(20000, 200000),
                'min_price' => random_int(0, 2000000),
                'expired_at' => 2000000000
            ]);
        }
    }
}
