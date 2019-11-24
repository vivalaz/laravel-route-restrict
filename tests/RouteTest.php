<?php


namespace Vivalaz\LaravelRouteRestrict\Test;


use Vivalaz\LaravelRouteRestrict\Exceptions\RouteAlreadyExistsException;
use Vivalaz\LaravelRouteRestrict\Models\Route;

class RouteTest extends TestCase
{

    /**
     * @test
     */
    public function routeAlreadyExistsExceptionTest()
    {
        $this->expectException(RouteAlreadyExistsException::class);

        app(Route::class)->create([
            'route' => 'test_route',
            'method' => 'GET'
        ]);

        app(Route::class)->create([
            'route' => 'test_route',
            'method' => 'GET'
        ]);
    }

}