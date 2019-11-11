<?php

namespace Vivalaz\LaravelRouteRestrict\app\Http\Middleware;

use Closure;
use Vivalaz\LaravelRouteRestrict\Exceptions\RouteUnauthorizedException;

class RouteHasRolesOrPermissionsMiddleware
{

    public function handle($request, Closure $next)
    {
        if (auth()->user()->hasRouteAccessViaRolesOrPermissions($request->path())) {
            return $next($request);
        }

        throw RouteUnauthorizedException::rolesOrPermissions();
    }

}