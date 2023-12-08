<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i < 50; $i++) {
            Banner::create([
                'url_image' => 'https://shop.mixigaming.com/wp-content/uploads/2023/01/A%CC%89nh-bia-mixishop-1-scaled.jpg'
            ]);
        }
    }
}
