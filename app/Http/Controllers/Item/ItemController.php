<?php

namespace App\Http\Controllers\Item;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Services\EcolabService;
use App\Http\Controllers\Controller;

class ItemController extends Controller
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

        $items = $response->data;

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

        $laboratories = $this->ecolabService->getAll('laboratories',["per_page"=>100])->data;
        $laboratoriesArray = Arr::pluck($laboratories, 'name','id');

        return view('Items.index', compact('items','laboratoriesArray','numOfpages','current_page','total','from','to','next_page','previous_page','per_page','page_url'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $laboratories = $this->ecolabService->getAll('laboratories',["per_page"=>100])->data;
        $laboratoriesArray = Arr::pluck($laboratories, 'name','id');
        return view('Items.form', compact('laboratoriesArray'));
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
            'description' => 'required|min:10',
            'file' => 'required|image',
            'laboratory_id' => 'required|integer|min:1',
        ];

        $data = $this->validate($request, $rules);

        if($request->hasFile('file')){
            $data['file'] = fopen($request->file->path(), 'r');
            $hasFile = true;
        }

        $data = $this->ecolabService->create('items', $data, $hasFile);

        return redirect()
            ->route('items.show',
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
        $item = $this->ecolabService->getOne('items',$id);
        $laboratory = $this->ecolabService->getOne('laboratories',$item->laboratory_id);

        return view('items.show')->with([
            'item' => $item,
            'laboratory' => $laboratory,
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
        $item = $this->ecolabService->getOne('items',$id);
        $laboratories = $this->ecolabService->getAll('laboratories',["per_page"=>100])->data;
        $laboratoriesArray = Arr::pluck($laboratories, 'name','id');
        return view('Items.form', compact('item', 'laboratoriesArray'));
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
            'description' => 'min:10',
            'file' => 'mimes:jpg,png,jpeg,bmp',
            'laboratory_id' => 'required|integer|min:1',
        ];

        $data = $this->validate($request, $rules);

        if($request->hasFile('file')){
            $data['file'] = fopen($request->file->path(), 'r');
            $hasFile = true;
        }
        //dd($data,$hasFile);
        $item = $this->ecolabService->update("items/{$id}", $data, $hasFile);
        $laboratory = $this->ecolabService->getOne('laboratories',$item->laboratory_id);
        $message = 'Updated successfully';

        return view('items.show')->with([
            'item' => $item,
            'laboratory' => $laboratory,
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
        $this->ecolabService->delete('items',$id);
        $response = $this->ecolabService->getAll('items');

        $items = $response->data;

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
        return view('items.index')
            ->with([
                'items' => $items,
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
