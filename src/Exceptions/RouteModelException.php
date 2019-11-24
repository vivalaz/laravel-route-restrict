<?php


namespace Vivalaz\LaravelRouteRestrict\Exceptions;


use InvalidArgumentException;

class RouteModelException extends InvalidArgumentException
{

    /**
     * @return RouteModelException
     */
    public static function emptyRoute()
    {
        return new static("Route name is not specified!");
    }

}