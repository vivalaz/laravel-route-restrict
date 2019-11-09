<?php

namespace Vivalaz\LaravelRouteRestrict\app\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class RouteUnauthorizedException extends HttpException
{

    public static function permissions(array $permissions = [])
    {
        $message = 'This route does not have the right permissions.';

        $exception = new static(403, $message, null, []);

        return $exception;
    }

}