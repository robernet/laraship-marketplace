<?php

namespace Corals\Utility\Location\database\seeds;

use Illuminate\Database\Seeder;

class UtilityLocationMenuDatabaseSeeder extends Seeder
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
                    'url' => config('utility-location.models.location.resource_url'),
                    'active_menu_url' => config('utility-location.models.location.resource_url') . '*',
                    'name' => 'Locations',
                    'description' => 'Locations List Menu Item',
                    'icon' => 'fa fa-map-o',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0,
                ],
            ]
        );
    }
}
