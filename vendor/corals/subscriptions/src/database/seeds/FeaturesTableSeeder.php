<?php

namespace Corals\Modules\Subscriptions\database\seeds;

use Illuminate\Database\Seeder;

class FeaturesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('features')->delete();

        \DB::table('features')->insert(array(
            0 =>
                array(
                    'name' => 'Available Space',
                    'caption' => 'Available Space',
                    'description' => 'Available Space',
                    'product_id' => 1,
                    'status' => 'active',
                    'type' => 'quantity',
                    'display_order' => 1,
                    'unit' => 'MB',
                    'properties' => json_encode(['100', '10', '25', '1000']),
                    'deleted_at' => NULL,
                    'created_at' => '2017-11-30 12:26:06',
                    'updated_at' => '2017-12-04 14:25:47',
                ),
            1 =>
                array(
                    'name' => 'Forms',
                    'caption' => 'Forms',
                    'description' => 'Number of forms can be created',
                    'product_id' => 1,
                    'status' => 'active',
                    'type' => 'quantity',
                    'display_order' => 2,
                    'unit' => NULL,
                    'properties' => json_encode(['5', '25', '100', '1000']),
                    'deleted_at' => NULL,
                    'created_at' => '2017-11-30 12:37:32',
                    'updated_at' => '2017-11-30 14:03:58',
                ),
            2 =>
                array(
                    'name' => 'Monthly Form Views',
                    'caption' => 'Monthly Form Views',
                    'description' => 'Maximum number of Views Per form',
                    'product_id' => 1,
                    'status' => 'active',
                    'type' => 'quantity',
                    'display_order' => 3,
                    'unit' => NULL,
                    'properties' => json_encode(['1000', '1000', '10000', '100000','100000']),
                    'deleted_at' => NULL,
                    'created_at' => '2017-11-30 12:38:08',
                    'updated_at' => '2017-11-30 16:01:10',
                ),
            3 =>
                array(
                    'name' => 'Total Submission Storage',
                    'caption' => 'Total Submission Storage',
                    'description' => 'Total Submission Storage',
                    'product_id' => 1,
                    'status' => 'active',
                    'type' => 'text',
                    'display_order' => 4,
                    'unit' => NULL,
                    'properties' => json_encode(['1000', '1000', '10000', 'Unlimited']),
                    'deleted_at' => NULL,
                    'created_at' => '2017-11-30 12:38:43',
                    'updated_at' => '2017-12-04 14:25:18',
                ),
            4 =>
                array(
                    'name' => 'Reporting',
                    'caption' => 'Reporting',
                    'description' => 'Reporting',
                    'product_id' => 1,
                    'status' => 'active',
                    'type' => 'text',
                    'display_order' => 5,
                    'unit' => NULL,
                    'properties' => json_encode(['Basic', 'Intermediate', 'Advanced', 'Advanced']),
                    'deleted_at' => NULL,
                    'created_at' => '2017-11-30 12:39:40',
                    'updated_at' => '2017-12-04 14:25:47',
                ),
            5 =>
                array(
                    'name' => 'SSL Secure Submissions',
                    'caption' => 'SSL Secure Submissions',
                    'description' => 'SSL Secure Submissions',
                    'product_id' => 1,
                    'status' => 'active',
                    'type' => 'boolean',
                    'display_order' => 6,
                    'unit' => NULL,
                    'properties' => json_encode(['0','1','1']),
                    'deleted_at' => NULL,
                    'created_at' => '2017-11-30 12:43:12',
                    'updated_at' => '2017-12-04 14:25:47',
                ),
            6 =>
                array(
                    'name' => 'Users',
                    'caption' => 'Users',
                    'description' => 'The number of user accounts allowed.',
                    'product_id' => 2,
                    'status' => 'active',
                    'type' => 'quantity',
                    'display_order' => 1,
                    'unit' => NULL,
                    'properties' => json_encode(['5','100','200']),
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-03 19:10:01',
                    'updated_at' => '2017-12-03 19:10:01',
                ),
            7 =>
                array(
                    'name' => 'Google Integration',
                    'caption' => 'Google Integration',
                    'description' => 'Streamlined to work with the entire portfolio of G Suite Apps, including Gmail, Calendar, Hangouts, Sheets, and Drive.',
                    'product_id' => 2,
                    'status' => 'active',
                    'type' => 'boolean',
                    'display_order' => 2,
                    'unit' => NULL,
                    'properties' => json_encode(['1','0']),
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-03 19:11:46',
                    'updated_at' => '2017-12-03 19:11:46',
                ),
            8 =>
                array(
                    'name' => 'Storage Space',
                    'caption' => 'Storage Space',
                    'description' => 'Space available to store files and documents in ProsperWorks.',
                    'product_id' => 2,
                    'status' => 'active',
                    'type' => 'quantity',
                    'display_order' => 3,
                    'unit' => 'GB',
                    'properties' => json_encode(['2','20','2000']),
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-03 19:12:21',
                    'updated_at' => '2017-12-03 19:12:21',
                ),
            9 =>
                array(
                    'name' => 'API',
                    'caption' => 'API',
                    'description' => 'Leverage our API to connect your systems directly .',
                    'product_id' => 2,
                    'status' => 'active',
                    'type' => 'boolean',
                    'display_order' => 4,
                    'unit' => NULL,
                    'properties' => json_encode(['1','1','1']),
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-03 19:12:58',
                    'updated_at' => '2017-12-03 19:12:58',
                ),
            10 =>
                array(
                    'name' => 'Records',
                    'caption' => 'Records',
                    'description' => 'A record is any entity such as a Lead, Contact, Opportunity, Company, or Project.',
                    'product_id' => 2,
                    'status' => 'active',
                    'type' => 'quantity',
                    'display_order' => 5,
                    'unit' => NULL,
                    'properties' => json_encode(['30000','100000','199998']),
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-03 19:14:17',
                    'updated_at' => '2017-12-03 19:14:17',
                ),
            11 =>
                array(
                    'name' => 'Disk Space',
                    'caption' => 'Disk Space',
                    'description' => 'max allowed storage disk',
                    'product_id' => 3,
                    'status' => 'active',
                    'type' => 'quantity',
                    'display_order' => 1,
                    'unit' => 'GB',
                    'properties' => json_encode(['100','1000','5000','10000']),
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-04 11:05:48',
                    'updated_at' => '2017-12-04 11:05:48',
                ),
            12 =>
                array(
                    'name' => 'Monthly Traffic',
                    'caption' => 'Monthly Traffic',
                    'description' => 'Max allowed monthly traffic',
                    'product_id' => 3,
                    'status' => 'active',
                    'type' => 'quantity',
                    'display_order' => 2,
                    'unit' => 'TB',
                    'properties' => json_encode(['1','10','5','100']),
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-04 11:06:29',
                    'updated_at' => '2017-12-04 11:06:29',
                ),
            13 =>
                array(
                    'name' => 'Subdomains',
                    'caption' => 'Subdomains',
                    'description' => 'Max # of subdomains',
                    'product_id' => 3,
                    'status' => 'active',
                    'type' => 'quantity',
                    'display_order' => 3,
                    'unit' => NULL,
                    'properties' => json_encode(['5','10','10','1000']),
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-04 11:07:13',
                    'updated_at' => '2017-12-04 11:08:17',
                ),
            14 =>
                array(
                    'name' => 'Email Accounts',
                    'caption' => 'Email Accounts',
                    'description' => 'Email Accounts',
                    'product_id' => 3,
                    'status' => 'active',
                    'type' => 'quantity',
                    'display_order' => 4,
                    'unit' => NULL,
                    'properties' => json_encode(['5','10','20','1000']),
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-04 11:07:36',
                    'updated_at' => '2017-12-04 11:08:17',
                ),
            15 =>
                array(
                    'name' => 'Webmail Support',
                    'caption' => 'Webmail Support',
                    'description' => 'Webmail Support',
                    'product_id' => 3,
                    'status' => 'active',
                    'type' => 'boolean',
                    'display_order' => 5,
                    'unit' => NULL,
                    'properties' => json_encode(['1','1','1']),
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-04 11:08:13',
                    'updated_at' => '2017-12-04 11:08:17',
                ),
            16 =>
                array(
                    'name' => 'Performance Class',
                    'caption' => 'Performance Class',
                    'description' => 'Performance Class',
                    'product_id' => 3,
                    'status' => 'active',
                    'type' => 'text',
                    'display_order' => 6,
                    'unit' => NULL,
                    'properties' => json_encode(['Basic','Basic','High','High']),
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-04 11:08:45',
                    'updated_at' => '2017-12-04 11:08:45',
                ),
        ));


    }
}
