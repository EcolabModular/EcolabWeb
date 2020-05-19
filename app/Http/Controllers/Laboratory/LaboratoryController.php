<?php

namespace App\Http\Controllers\Laboratory;

use Illuminate\Http\Request;
use App\Laboratory;
use App\Http\Controllers\Controller;

class LaboratoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return('Hola Mundo');
        /*
        $laboratorios = $this->obtenerLaboratorios();
        //dd($categorias);
        return view('Laboratorios.index', compact('laboratorios'));
        */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Laboratorios.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return redirect()->route('laboratories.show', $laboratory);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laboratory  $laboratory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $laboratorio = $this->obtenerLaboratorio($id);
        $items = $this->obtenerLaboratorioItems($id);
        return view('Laboratorios.show', compact('laboratorio','items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laboratory  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Laboratory $laboratory)
    {
        return view('Laboratorios.show', compact('laboratory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laboratory  $laboratory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Laboratory $laboratory)
    {
        return redirect()->route('laboratories.show', $laboratory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laboratory  $laboratory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Laboratory $laboratory)
    {
        //
    }

    protected function obtenerLaboratorios()
    {
        /*
        $accessToken = 'Bearer ' . $this->obtenerAccessToken();

        $respuesta = $this->realizarPeticion('GET', 'ecolab.test/api/laboratories', [
                'headers' => ['Authorization' => $accessToken]
            ]);
        $datos = json_decode($respuesta);
        $laboratorios = $datos->data;
        return collect($laboratorios);
        */
    }

    protected function obtenerLaboratorio($id)
    {
        /*
        $accessToken = 'Bearer ' . $this->obtenerAccessToken();

        $respuesta = $this->realizarPeticion('GET', 'ecolab.test/api/laboratories' . $id, [
                'headers' => ['Authorization' => $accessToken]
            ]);
        $datos = json_decode($respuesta);
        return $datos->data;
        */
    }
    protected function obtenerLaboratorioItems($id)
    {
        /*
        $accessToken = 'Bearer ' . $this->obtenerAccessToken();

        $respuesta = $this->realizarPeticion('GET', 'ecolab.test/api/laboratories' . $id . '/items', [
                'headers' => ['Authorization' => $accessToken]
            ]);
        $datos = json_decode($respuesta);
        return $datos->data;
        */
    }
}
