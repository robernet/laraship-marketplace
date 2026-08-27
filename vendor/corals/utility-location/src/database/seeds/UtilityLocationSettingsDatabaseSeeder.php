<?php

namespace Corals\Utility\Location\database\seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UtilityLocationSettingsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            [
                'code' => 'utility_google_address_api_key',
                'type' => 'TEXT',
                'category' => 'Utilities',
                'label' => 'Google address api key',
                'value' => 'AIzaSyBrMjtZWqBiHz1Nr9XZTTbBLjvYFICPHDM',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'utility_google_address_country',
                'type' => 'TEXT',
                'category' => 'Utilities',
                'label' => 'Google address Search Country',
                'value' => '',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'utility_google_address_default_search_radius',
                'type' => 'NUMBER',
                'category' => 'Utilities',
                'label' => 'Default Search Radius',
                'value' => 50,
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'utility_location_types',
                'type' => 'SELECT',
                'label' => 'Location Types',
                'value' => '{"city":"City","state":"State","country":"Country"}',
                'editable' => 1,
                'hidden' => 0,
                'category' => 'Utilities',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
