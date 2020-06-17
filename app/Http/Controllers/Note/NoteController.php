<?php

namespace App\Http\Controllers\Note;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Services\EcolabService;
use App\Http\Controllers\Controller;

class NoteController extends Controller
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
        //dd($request->all());
        $response = $this->ecolabService->getAll('notes',$request->all());
        $notes = $response->data;


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

        //dd($numOfpages,$current_page,$per_page,$next_page,$previous_page,$query_params);

        return view('Notas.index', compact('notes','numOfpages','current_page','total','from','to','next_page','previous_page','per_page','page_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = $this->ecolabService->getAll('items',["per_page"=>100])->data;
        $itemsArray = Arr::pluck($items, 'name','id');
        return view('Notas.form', compact('itemsArray'));
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->ecolabService->create('notes', $request->all(), false);

        return redirect()
            ->route('notes.show',
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
        $note = $this->ecolabService->getOne('notes',$id);
        $item = $this->ecolabService->getOne('items',$note->item_id);


        return view('Notas.show')->with([
            'note' => $note,
            'item' => $item,
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
        $note = $this->ecolabService->getOne('notes',$id);


        $items = $this->ecolabService->getAll('items',["per_page"=>100])->data;
        $itemsArray = Arr::pluck($items, 'name','id');

        return view('Notas.form', compact('note', 'itemsArray'));
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
        $note = $this->ecolabService->update("notes/{$id}", $request->all(), false);
        $message = 'Updated successfully';
        $item = $this->ecolabService->getOne('items',$note->item_id);

        return view('Notas.show')->with([
            'note' => $note,
            'item' => $item,
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
        $this->ecolabService->delete('notes',$id);
        $response = $this->ecolabService->getAll('notes');
        $notes = $response->data;

        $message = 'Deleted successfully';

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

        return view('Notas.index')
            ->with([
                'notes' => $notes,
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
