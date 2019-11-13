<?php

namespace Vivalaz\LaravelRouteRestrict\Exceptions;

use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RouteUnauthorizedException extends HttpException
{

    /**
     * Throw exception when authorization failed by permissions
     * @return RouteUnauthorizedException
     */
    public static function permissions()
    {
        $message = 'This route does not have the right permissions for you!';

        $exception = new static(Response::HTTP_FORBIDDEN, $message, null, []);

        return $exception;
    }

    /**
     * Throw exception when authorization failed by roles
     * @return RouteUnauthorizedException
     */
    public static function roles()
    {
        $message = 'This route does not have the right roles for you!';

        $exception = new static(Response::HTTP_FORBIDDEN, $message, null, []);

        return $exception;
    }

    /**
     * Throw exception when authorization failed by roles or permissions
     * @return RouteUnauthorizedException
     */
    public static function rolesOrPermissions()
    {
        $message = 'This route does not have the right roles or permissions for you!';

        $exception = new static(Response::HTTP_FORBIDDEN, $message, null, []);

        return $exception;
    }

}