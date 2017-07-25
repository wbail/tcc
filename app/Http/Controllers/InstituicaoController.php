<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InstituicaoRequest;

use App\Instituicao;
use App\Departamento;
use App\User;
// use App\Http\Policies\InstituicaoPolicy;

use Auth;

class InstituicaoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
        $instituicao = 0;

        $departamento_id = Auth::user()
                            ->membrobanca()
                            ->value('departamento_id');
        if($departamento_id) {

            $instituicao = Departamento::find($departamento_id)
                            ->instituicao()
                            ->first();

            $this->authorize('view', $instituicao);
        
            return view('instituicao.index', [
                'instituicao' => Instituicao::all()
            ]);
            
        } else {
            return abort(403, 'Usuário não Autorizado.');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $this->authorize('create', Instituicao::class);
        
        return view('instituicao.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InstituicaoRequest $request) {
    
        
        $this->authorize('create', \App\Instituicao::class);

        $i = new Instituicao;
        $i->nome = $request->input('nome');
        $i->sigla = $request->input('sigla');
        $i->save();
    
        return redirect('/instituicao')->with('message', 'Instituição cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $this->authorize('create', \App\Instituicao::class);
        
        return view('instituicao.edit', [
            'instituicao' => Instituicao::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InstituicaoRequest $request, $id) {

        $this->authorize('update', \App\Instituicao::class);
        
        Instituicao::find($id)
            ->update($request->all());

        return redirect('/instituicao');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $this->authorize('delete', \App\Instituicao::class);
        //
    }
}
