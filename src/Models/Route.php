<?php

namespace Vivalaz\LaravelRouteRestrict\Models;

use Illuminate\Database\Eloquent\Model;
use Vivalaz\LaravelRouteRestrict\Exceptions\RouteAlreadyExistsException;
use Vivalaz\LaravelRouteRestrict\Exceptions\RouteDoesNotExistsException;
use Vivalaz\LaravelRouteRestrict\Helpers\Helper;

class Route extends Model
{

    protected $fillable = [
        'route',
        'name',
        'method'
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
        self::isRouteExists($attributes['route'], $attributes['method']);

        return static::query()->create($attributes);
    }

    /**
     * Find route by his id
     * @param int $id
     * @return Route
     */
    public static function findById(int $id): Route
    {
        $route = static::find($id);

        if (!$route) {
            throw RouteDoesNotExistsException::byId($id);
        }

        return $route;
    }

    /**
     * Find route by route path
     * @param string $routeName
     * @return Route
     */
    public static function findByRoute(string $routeName = '', string $method): Route
    {
        $route = static::whereRoute($routeName)->whereMethod($method)->first();

        if (!$route) {
            throw RouteDoesNotExistsException::byRoute($routeName);
        }

        return $route;
    }

    /**
     * Update route by ID
     * @param $id
     * @param array $data
     * @return bool
     */
    public static function updateById($id, array $data = [])
    {
        $route = self::findById($id);

        self::isRouteExists($data['route'], $data['method']);

        return $route->update($data);
    }

    /**
     * Sync roles for routes
     * @param array $roleIds
     * @return Route
     */
    public function syncRoles(array $roleIds = []): Route
    {
        $this->roles()->sync($roleIds);

        return $this;
    }

    /**
     * Sync permissions for routes
     * @param array $permissionIds
     * @return Route
     */
    public function syncPermissions(array $permissionIds = []): Route
    {
        $this->permissions()->sync($permissionIds);

        return $this;
    }

    /**
     * Check if route has minimum one role that intersects with user roles
     * @param array $roles
     * @return bool
     */
    public function hasRoles(array $roles = []): bool
    {
        $routeRoles = Helper::getArrayOfIds($this->roles());

        return Helper::isIntersect($routeRoles, $roles);
    }

    /**
     * Check if route has minimum one permission that intersects with user permissions
     * @param array $permissions
     * @return bool
     */
    public function hasPermissions(array $permissions = []): bool
    {
        $routePermissions = Helper::getArrayOfIds($this->permissions());

        return Helper::isIntersect($routePermissions, $permissions);
    }

    /**
     * Check if route has minimum one role or permission that intersects with user roles or permissions
     * @param array $roles
     * @param array $permissions
     * @return bool
     */
    public function hasRolesOrPermissions(array $roles = [], array $permissions = []): bool
    {
        return $this->hasRoles($roles) || $this->hasPermissions($permissions);
    }

    /**
     * Check if route exists in DB
     * @param string $route
     */
    private static function isRouteExists(string $route, string $method)
    {
        if (static::whereRoute($route)->whereMethod($method)->first()) {
            throw RouteAlreadyExistsException::create($route);
        }
    }
}