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


    public function index()
    {
        $usuarios = $this->ecolabService->getAll('users');
        return view('Usuarios.index', compact('usuarios'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $institutions = $this->ecolabService->getAll('institutions');
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
        $institutions = $this->ecolabService->getAll('institutions');
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
        $message = 'Updated successfully';

        return view('Usuarios.show')->with([
            'user' => $user,
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
        $this->ecolabService->delete('users',$id);
        $usuarios = $this->ecolabService->getAll('users');
        $message = 'Deleted successfully';
        return view('Usuarios.index')
            ->with([
                'usuarios' => $usuarios,
                'success' => $message
            ]);
    }
}
