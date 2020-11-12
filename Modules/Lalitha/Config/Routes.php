<?php

namespace Modules\Lalitha\Config;
use Illuminate\Database\Eloquent\Model;

trait Routes
{

  public function getAllClientRoutes() : array
  {
    return ClientRoutes::client_routes();
  }

  public function getClientRoutes($route) : array
  {
    $routes = ClientRoutes::client_routes();
    return $routes[$route];
  }

  public function getClientModelRoutes(Model $model, $route) : array
  {
    $client_routes = [];
    foreach ($this->getClientRoutes($route) as $key => $value) {
      $value['param'] = $model;
      $client_routes[] = $value;
    }
    return $client_routes;
  }
}