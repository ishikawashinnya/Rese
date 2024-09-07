<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => bcrypt('testtest'),
            'email_verified_at' => Carbon::now(),
        ]);
    }
}
