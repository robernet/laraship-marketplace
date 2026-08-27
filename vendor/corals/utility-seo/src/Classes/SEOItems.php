<?php

namespace Corals\Utility\SEO\Classes;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

class SEOItems
{
    public function getRouteManager()
    {
        $routes = [];

        foreach (Route::getRoutes()->getIterator() as $route) {
            if (in_array('api', Arr::wrap($route->action['middleware']))) {
                continue;
            }

            if (! in_array('GET', $route->methods)) {
                continue;
            }

            $routes[$route->uri] = $route->uri;
        }

        return $routes;
    }
}
