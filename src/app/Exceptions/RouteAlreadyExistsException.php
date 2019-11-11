<?php

namespace Vivalaz\LaravelRouteRestrict\app\Exceptions;

use InvalidArgumentException;

class RouteAlreadyExistsException extends InvalidArgumentException
{

    /**
     * Throw exception while adding route info into DB
     * @param string $route
     * @return RouteAlreadyExistsException
     */
    public static function create(string $route)
    {
        return new static("A route {$route} already exists!");
    }

}
