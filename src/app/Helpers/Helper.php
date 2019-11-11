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

}