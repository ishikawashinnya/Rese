<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AreasTableSeeder::class);
        $this->call(GenresTableSeeder::class);
        $this->call(ShopsTableSeeder::class);

        $this->call(TestUserSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(ReviewSeeder::class);
        
        

        // \App\Models\User::factory(10)->create();
    }
}
