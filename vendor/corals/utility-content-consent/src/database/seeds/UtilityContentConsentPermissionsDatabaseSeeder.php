<?php

namespace Corals\Utility\ContentConsent\database\seeds;

use Carbon\Carbon;
use Corals\User\Models\Role;
use Illuminate\Database\Seeder;

class UtilityContentConsentPermissionsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('permissions')->insert([
            //content-consent-settings
            [
                'name' => 'UtilityContentConsent::content_consent.manage',
                'guard_name' => config('auth.defaults.guard'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);

        $member_role = Role::where('name', 'member')->first();

        if ($member_role) {
            $member_role->forgetCachedPermissions();
        }

    }
}
