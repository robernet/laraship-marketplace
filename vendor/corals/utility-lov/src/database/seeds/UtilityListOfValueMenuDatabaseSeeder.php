<?php

namespace Corals\Utility\ListOfValue\database\seeds;

use Illuminate\Database\Seeder;

class UtilityListOfValueMenuDatabaseSeeder extends Seeder
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
                    'url' => 'utilities/list-of-values',
                    'active_menu_url' => 'utilities/list-of-values' . '*',
                    'name' => 'List Of Values',
                    'description' => 'List Of Values',
                    'icon' => 'fa fa-list',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0,
                ],

            ]
        );
    }
}
