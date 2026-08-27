<?php

namespace Corals\Utility\Webhook\database\seeds;

use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;

class UtilityWebhookDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UtilityWebhookPermissionsDatabaseSeeder::class);
        $this->call(UtilityWebhookMenuDatabaseSeeder::class);
    }

    public function rollback()
    {
        Permission::where('name', 'like', 'Utility::webhook%')->delete();
    }
}
