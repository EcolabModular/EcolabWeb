<?php

namespace App\Http\Controllers\Schedulary;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Services\EcolabService;
use App\Http\Controllers\Controller;

class SchedularyController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EcolabService $ecolabService)
    {
        parent::__construct($ecolabService);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('Calendarios.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typeArray = [
            1 => 'Reporte Preventivo',
            2 => 'Reporte Correctivo',
            3 => 'Reporte Predictivo'
        ];
        $laboratories = $this->ecolabService->getAll('laboratories',["per_page"=>100])->data;
        $laboratoriesArray = Arr::pluck($laboratories, 'name','id');
        return view('Actividades.form', compact('typeArray','laboratoriesArray','typeArray'));
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $this->ecolabService->create('schedularies', $request->all(), false);

        return $data;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $schedulary = $this->ecolabService->getOne('schedularies',$id);
        return view('Actividades.show')->with([
            'schedulary' => $schedulary
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        // Validar si es administrador
        $schedulary = $this->ecolabService->getOne('schedularies',$id);

        return view('Actividades.show')->with([
            'schedulary' => $schedulary
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $schedulary = $this->ecolabService->update("schedularies/{$id}", $request->all(), false);

        $message = 'Updated successfully';

        return view('Reportes.show')->with([
            'schedulary' => $schedulary,
            'success' => $message
        ]);
    }

    /**
     * Delete the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->ecolabService->delete('schedularies',$id);
        return view('Calendarios.index');
    }
}
