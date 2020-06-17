<?php

namespace App\Http\Controllers\Institution;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Services\EcolabService;
use App\Http\Controllers\Controller;

class InstitutionController extends Controller
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

        $response = $this->ecolabService->getAll('institutions',$request->all());

        $institutions = $response->data;

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

        return view('Institutos.index', compact('institutions','numOfpages','current_page','total','from','to','next_page','previous_page','per_page','page_url'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Institutos.form');
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

        $rules = [
            'name' => 'required|min:5',
            'acronym' => 'required|min:2',
            'description' => 'required|min:10',
            'address' => 'required|min:10',
            'file' => 'image',
        ];

        $data = $this->validate($request, $rules);
        if($request->hasFile('file')){
            $data['file'] = fopen($request->file->path(), 'r');
            $hasFile = true;
        }

        $data = $this->ecolabService->create('institutions', $data, $hasFile);

        return redirect()
            ->route('institutions.show',
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
        $institution = $this->ecolabService->getOne('institutions',$id);

        return view('Institutos.show')->with([
            'institution' => $institution
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
        $institution = $this->ecolabService->getOne('institutions',$id);
        return view('Institutos.form', compact('institution'));
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
        $rules = [
            'name' => 'min:5',
            'acronym' => 'min:2',
            'description' => 'min:10',
            'address' => 'min:10',
            'file' => 'image|mimes:jpg,png,jpeg,bmp',
        ];

        $data = $this->validate($request, $rules);

        if($request->hasFile('file')){
            $data['file'] = fopen($request->file->path(), 'r');
            $hasFile = true;
        }
        //dd($data,$hasFile);
        $institution = $this->ecolabService->update("institutions/{$id}", $data, $hasFile);
        $message = 'Updated successfully';

        return view('Institutos.show')->with([
            'institution' => $institution,
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
        $this->ecolabService->delete('institutions',$id);
        $response = $this->ecolabService->getAll('institutions');

        $institutions = $response->data;

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
        return view('Institutos.index')
            ->with([
                'institutions' => $institutions,
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
