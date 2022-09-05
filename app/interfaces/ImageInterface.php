<?php


namespace App\interfaces;


use Illuminate\Http\Request;

interface ImageInterface
{

    public function addImage(Request $request, $idLieu);

}
