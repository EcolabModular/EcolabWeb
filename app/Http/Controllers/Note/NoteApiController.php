<?php

namespace App\Http\Controllers\Note;

use Illuminate\Http\Request;
use App\Services\EcolabService;
use App\Http\Controllers\Controller;

class NoteApiController extends Controller
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
        $response = $this->ecolabService->getAll('notes',$request->all());

        return $response->data;
    }
}
