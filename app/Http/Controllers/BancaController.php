<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Policies\BancaPolicy;
// use App\Http\Requests\BancaRequest;

use Auth;
use DB;
use App\Banca;
use App\Etapa;
use App\EtapaAno;
use App\Trabalho;
use App\MembroBanca;

class BancaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('create', Banca::class);

        return view('banca.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Banca::class);

        $membros = MembroBanca::join('users as u', 'u.id', '=', 'membro_bancas.user_id')
                    ->orderBy('u.name')
                    ->pluck('u.name', 'membro_bancas.id');

        $data = Etapa::where('banca', 1)
                    ->join('etapa_anos as ea', 'ea.etapa_id', '=', 'etapas.id')
                    ->select('data_inicial', 'data_final')
                    ->first();
        
        $trabalho = Trabalho::where('ano', '=', \Carbon\Carbon::now()->format('Y'))
                    ->pluck('titulo', 'id');

        return view('banca.create', [
            'trabalho' => $trabalho,
            'data' => $data,
            'membros' => $membros
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
        $this->authorize('create', Banca::class);
        
        return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('create', Banca::class);        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('create', Banca::class);
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
        $this->authorize('create', Banca::class);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('create', Banca::class);
    }
}
