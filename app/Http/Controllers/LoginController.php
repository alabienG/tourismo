<?php

namespace App\Http\Controllers;

use App\interfaces\ILogin;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    private $service;

    public function __construct(ILogin $service)
    {
        $this->service = $service;
    }


    public function register(Request $request)
    {
        return $this->service->register($request);
    }

    public function login(Request $request)
    {
        return $this->service->login($request);

    }
}
