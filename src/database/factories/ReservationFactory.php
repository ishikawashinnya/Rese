<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $reservation_date = Carbon::today()->addDays($this->faker->numberBetween(0, 7));
        $reservation_time = $this->faker->dateTimeBetween('17:00:00', '22:00:00')->format('H:i:s');

        return [
            'user_id' => $this->faker->numberBetween(4, 18),
            'shop_id' => $this->faker->numberBetween(1, 20),
            'reservation_date' => $reservation_date,
            'reservation_time' => $reservation_time,
            'reservation_num' => $this->faker->numberBetween(1, 5),
            'status' => '予約'
        ];
    }
}
