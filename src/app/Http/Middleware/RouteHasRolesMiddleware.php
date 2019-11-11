<?php

namespace Vivalaz\LaravelRouteRestrict\app\Http\Middleware;

use Closure;
use Vivalaz\LaravelRouteRestrict\app\Exceptions\RouteUnauthorizedException;

class RouteHasRolesMiddleware
{

    public function handle($request, Closure $next)
    {
        if (auth()->user()->hasRouteAccessViaRoles($request->path())) {
            return $next($request);
        }

        throw RouteUnauthorizedException::roles();
    }

}