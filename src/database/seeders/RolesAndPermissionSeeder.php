<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //権限作成
        $manageShopPermission = Permission::create(['name' => 'manage shop']);
        $viewReservationsPermission = Permission::create(['name' => 'view reservations']);
        $createShopRepresentativePermission = Permission::create(['name' => 'create shop representative']);

        //ロールの作成と権限付与
        $adminRole = Role::create(['name'=> 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $representativeRole = Role::create(['name' => 'shop representative']);
        $representativeRole->givePermissionTo([$manageShopPermission, $viewReservationsPermission]);

    }
}
