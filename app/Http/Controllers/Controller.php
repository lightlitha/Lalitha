<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Database\Eloquent\Model;

use Modules\Lalitha\Http\Client\Navigation;

use View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $items = new Navigation();
        $navigation = $items->design($items->getClientRoutes('main'));
        View::share ('navitems', $navigation );
    }

    public function navigate_model(Model $model, $route) : array
    {
        $items = new Navigation();
        return $items->getClientModelRoutes($model, $route);
    }
}
