<?php

namespace App\Http\Controllers\Report;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Services\EcolabService;
use App\Http\Controllers\Controller;

class ReportController extends Controller
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
    public function index()
    {
        $reports = $this->ecolabService->getAll('reports');

        foreach($reports as $report){
            //$report->reportType_id = $this->ecolabService->getOne('dictionaries',$report->reportType_id)->dictionaryType;
            switch($report->reportType_id){
                case 1:
                    $report->reportType_id = 'Reporte Preventivo';
                break;
                case 2:
                    $report->reportType_id = 'Reporte Correctivo';
                break;
                case 3:
                    $report->reportType_id = 'Reporte Predictivo';
                break;
            }
        }
        return view('Reportes.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $TypeArray = [
            1 => 'Reporte Preventivo',
            2 => 'Reporte Correctivo',
            3 => 'Reporte Predictivo'
        ];
        return view('Reportes.form', compact('TypeArray'));
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hasFile = false;
/*
        return redirect()
            ->route('reports.show',
                [
                    $data->id,
                ])
            ->with('success', ['Created successfully']);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $report = $this->ecolabService->getOne('reports',$id);

        return view('reports.show')->with([
            'report' => $report
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
        $report = $this->ecolabService->getOne('reports',$id);
        return view('Reportes.form', compact('report'));
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
        $hasFile = false;
        $report = $this->ecolabService->update("reports/{$id}", $request->all(), $hasFile);
        $message = 'Updated successfully';

        return view('reports.show')->with([
            'report' => $report,
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
        $this->ecolabService->delete('reports',$id);
        $reports = $this->ecolabService->getAll('reports');
        $message = 'Deleted successfully';
        return view('reports.index')
            ->with([
                'reports' => $reports,
                'success' => $message
            ]);
    }
}
