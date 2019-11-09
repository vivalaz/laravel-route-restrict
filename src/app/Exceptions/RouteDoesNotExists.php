<?php

namespace Vivalaz\LaravelRouteRestrict\app\Exceptions;

use InvalidArgumentException;

class RouteDoesNotExists extends InvalidArgumentException
{

    public static function byId(int $id)
    {
        return new static("There is no route with id {$id}");
    }

    public static function byRoute(string $route)
    {
        return new static("There is no route with name {$route}");
    }

}