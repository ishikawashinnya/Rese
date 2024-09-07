<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Shop;


class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $shops = Shop::all();

        foreach ($shops as $shop) {
            foreach (range(1,30) as $index) {
                Review::factory()->create([
                    'user_id' => $users->random()->id,
                    'shop_id' => $shop->id,
                ]);
            }
        }
    }
}
