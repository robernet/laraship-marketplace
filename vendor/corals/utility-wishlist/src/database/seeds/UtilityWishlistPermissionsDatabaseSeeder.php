<?php

namespace Corals\Utility\Wishlist\database\seeds;

use Carbon\Carbon;
use Corals\User\Models\Role;
use Illuminate\Database\Seeder;

class UtilityWishlistPermissionsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('permissions')->insert([
            //wish lists
            [
                'name' => 'Utility::my_wishlist.access',
                'guard_name' => config('auth.defaults.guard'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        $member_role = Role::where('name', 'member')->first();

        if ($member_role) {
            $member_role->forgetCachedPermissions();
            $member_role->givePermissionTo('Utility::my_wishlist.access');
        }
    }
}
