<?php

namespace Vivalaz\LaravelRouteRestrict\Middleware;

use Closure;
use Vivalaz\LaravelRouteRestrict\Exceptions\RouteUnauthorizedException;

class RouteHasRolesOrPermissionsMiddleware
{

    public function handle($request, Closure $next)
    {
        if (auth()->user()->hasRouteAccessViaRolesOrPermissions($request->path(), $request->method())) {
            return $next($request);
        }

        throw RouteUnauthorizedException::rolesOrPermissions();
    }

}