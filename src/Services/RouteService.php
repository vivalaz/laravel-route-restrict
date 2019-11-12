<?php


namespace Vivalaz\LaravelRouteRestrict\Services;


class RouteService
{

    private $model;

    public function __construct()
    {
        $this->model = config('laravel-route-restrict.models.route');
    }

    public function index()
    {
        return $this->model::all();
    }

    public function show($id)
    {

    }

    public function store(array $data = [])
    {

    }

    public function update(int $id, array $data = [])
    {

    }

    public function destroy($id)
    {

    }
}