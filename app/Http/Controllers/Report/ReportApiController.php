<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Services\EcolabService;
use App\Http\Controllers\Controller;

class ReportApiController extends Controller
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
        $response = $this->ecolabService->getAll('reports',$request->all());
        $report = $response->data;

        foreach($report as &$r){
            switch($r->reportType_id){
                case 1:
                    $r->tipo = 'Reporte Preventivo';
                break;
                case 2:
                    $r->tipo = 'Reporte Correctivo';
                break;
                case 3:
                    $r->tipo = 'Reporte Predictivo';
                break;
            }
        }
        
        return $report;
    }
}
