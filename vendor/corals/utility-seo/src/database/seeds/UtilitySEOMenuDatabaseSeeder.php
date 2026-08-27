<?php

namespace Corals\Utility\SEO\database\seeds;

use Illuminate\Database\Seeder;

class UtilitySEOMenuDatabaseSeeder extends Seeder
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
                    'url' => 'utilities/seo-items',
                    'active_menu_url' => 'utilities/seo-items' . '*',
                    'name' => 'SEO Items',
                    'description' => 'SEO Items',
                    'icon' => 'fa fa-search',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0,
                ],
            ]
        );
    }
}
