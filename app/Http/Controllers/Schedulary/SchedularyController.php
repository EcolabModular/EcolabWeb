<?php

namespace App\Http\Controllers\Schedulary;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchedularyController extends Controller
{
    public function index()
    {
        return('Hola Mundo Horarios');
        /*
        $laboratorios = $this->obtenerLaboratorios();
        //dd($categorias);
        return view('Laboratorios.index', compact('laboratorios'));
        */
    }
}
