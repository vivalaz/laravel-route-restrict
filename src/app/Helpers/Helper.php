<?php

namespace Vivalaz\LaravelRouteRestrict\app\Helpers;

class Helper
{

    /**
     * Get all project routes with params
     * @return array
     */
    public static function getProjectRoutes()
    {
        return collect(\Route::getRoutes())->map(function ($route) {
            return [
                'uri' => $route->uri,
                'methods' => $route->methods,
                'action' => $route->action
            ];
        })->toArray();
    }

    /**
     * Get array plucked by IDs
     * @param $data
     * @return array
     */
    public static function getArrayOfIds($data): array
    {
        return $data->pluck('id')->toArray();
    }

    /**
     * Check if route and user permissions are intersect
     * @param array $routePermissions
     * @param array $userPermissions
     * @return bool
     */
    public static function isIntersect(array $routePermissions = [], array $userPermissions = [])
    {
        $intersected = array_intersect($routePermissions, $userPermissions);

        return count($intersected) > 0 ? true : false;
    }

}