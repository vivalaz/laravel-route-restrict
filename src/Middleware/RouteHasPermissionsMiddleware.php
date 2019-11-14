<?php

namespace Vivalaz\LaravelRouteRestrict\Middleware;

use Closure;
use Vivalaz\LaravelRouteRestrict\Exceptions\RouteUnauthorizedException;

class RouteHasPermissionsMiddleware
{

    public function handle($request, Closure $next)
    {
        if (auth()->user()->hasRouteAccessViaPermissions($request->path(), $request->method())) {
            return $next($request);
        }

        throw RouteUnauthorizedException::permissions();
    }

}