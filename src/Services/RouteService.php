<?php


namespace Vivalaz\LaravelRouteRestrict\Services;


use Vivalaz\LaravelRouteRestrict\Helpers\Helper;

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
        return $this->model->findById($id);
    }

    public function store(array $data = [])
    {
        return $this->model::create($data);
    }

    public function update(int $id, array $data = [])
    {
        return $this->model->findById($id)->update($data);
    }

    public function destroy($id)
    {
        return $this->model->findById($id)->destroy();
    }

    public function getProjectRoutes()
    {
        return Helper::getProjectRoutes();
    }
}