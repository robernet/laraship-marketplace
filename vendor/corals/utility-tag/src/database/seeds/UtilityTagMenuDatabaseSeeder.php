<?php

namespace Corals\Utility\Tag\database\seeds;

use Illuminate\Database\Seeder;

class UtilityTagMenuDatabaseSeeder extends Seeder
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
                'url' => config('utility-tag.models.tag.resource_url'),
                'active_menu_url' => config('utility-tag.models.tag.resource_url') . '*',
                'name' => 'Tags',
                'description' => 'Tags List Menu Item',
                'icon' => 'fa fa-tags',
                'target' => null,
                'roles' => '["1"]',
                'order' => 0,
            ],
            ]
        );
    }
}
