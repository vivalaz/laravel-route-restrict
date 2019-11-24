<?php


namespace Vivalaz\LaravelRouteRestrict\Test;


use Vivalaz\LaravelRouteRestrict\Exceptions\RouteAlreadyExistsException;
use Vivalaz\LaravelRouteRestrict\Exceptions\RouteModelException;
use Vivalaz\LaravelRouteRestrict\Models\Route;

class RouteModelTest extends TestCase
{

    /**
     * @test
     */
    public function successfulRouteSaveTest()
    {
        $route = app(Route::class)->create([
            'route' => 'test_route',
            'method' => 'GET'
        ]);

        $this->assertEquals(
            $route->id,
            app(Route::class)->findById($route->id)->id
        );
    }

    /**
     * @test
     */
    public function emptyRouteCreatingExceptionTest()
    {
        $this->expectException(RouteModelException::class);

        app(Route::class)->create([
            'route' => '',
            'method' => 'GET'
        ]);
    }

    /**
     * @test
     */
    public function emptyRouteUpdatingExceptionTest()
    {
        $route = app(Route::class)->create([
            'route' => 'test_route',
            'method' => 'GET'
        ]);

        $this->expectException(RouteModelException::class);

        app(Route::class)->findById($route->id)->update([
            'route' => ''
        ]);

    }

    /**
     * @test
     */
    public function routeAlreadyExistsExceptionTest()
    {
        $this->expectException(RouteAlreadyExistsException::class);

        $testArray = [
            'route' => 'test_route',
            'method' => 'GET'
        ];

        app(Route::class)->create($testArray);
        app(Route::class)->create($testArray);
    }

    /**
     * @test
     */
    public function routeNameAttributeNotSpecifiedException()
    {
        $this->expectExceptionMessage(RouteModelException::ROUTE_NAME_NOT_SPECIFIED);

        app(Route::class)->create([
            'method' => 'GET'
        ]);
    }

    /**
     * @test
     */
    public function routeMethodAttributeNotSpecifiedException()
    {
        $this->expectExceptionMessage(RouteModelException::ROUTE_METHOD_NOT_SPECIFIED);

        app(Route::class)->create([
            'route' => 'test_route'
        ]);
    }

    /**
     * @test
     */
    public function routeNameAttributeUpdateNotSpecifiedException()
    {
        $route = app(Route::class)->create([
            'route' => 'test',
            'method' => 'GET'
        ]);

        $this->expectExceptionMessage(RouteModelException::ROUTE_NAME_NOT_SPECIFIED);

        app(Route::class)->findById($route->id)->update([
            'route' => '',
            'method' => 'POST'
        ]);
    }

    /**
     * @test
     */
    public function routeMethodAttributeUpdateNotSpecifiedException()
    {
        $route = app(Route::class)->create([
            'route' => 'test',
            'method' => 'POST'
        ]);

        $this->expectExceptionMessage(RouteModelException::ROUTE_METHOD_NOT_SPECIFIED);

        app(Route::class)->findById($route->id)->update([
            'method' => NULL
        ]);
    }

}