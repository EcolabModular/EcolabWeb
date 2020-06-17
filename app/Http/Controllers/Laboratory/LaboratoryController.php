<?php

namespace App\Http\Controllers\Laboratory;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Services\EcolabService;
use App\Http\Controllers\Controller;

class LaboratoryController extends Controller
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
    public function index(request $request)
    {
        $response = $this->ecolabService->getAll('laboratories',$request->all());
        $laboratories = $response->data;

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

        $institutions = $this->ecolabService->getAll('institutions',["per_page"=>100])->data;
        $institutionsArray = Arr::pluck($institutions, 'name','id');

        return view('Laboratorios.index', compact('laboratories','institutionsArray','numOfpages','current_page','total','from','to','next_page','previous_page','per_page','page_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $institutions = $this->ecolabService->getAll('institutions',["per_page"=>100]);
        $institutionsArray = Arr::pluck($institutions, 'name','id');
        return view('Laboratorios.form', compact('institutionsArray'));
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->ecolabService->create('laboratories', $request->all(), false);

        return redirect()
            ->route('laboratories.show',
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
        $laboratory = $this->ecolabService->getOne('laboratories',$id);
        $institution = $this->ecolabService->getOne('institutions',$laboratory->institution_id);


        return view('Laboratorios.show')->with([
            'laboratory' => $laboratory,
            'institution' => $institution,
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
        $laboratory = $this->ecolabService->getOne('laboratories',$id);


        $institutions = $this->ecolabService->getAll('institutions',["per_page"=>100])->data;
        $institutionsArray = Arr::pluck($institutions, 'name','id');

        return view('Laboratorios.form', compact('laboratory', 'institutionsArray'));
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
        $laboratory = $this->ecolabService->update("laboratories/{$id}", $request->all(), false);
        $message = 'Updated successfully';
        $institution = $this->ecolabService->getOne('institutions',$laboratory->institution_id);

        return view('Laboratorios.show')->with([
            'laboratory' => $laboratory,
            'institution' => $institution,
            'success' => $message,
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
        $this->ecolabService->delete('laboratories',$id);
        $response = $this->ecolabService->getAll('laboratories');
        $laboratories = $response->data;

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

        return view('Laboratorios.index')
            ->with([
                'laboratories' => $laboratories,
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
