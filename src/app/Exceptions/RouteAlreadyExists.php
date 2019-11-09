<?php

namespace Vivalaz\LaravelRouteRestrict\app\Exceptions;

use InvalidArgumentException;

class RouteAlreadyExists extends InvalidArgumentException
{
    public static function create(string $route)
    {
        return new static("A route {$route} already exists!");
    }
}
