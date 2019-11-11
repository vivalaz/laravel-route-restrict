<?php

namespace Vivalaz\LaravelRouteRestrict\app\Http\Middleware;

use Closure;
use Vivalaz\LaravelRouteRestrict\app\Exceptions\RouteUnauthorizedException;

class RouteHasPermissionsMiddleware
{

    public function handle($request, Closure $next)
    {
        if (auth()->user()->hasRouteAccessViaPermissions($request->path())) {
            return $next($request);
        }

        throw RouteUnauthorizedException::permissions();
    }

}