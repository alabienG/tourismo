<?php


namespace App\interfaces;


use Illuminate\Http\Request;

interface ILieu
{
    public function save(Request $request);

    public function update(Request $request, int $idLieu);

    public function likes( int $idLieu);

    public function disLikes(int $idLieu);

    public function show(int $idLieu);

    public function delete(int $idLieu);

    public function getAllLieux();

    public function getLieuByDico(int $idLieu);


}
