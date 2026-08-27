<?php

namespace Corals\Utility\Webhook\database\seeds;

use Illuminate\Database\Seeder;

class UtilityWebhookMenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $utilities_menu_id = \DB::table('menus')->where('key', 'utility')->pluck('id')->first();


        \DB::table('menus')->insert(
            [
                [
                    'parent_id' => $utilities_menu_id,
                    'key' => null,
                    'url' => 'utilities/webhooks',
                    'active_menu_url' => 'utilities/webhooks' . '*',
                    'name' => 'Webhooks',
                    'description' => 'Webhooks',
                    'icon' => 'fa fa-anchor',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0,
                ],
            ]
        );
    }
}
