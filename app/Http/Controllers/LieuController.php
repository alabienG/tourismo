<?php

namespace App\Http\Controllers;

use App\interfaces\ILieu;
use App\Models\Lieu;
use Illuminate\Http\Request;

class LieuController extends Controller
{
    private $service;

    public function __construct(ILieu $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->service->getAllLieux();
    }

    public function lieuxByDico(int $idDico)
    {
        return $this->service->getLieuByDico($idDico);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->service->save($request);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Lieu $lieu
     * @return \Illuminate\Http\Response
     */
    public function show(int $lieu)
    {
        return $this->service->show($lieu);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Lieu $lieu
     * @return \Illuminate\Http\Response
     */
    public function edit(Lieu $lieu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lieu $lieu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $lieu)
    {
        return $this->service->update($request, $lieu);
    }

    /**
     * likes the specified resource in storage.
     *
     * @param $idLieu
     * @return \Illuminate\Http\Response
     */

    public function likes(int $idLieu)
    {
        return $this->service->likes($idLieu);
    }

    public function dislikes(int $idLieu)
    {
        return $this->service->disLikes($idLieu);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Lieu $lieu
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $lieu)
    {
        return $this->service->delete($lieu);
    }
}
