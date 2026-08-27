<?php

namespace Corals\Modules\Payment\Common\Widgets;

use Corals\Modules\Payment\Common\Charts\MonthlyRevenue;
use Corals\Modules\Payment\Common\Models\Invoice;

class MonthlyRevenueWidget
{
    public function __construct()
    {
    }

    public function run($args)
    {
        $connection = config('database.default');

        if ($connection === 'mysql') {
            $dateFormatMethod = 'DATE_FORMAT';
            $dateFormat = "'%M %Y'";
        } else if ($connection === 'pgsql') {
            $dateFormatMethod = 'TO_CHAR';
            $dateFormat = "'MM-YY'";
        }

        $data = Invoice::where('status', 'paid')->select(
            \DB::raw('sum(total) as sums'),
            \DB::raw("$dateFormatMethod(due_date, $dateFormat) as months")
        )
            ->groupBy('months')
            ->pluck('sums', 'months')->toArray();


        $chart = new MonthlyRevenue();
        $chart->labels(array_keys($data));
        $chart->dataset(trans('Payment::labels.widgets.monthly_revenue'), 'bar', array_values($data));

        $chart->options([
            'plugins' => '{
                    colorschemes: {
                        scheme: \'brewer.Paired12\'
                    }
                }',
        ]);

        return view('Corals::chart')->with(['chart' => $chart])->render();
    }
}
