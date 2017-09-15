<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DepartamentoRequest;

use App\Departamento;
use App\Instituicao;
use DB;
use Auth;
use View;

class DepartamentoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $this->authorize('create', Departamento::class);

        return View('departamento.index', [
            'departamento' => Departamento::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $this->authorize('create', Departamento::class);

        return View('departamento.create', [
            'inst' => Instituicao::all()->pluck('nome', 'id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartamentoRequest $request) {

        $this->authorize('create', Departamento::class);

        $departamento = new Departamento;
        $departamento->nome = $request->input('nome');
        $departamento->sigla = $request->input('sigla');
        $departamento->instituicao()->associate($request->input('instituicao'));
        $departamento->save();

        return redirect('/departamento')->with('message', 'Departamento cadastrado com sucesso!');
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

        $this->authorize('create', Departamento::class);

        return View('departamento.edit', [
            'departamento' => Departamento::find($id),
            'inst' => Instituicao::all()->pluck('nome', 'id')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartamentoRequest $request, $id) {

        $this->authorize('update', Departamento::find($id));

        $departamento = Departamento::find($id);
        $departamento->nome = $request->input('nome');
        $departamento->sigla = $request->input('sigla');
        $departamento->instituicao()->associate($request->input('instituicao'));
        $departamento->save();

        return redirect('/departamento')->with('message', 'Departamento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $this->authorize('delete', Departamento::class);
    }
}
