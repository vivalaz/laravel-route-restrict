<?php

namespace Vivalaz\LaravelRouteRestrict\Traits;

use Vivalaz\LaravelRouteRestrict\Exceptions\RouteDoesNotExistsException;
use Vivalaz\LaravelRouteRestrict\Helpers\Helper;
use Vivalaz\LaravelRouteRestrict\Models\Route;

trait HasRouteAccess
{

    public function hasRouteAccessViaRoles(string $requestRoute = '', string $method)
    {
        $userRoles = Helper::getArrayOfIds($this->roles());

        try {
            return Route::findByRoute($requestRoute, $method)->hasRoles($userRoles);
        } catch (RouteDoesNotExistsException $exception) {
            return true;
        }
    }

    public function hasRouteAccessViaPermissions(string $requestRoute = '', string $method)
    {
        $userPermissions = Helper::getArrayOfIds($this->permissions());

        try {
            return Route::findByRoute($requestRoute, $method)->hasPermissions($userPermissions);
        } catch (RouteDoesNotExistsException $exception) {
            return true;
        }
    }

    public function hasRouteAccessViaRolesOrPermissions(string $requestRoute = '', string $method)
    {
        $userRoles = Helper::getArrayOfIds($this->roles());
        $userPermissions = Helper::getArrayOfIds($this->permissions());

        try {
            return Route::findByRoute($requestRoute, $method)->hasRolesOrPermissions($userRoles, $userPermissions);
        } catch (RouteDoesNotExistsException $exception) {
            return true;
        }
    }

}