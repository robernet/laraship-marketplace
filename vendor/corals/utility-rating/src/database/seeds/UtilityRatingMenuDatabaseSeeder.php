<?php

namespace Corals\Utility\Rating\database\seeds;

use Illuminate\Database\Seeder;

class UtilityRatingMenuDatabaseSeeder extends Seeder
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
                    'url' => config('utility-rating.models.rating.resource_url'),
                    'active_menu_url' => config('utility-rating.models.rating.resource_url') . '*',
                    'name' => 'Ratings',
                    'description' => 'Ratings List Menu Item',
                    'icon' => 'fa fa-star',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0,
                ],

            ]
        );
    }
}
