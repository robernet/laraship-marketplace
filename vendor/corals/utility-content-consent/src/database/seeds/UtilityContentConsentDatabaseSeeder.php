<?php

namespace Corals\Utility\ContentConsent\database\seeds;

use Corals\Menu\Models\Menu;
use Corals\Settings\Models\Setting;
use Corals\User\Communication\Models\NotificationTemplate;
use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;
use \Spatie\MediaLibrary\MediaCollections\Models\Media;

class UtilityContentConsentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UtilityContentConsentPermissionsDatabaseSeeder::class);
        $this->call(UtilityContentConsentMenuDatabaseSeeder::class);
        $this->call(UtilityContentConsentSettingsDatabaseSeeder::class);
        $this->call(UtilityContentConsentNotificationTemplatesSeeder::class);

    }

    public function rollback()
    {
        Permission::where('name', 'like', 'UtilityContentConsent::%')->delete();
        Permission::where('name', 'Administrations::admin.utility')->delete();

        Menu::where('key', 'utility')
            ->orWhere('active_menu_url', 'like', 'utilitys%')
            ->orWhere('url', 'like', 'utilitys%')
            ->delete();
    }
}
