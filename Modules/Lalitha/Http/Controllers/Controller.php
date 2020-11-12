<?php

namespace Modules\Lalitha\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use View;

//You can create a BaseController:

class Controller extends BaseController {

  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}