<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Services\EcolabService;
use App\Http\Controllers\Controller;

class UserController extends Controller
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


    public function index(Request $request)
    {
        $response = $this->ecolabService->getAll('users',$request->all());
        $usuarios = $response->data;

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

        return view('Usuarios.index', compact('usuarios','numOfpages','current_page','total','from','to','next_page','previous_page','per_page','page_url'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $institutions = $this->ecolabService->getAll('institutions',["per_page"=>100])->data;
        $institutionsArray = Arr::pluck($institutions, 'name','id');

        $userTypeArray = [
            4 => 'Administrador',
            5 => 'Usuario Regular',
        ];

        return view('Usuarios.form', compact('institutionsArray', 'userTypeArray'));
    }

    public function show($id)
    {
        $usuario = $this->ecolabService->getOne('users',$id);

        $userType = $this->ecolabService->getOne('dictionaries',$usuario->userType);
        $institution = $this->ecolabService->getOne('institutions',$usuario->institution_id);
        return view('Usuarios.show')->with([
            'user' => $usuario,
            'userType' => $userType,
            'institution' => $institution
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        $data = $request->all();
        $data = $this->ecolabService->create('users', $data,false);


        return redirect()
            ->route('users.show',
                [
                    $data->id,
                ])
            ->with('success', ['Created successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->ecolabService->getOne('users',$id);
        $institutions = $this->ecolabService->getAll('institutions',["per_page"=>100])->data;
        $institutionsArray = Arr::pluck($institutions, 'name','id');

        $userTypeArray = [
            4 => 'Administrador',
            5 => 'Usuario Regular',
        ];

        return view('Usuarios.form', compact('user','institutionsArray', 'userTypeArray'));
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
        //dd($data,$hasFile);
        $data = $request->all();
        $user = $this->ecolabService->update("users/{$id}", $data, false);
        $userType = $this->ecolabService->getOne('dictionaries',$user->userType);
        $institution = $this->ecolabService->getOne('institutions',$user->institution_id);
        $message = 'Updated successfully';

        return view('Usuarios.show')->with([
            'user' => $user,
            'success' => $message,
            'userType' => $userType,
            'institution' => $institution
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
        $this->ecolabService->delete('users',$id);
        $response = $this->ecolabService->getAll('users');
        $usuarios = $response->data;

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

        return view('Usuarios.index')
            ->with([
                'usuarios' => $usuarios,
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
