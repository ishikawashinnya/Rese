<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Reservation;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => 3,
            'shop_id' => 1,
            'reservation_date' => Carbon::today(),
            'reservation_time' => '18:00:00',
            'reservation_num' => 2,
            'status' => '来店済み',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => 3,
            'shop_id' => 2,
            'reservation_date' => Carbon::today()->addDays(),
            'reservation_time' => '19:00:00',
            'reservation_num' => 3,
            'status' => '予約',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => 3,
            'shop_id' => 2,
            'reservation_date' => Carbon::today()->addDays(2),
            'reservation_time' => '20:00:00',
            'reservation_num' => 3,
            'status' => '予約',
        ];
        DB::table('reservations')->insert($param);

        foreach (range(1, 20) as $shopId) {
            Reservation::factory()->count(15)->create([
                'shop_id' => $shopId
            ]);
        }
    }
}
