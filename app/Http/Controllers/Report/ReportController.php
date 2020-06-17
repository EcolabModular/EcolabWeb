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
    public function index(Request $request)
    {
        $response = $this->ecolabService->getAll('reports',$request->all());

        $reports = $response->data;

        $numOfpages = $response->last_page;
        $current_page = $response->current_page;
        $total = $response->total;
        $from = $response->from;
        $to = $response->to;
        $per_page = $response->per_page;
        $next_page = $current_page+1;
        $previous_page = $current_page-1;

        $query_str = parse_url($response->first_page_url,PHP_URL_QUERY);
        parse_str($query_str, $query_params);
        $query_params['page']="";
        $page_url = "";
        $i=1;
        foreach($query_params as $index => $value){
            if($i>1){
                $page_url .= "&" . $index ."=". $value;
            }else{
                $page_url .= $index ."=". $value;
            }
            $i++;
        }

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
        return view('Reportes.index', compact('reports','numOfpages','current_page','total','from','to','next_page','previous_page','per_page','page_url'));
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
        return view('Reportes.form', compact('typeArray'));
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'min:5',
            'description' => 'min:10'

        ];

        $this->validate($request, $rules);

        $data = $this->ecolabService->create('reports', $request->all(), false);

        return redirect()
            ->route('reports.show',
                [
                    $data->id,
                ])
            ->with('success', ['Created successfully']);

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
        $report->reportType_id = $this->ecolabService->getOne('dictionaries',$report->reportType_id)->meaning;
        return view('Reportes.show')->with([
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

        $typeArray = [
            1 => 'Reporte Preventivo',
            2 => 'Reporte Correctivo',
            3 => 'Reporte Predictivo'
        ];

        $typeArrayStatus = [
            'regular'   => 'regular',
            'urgente'   => 'urgente',
            'archivado' => 'archivado',
            'atendido'  => 'atendido',
            'cancelado' => 'cancelado'
        ];

        return view('Reportes.form', compact('report','typeArray','typeArrayStatus'));
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
        $report = $this->ecolabService->update("reports/{$id}", $request->all(), false);
        $report->reportType_id = $this->ecolabService->getOne('dictionaries',$report->reportType_id)->meaning;
        $message = 'Updated successfully';

        return view('Reportes.show')->with([
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
        $response = $this->ecolabService->getAll('reports');

        $reports = $response->data;

        $numOfpages = $response->last_page;
        $current_page = $response->current_page;
        $total = $response->total;
        $from = $response->from;
        $to = $response->to;
        $per_page = $response->per_page;
        $next_page = $current_page+1;
        $previous_page = $current_page-1;

        $query_str = parse_url($response->first_page_url,PHP_URL_QUERY);
        parse_str($query_str, $query_params);
        $query_params['page']="";
        $page_url = "";
        $i=1;
        foreach($query_params as $index => $value){
            if($i>1){
                $page_url .= "&" . $index ."=". $value;
            }else{
                $page_url .= $index ."=". $value;
            }
            $i++;
        }


        $message = 'Deleted successfully';
        return view('Reportes.index')
            ->with([
                'reports' => $reports,
                'success' => $message,
                'numOfpages' => $numOfpages,
                'current_page' => $current_page,
                'total' => $total,
                'from' => $from,
                'to' => $to,
                'next_page' => $next_page,
                'previous_page' => $previous_page,
                'per_page' => $per_page,
                'page_url' => $page_url
            ]);
    }
}
