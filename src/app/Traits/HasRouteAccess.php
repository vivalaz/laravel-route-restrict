<?php

namespace Vivalaz\LaravelRouteRestrict\app\Traits;


use Vivalaz\LaravelRouteRestrict\app\Exceptions\RouteDoesNotExists;
use Vivalaz\LaravelRouteRestrict\app\Helpers\Helper;
use Vivalaz\LaravelRouteRestrict\Models\Route;

trait HasRouteAccess
{

    public function hasRouteAccessViaRoles(string $requestRoute = '')
    {
        $userRoles = Helper::getArrayOfIds($this->roles());

        try {
            return Route::findByRoute($requestRoute)->hasPermissions($userRoles);
        } catch (RouteDoesNotExists $exception) {
            return true;
        }
    }

    public function hasRouteAccessViaPermissions(string $requestRoute = '')
    {
        $userPermissions = Helper::getArrayOfIds($this->permissions());

        try {
            return Route::findByRoute($requestRoute)->hasPermissions($userPermissions);
        } catch (RouteDoesNotExists $exception) {
            return true;
        }
    }

    public function hasRouteAccessViaRolesOrPermissions()
    {

    }

}