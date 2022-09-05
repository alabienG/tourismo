<?php


namespace App\interfaces;


use Illuminate\Http\Request;

interface ILogin
{

    public function login(Request $request);

    public function register(Request $request);

}
