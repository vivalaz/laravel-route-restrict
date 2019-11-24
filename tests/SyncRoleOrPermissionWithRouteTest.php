<?php


namespace Vivalaz\LaravelRouteRestrict\Test;


use Vivalaz\LaravelRouteRestrict\Helpers\Helper;
use Vivalaz\LaravelRouteRestrict\Models\Route;

class SyncRoleOrPermissionWithRouteTest extends TestCase
{

    /**
     * @test
     */
    public function syncRolesToRouteTest()
    {
        $route = app(Route::class)->create([
            'route' => 'test_route',
            'method' => 'GET'
        ]);

        $route->syncRoles([$this->roleUser->id]);

        $routeRoles = app(Route::class)->findById($route->id)->roles()->pluck('id')->toArray();

        $this->assertTrue(Helper::isIntersect([$this->roleUser->id], $routeRoles));
    }

    /**
     * @test
     */
    public function syncPermissionsToRouteTest()
    {
        $route = app(Route::class)->create([
            'route' => 'test_route',
            'method' => 'GET'
        ]);

        $route->syncPermissions([$this->permissionUser->id, $this->permissionAdmin->id]);

        $routePermissions = app(Route::class)->findById($route->id)->permissions()->pluck('id')->toArray();

        $this->assertTrue(Helper::isIntersect([$this->permissionUser->id, $this->permissionAdmin->id], $routePermissions));
    }

}