<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Review;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rating' => $this->faker->numberBetween(1,5),
            'comment' => $this->faker->realText(random_int(20,400)),
            'image_url' => null,
        ];
    }
}
