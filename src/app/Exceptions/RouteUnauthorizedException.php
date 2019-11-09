<?php

namespace Vivalaz\LaravelRouteRestrict\app\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class RouteUnauthorizedException extends HttpException
{

    public static function permissions()
    {
        $message = 'This route does not have the right permissions for you!';

        $exception = new static(403, $message, null, []);

        return $exception;
    }

    public static function roles() {
        $message = 'This route does not have the right roles for you!';

        $exception = new static(403, $message, null, []);

        return $exception;
    }

}