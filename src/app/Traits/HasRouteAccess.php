<?php

namespace Vivalaz\LaravelRouteRestrict\app\Traits;

use Vivalaz\LaravelRouteRestrict\Exceptions\RouteDoesNotExistsException;
use Vivalaz\LaravelRouteRestrict\Helpers\Helper;
use Vivalaz\LaravelRouteRestrict\Models\Route;

trait HasRouteAccess
{

    public function hasRouteAccessViaRoles(string $requestRoute = '')
    {
        $userRoles = Helper::getArrayOfIds($this->roles());

        try {
            return Route::findByRoute($requestRoute)->hasRoles($userRoles);
        } catch (RouteDoesNotExistsException $exception) {
            return true;
        }
    }

    public function hasRouteAccessViaPermissions(string $requestRoute = '')
    {
        $userPermissions = Helper::getArrayOfIds($this->permissions());

        try {
            return Route::findByRoute($requestRoute)->hasPermissions($userPermissions);
        } catch (RouteDoesNotExistsException $exception) {
            return true;
        }
    }

    public function hasRouteAccessViaRolesOrPermissions(string $requestRoute = '')
    {
        $userRoles = Helper::getArrayOfIds($this->roles());
        $userPermissions = Helper::getArrayOfIds($this->permissions());

        try {
            return Route::findByRoute($requestRoute)->hasRolesOrPermissions($userRoles, $userPermissions);
        } catch (RouteDoesNotExistsException $exception) {
            return true;
        }
    }

}