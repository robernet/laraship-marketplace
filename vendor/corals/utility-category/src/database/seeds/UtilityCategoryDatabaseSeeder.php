<?php

namespace Corals\Utility\Category\database\seeds;

use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;

class UtilityCategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UtilityCategoryPermissionsDatabaseSeeder::class);
        $this->call(UtilityCategoryMenuDatabaseSeeder::class);
    }

    public function rollback()
    {
        Permission::where('name', 'like', 'Utility::category%')->delete();
    }
}
