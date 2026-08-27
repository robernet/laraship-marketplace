<?php

namespace Corals\Utility\Location\database\seeds;

use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;

class UtilityLocationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UtilityLocationPermissionsDatabaseSeeder::class);
        $this->call(UtilityLocationMenuDatabaseSeeder::class);
        $this->call(UtilityLocationSettingsDatabaseSeeder::class);
    }

    public function rollback()
    {
        Permission::where('name', 'like', 'Utility::location%')->delete();
    }
}
