<?php

namespace Corals\Modules\Subscriptions\database\seeds;

use Illuminate\Database\Seeder;
use Corals\Modules\Subscriptions\Models\Plan;
use Corals\Modules\Subscriptions\Models\Feature;

class FeaturePlanTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('feature_plan')->delete();

        $plans = Plan::query()->get();

        $features = Feature::query()->get();

        foreach ($plans as $index => $plan) {
            foreach ($features as $feature) {
                \DB::table('feature_plan')->insert([
                    'plan_id' => $plan->id,
                    'feature_id' => $feature->id,
                    'value' => $index >= count($feature->properties) ? $feature->properties[count($feature->properties) - 1] : $feature->properties[$index],
                ]);

            }
        }
    }
}
