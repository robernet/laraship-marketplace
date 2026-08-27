<?php

namespace Corals\Utility\Comment\database\seeds;

use Illuminate\Database\Seeder;

class UtilityCommentMenuDatabaseSeeder extends Seeder
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
                    'url' => config('utility-comment.models.comment.resource_url'),
                    'active_menu_url' => config('utility-comment.models.comment.resource_url') . '*',
                    'name' => 'Comments',
                    'description' => 'Comments List Menu Item',
                    'icon' => 'fa fa-comment',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0,
                ],

            ]
        );
    }
}
