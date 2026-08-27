<?php

namespace Corals\Utility\Webhook\database\seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UtilityWebhookPermissionsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('permissions')->insert([
            //webhook
            [
                'name' => 'Utility::webhook.delete',
                'guard_name' => config('auth.defaults.guard'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Utility::webhook.view',
                'guard_name' => config('auth.defaults.guard'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Utility::webhook.process',
                'guard_name' => config('auth.defaults.guard'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
