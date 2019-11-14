<?php

namespace Vivalaz\LaravelRouteRestrict\Middleware;

use Closure;
use Vivalaz\LaravelRouteRestrict\Exceptions\RouteUnauthorizedException;

class RouteHasRolesMiddleware
{

    public function handle($request, Closure $next)
    {
        if (auth()->user()->hasRouteAccessViaRoles($request->path(), $request->method())) {
            return $next($request);
        }

        throw RouteUnauthorizedException::roles();
    }

}