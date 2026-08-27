<?php

namespace Corals\Utility\Comment\database\seeds;

use Corals\User\Communication\Models\NotificationTemplate;
use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;

class UtilityCommentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UtilityCommentPermissionsDatabaseSeeder::class);
        $this->call(UtilityCommentNotificationTemplatesSeeder::class);
        $this->call(UtilityCommentMenuDatabaseSeeder::class);
    }

    public function rollback()
    {
        Permission::where('name', 'like', 'Utility::comment%')->delete();

        NotificationTemplate::where('name', 'like', 'notifications.utility_comment%')->delete();
    }
}
