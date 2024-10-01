<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => '管理者',
            'email' => 'admin@example.com',
            'password' => bcrypt('testadmin'),
            'email_verified_at' => now(),
        ]);

        $admin->assignRole('admin');

        $ShopRepresentative = User::create([
            'name' => '店舗代表者',
            'email' => 'shoprep@example.com',
            'password' => bcrypt('testshoprep'),
            'email_verified_at' => now(),
        ]);

        $ShopRepresentative->assignRole('shop representative');

        $user = User::create([
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => bcrypt('testuser'),
            'email_verified_at' => now(),
        ]);
    }
}
