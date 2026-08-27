<?php

namespace Corals\Utility\ContentConsent\database\seeds;

use Illuminate\Database\Seeder;

class UtilityContentConsentMenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $utilities_menu_id = \DB::table('menus')->where('key', 'utility')->pluck('id')->first();

        \DB::table('menus')->insert([
                [
                    'parent_id' => $utilities_menu_id,
                    'key' => null,
                    'url' => 'utilities/content-consent-settings',
                    'active_menu_url' => 'utilities/content-consent-settings*',
                    'name' => 'Content Consent',
                    'description' => 'Content Consent Settings',
                    'icon' => 'fa fa-gear',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 50
                ],
            ]
        );
    }
}
