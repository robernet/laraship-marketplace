<?php

namespace Corals\Modules\Subscriptions\Widgets;

use Corals\Modules\Subscriptions\Charts\SubscriptionRatio;
use Corals\Modules\Subscriptions\Models\Subscription;

class SubscriptionRatioWidget
{

    function __construct()
    {
    }

    function run($args)
    {


        $data = Subscription::query()
            ->selectRaw('count(*) as subscriptions_count , plans.name')
            ->join('plans', 'plans.id', '=', 'subscriptions.plan_id')
            ->where('subscriptions.status', 'active')
            ->havingRaw("'subscriptions_count' > ? ", [0])
            ->groupBy('plans.id')
            ->get()->pluck('subscriptions_count', 'name')->toArray();


        $chart = new SubscriptionRatio();
        $chart->labels(array_keys($data));
        $chart->dataset(trans('Subscriptions::labels.widget.subscription'), 'pie', array_values($data));

        $chart->options([
            'plugins' => '{
                    colorschemes: {
                        scheme: \'brewer.Paired12\'
                    }
                }'
        ]);


        return view('Corals::chart')->with(['chart' => $chart])->render();


    }

}
