<?php

namespace App\Exceptions;

use InvalidArgumentException;

class RouteAlreadyExists extends InvalidArgumentException
{
    public static function create(string $route)
    {
        return new static("A route {$route} already exists!");
    }
}
