<?php
/**
 * Created by PhpStorm.
 * User: vital
 * Date: 09.11.2019
 * Time: 15:43
 */

namespace Vivalaz\LaravelRouteRestrict\app\Helpers;


class Helper
{

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