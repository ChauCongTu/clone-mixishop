<?php

namespace Database\Seeders;

use App\Models\ProductComment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $productId = 3;
            $userId = $faker->numberBetween(110, 120) ?: null;

            ProductComment::create([
                'product_id' => $productId,
                'user_id' => $userId,
                'avatar' => $faker->imageUrl(), // You can customize this as needed
                'name' => $faker->name,
                'content' => $faker->sentence(10),
                'reply_id' => null, // You may customize this if replies are needed
            ]);
        }
    }
}
