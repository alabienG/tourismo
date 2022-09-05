<?php


namespace App\interfaces;


use Illuminate\Http\Request;

interface IDictionnaire
{

    public function save(Request $request);

    public function update(Request $request, int $idDico);

    public function delete(int $idDico);

    public function all();

    public function childrens($idDico);
}
