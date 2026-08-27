<?php

namespace Corals\Utility\Category\database\seeds;

use Illuminate\Database\Seeder;

class UtilityCategoryMenuDatabaseSeeder extends Seeder
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
                    'url' => 'utilities/categories',
                    'active_menu_url' => 'utilities/categories' . '*',
                    'name' => 'Categories',
                    'description' => 'categories List Menu Item',
                    'icon' => 'fa fa-folder-open',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0,
                ],
                [
                    'parent_id' => $utilities_menu_id,
                    'key' => null,
                    'url' => 'utilities/attributes',
                    'active_menu_url' => 'utilities/attributes' . '*',
                    'name' => 'Attributes',
                    'description' => 'Attributes List Menu Item',
                    'icon' => 'fa fa-sliders',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0,
                ],
            ]
        );
    }
}
