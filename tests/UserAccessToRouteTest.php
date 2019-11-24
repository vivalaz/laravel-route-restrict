<?php


namespace Vivalaz\LaravelRouteRestrict\Test;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Vivalaz\LaravelRouteRestrict\Middleware\RouteHasPermissionsMiddleware;
use Vivalaz\LaravelRouteRestrict\Middleware\RouteHasRolesMiddleware;
use Vivalaz\LaravelRouteRestrict\Middleware\RouteHasRolesOrPermissionsMiddleware;
use Vivalaz\LaravelRouteRestrict\Models\Route;

class UserAccessToRouteTest extends TestCase
{

    private $userRoute;
    private $adminRoute;
    private $allRoute;

    private $roleMiddleware;
    private $permissionMiddleware;
    private $roleOrPermissionsMiddleware;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRoute = app(Route::class)->create([
            'route' => 'user/route',
            'method' => 'GET'
        ]);
        $this->userRoute->syncRoles([$this->roleUser->id])->syncPermissions([$this->permissionUser->id]);

        $this->adminRoute = app(Route::class)->create([
            'route' => 'admin/route',
            'method' => 'POST'
        ]);
        $this->adminRoute->syncRoles([$this->roleAdmin->id])->syncPermissions([$this->permissionAdmin->id]);

        $this->allRoute = app(Route::class)->create([
            'route' => 'all/route',
            'method' => 'GET'
        ]);

        $this->roleMiddleware = new RouteHasRolesMiddleware();
        $this->permissionMiddleware = new RouteHasPermissionsMiddleware();
        $this->roleOrPermissionsMiddleware = new RouteHasRolesOrPermissionsMiddleware();

    }

    /**
     * @test
     */
    public function userHasAccessToRoute()
    {
        //todo:
//        Auth::login($this->testUser);
//
//        $router = $this->getRouter();
//
//        $router->get('user/route', $this->getRouteResponse())->middleware([RouteHasRolesMiddleware::class]);
//
//        $this->call('GET', 'admin/route');
//
//        $this->assertResponseOk();
    }

    /**
     * @test
     */
    public function userDoesNotHaveAccessToRoute()
    {
        //todo:
//        Auth::login($this->testUser);
    }

    protected function getRouter()
    {
        return app('router');
    }

    protected function getRouteResponse()
    {
        return function () {
            return (new Response())->setContent('<html></html>');
        };
    }

}