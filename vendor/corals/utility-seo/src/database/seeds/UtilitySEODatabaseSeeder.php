<?php

namespace Corals\Utility\SEO\database\seeds;

use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;

class UtilitySEODatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UtilitySEOPermissionsDatabaseSeeder::class);
        $this->call(UtilitySEOMenuDatabaseSeeder::class);
    }

    public function rollback()
    {
        Permission::where('name', 'like', 'Utility::seo%')->delete();
    }
}
