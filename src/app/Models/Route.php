<?php

namespace Vivalaz\LaravelRouteRestrict\Models;

use App\Exceptions\RouteAlreadyExists;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{

    protected $fillable = [
        'route',
        'name'
    ];

    /**
     * A route may be given various roles.
     */
    public function roles()
    {
        return $this->belongsToMany(
            config('permission.models.role'),
            config('laravel-route-restrict.table_names.route_for_roles'),
            'route_id',
            'role_id'
        );
    }

    /**
     * A route may be given various permissions.
     */
    public function permissions()
    {
        return $this->belongsToMany(
            config('permission.models.permission'),
            config('laravel-route-restrict.table_names.route_for_permissions'),
            'route_id',
            'permission_id'
        );
    }

    /**
     * Override Eloquent's default create function
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Builder|Model
     */
    public static function create(array $attributes = [])
    {
        if (static::whereRoute($attributes['route'])->first()) {
            throw RouteAlreadyExists::create($attributes['route']);
        }

        return static::query()->create($attributes);
    }

}