<?php

namespace Vivalaz\LaravelRouteRestrict\app\Exceptions;

use InvalidArgumentException;

class RouteDoesNotExistsException extends InvalidArgumentException
{

    /**
     * Throw exception when route not found by ID
     * @param int $id
     * @return RouteDoesNotExistsException
     */
    public static function byId(int $id)
    {
        return new static("There is no route with id {$id}");
    }

    /**
     * Throw exception when route not found by Route
     * @param string $route
     * @return RouteDoesNotExistsException
     */
    public static function byRoute(string $route)
    {
        return new static("There is no route with name {$route}");
    }

}