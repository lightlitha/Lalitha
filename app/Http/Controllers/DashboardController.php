<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Lalitha
use App\Services\LLRoute\Controller as LLController;

class DashboardController extends LLController
{
    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        return view('home');
    }
}
