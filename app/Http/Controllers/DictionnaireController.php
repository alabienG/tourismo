<?php

namespace App\Http\Controllers;

use App\interfaces\IDictionnaire;
use App\Models\Dictionnaire;
use Illuminate\Http\Request;

class DictionnaireController extends Controller
{

    private $service;

    public function __construct(IDictionnaire $service)
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
        return $this->service->all();
    }

    public function getAllChildrens($idDico)
    {
        return $this->service->childrens($idDico);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        return $this->service>
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
     * @param \App\Models\Dictionnaire $dictionnaire
     * @return \Illuminate\Http\Response
     */
    public function show($dictionnaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Dictionnaire $dictionnaire
     * @return \Illuminate\Http\Response
     */
    public function edit($dictionnaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Dictionnaire $dictionnaire
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $dictionnaire)
    {
        return $this->service->update($request, $dictionnaire);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Dictionnaire $dictionnaire
     * @return \Illuminate\Http\Response
     */
    public function destroy($dictionnaire)
    {
        return $this->service->delete($dictionnaire);
    }
}
