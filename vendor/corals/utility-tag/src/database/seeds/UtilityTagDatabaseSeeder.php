<?php

namespace Corals\Utility\Tag\database\seeds;

use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;

class UtilityTagDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UtilityTagPermissionsDatabaseSeeder::class);
        $this->call(UtilityTagMenuDatabaseSeeder::class);
    }

    public function rollback()
    {
        Permission::where('name', 'like', 'Utility::tag%')->delete();
    }
}
