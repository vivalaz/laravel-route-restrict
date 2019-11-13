<?php


namespace Vivalaz\LaravelRouteRestrict\Services;


use Vivalaz\LaravelRouteRestrict\Helpers\Helper;

class RouteService
{

    private $model;

    public function __construct()
    {
        $class = config('laravel-route-restrict.models.route');
        $this->model = new $class();
    }

    public function index()
    {
        return $this->model->all();
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
        return $this->model->updateById($id, $data);
    }

    public function destroy($id)
    {
        return $this->model->findById($id)->delete();
    }

    public function getProjectRoutes()
    {
        return Helper::getProjectRoutes();
    }
}