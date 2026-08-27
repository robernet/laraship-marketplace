<?php

namespace Corals\Modules\Subscriptions\Middleware;

use Closure;
use Corals\Modules\Subscriptions\Models\Subscription;

class CanSubscripeMiddleware
{

    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next,)
    {
        if (user()->cannot('Subscriptions::subscriptions.subscribe', Subscription::class)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }


}
