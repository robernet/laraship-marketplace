<?php

namespace Corals\Utility\Rating\database\seeds;

use Corals\User\Communication\Models\NotificationTemplate;
use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;

class UtilityRatingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UtilityRatingPermissionsDatabaseSeeder::class);
        $this->call(UtilityRatingNotificationTemplatesSeeder::class);
        $this->call(UtilityRatingMenuDatabaseSeeder::class);
    }

    public function rollback()
    {
        Permission::where('name', 'like', 'Utility::rating%')->delete();

        NotificationTemplate::where('name', 'like', 'notifications.utility_rating%')->delete();
    }
}
