<?php

namespace App\Http\Controllers\Item;

use Illuminate\Http\Request;
use App\Services\EcolabService;
use App\Http\Controllers\Controller;

class ItemApiController extends Controller
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
        $response = $this->ecolabService->getAll('items',$request->all());

        return $response->data;
    }
    public function show($item)
    {
        $response = $this->ecolabService->getOne('items',$item);
        return $response->data;
    }

    public function edit(){

    }

    public function update(){

    }

    public function create(){

    }

    public function store(){

    }

    public function destroy(){

    }
}
