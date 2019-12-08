<?php


namespace Vivalaz\LaravelRouteRestrict\Exceptions;


use InvalidArgumentException;

class RouteModelException extends InvalidArgumentException
{

    const ROUTE_NAME_NOT_SPECIFIED = "Route name attribute is not specified!";
    const ROUTE_METHOD_NOT_SPECIFIED = "Route method attribute is not specified!";

    /**
     * @return RouteModelException
     */
    public static function routeNameNotSpecified()
    {
        return new static(self::ROUTE_NAME_NOT_SPECIFIED);
    }

    /**
     * @return RouteModelException
     */
    public static function routeMethodNotSpecified()
    {
        return new static(self::ROUTE_METHOD_NOT_SPECIFIED);
    }

}