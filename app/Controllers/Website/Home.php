<?php

namespace App\Controllers\Website;
use App\Controllers\BaseController;

class Home extends BaseController
{

    public function __construct()
    {
        
    }

    public function index()
    {
        return view('website/home');
    }
}
