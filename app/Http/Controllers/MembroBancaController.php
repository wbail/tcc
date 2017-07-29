<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MembroBancaRequest;
use Response;

use App\Telefone;
use App\MembroBanca;
use App\User;
use App\Departamento;
use DB;
use Auth;
use View;

class MembroBancaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('create', MembroBanca::class);

        if($request->ajax()) {

            $term = $request->term;
            $orientador = DB::table('membro_bancas as a')
                    ->join('users as u', 'u.id', '=', 'a.user_id')
                    ->select('u.name as text', 'a.id as id')
                    ->where('u.name', 'LIKE', '%'. $term . '%')
                    ->orderBy('u.name')
                    ->pluck('id', 'text');
        
            return Response::json(['itens' => $orientador]);
                        
        }

        return view('membrobanca.index', [
            'membrobanca' => MembroBanca::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', MembroBanca::class);

        $permissao = array(
            '1' => 'Orientador',
            '2' => 'Coorientador',
            '3' => 'Banca',
        );

        $departamento = DB::table('departamentos as d')
                            ->join('instituicaos as i', 'i.id', '=', 'd.instituicao_id')
                            ->where('i.sigla', '=', 'UEPG')
                            ->orderBy('d.nome')
                            ->pluck('d.nome', 'd.id');

        return View('membrobanca.create', [
            'departamento' => $departamento,
            'permissao' => $permissao
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MembroBancaRequest $request)
    {

        $this->authorize('create', MembroBanca::class);

        $telefone = $request->except('_token', 'nome', 'email', 'banca', 'coorientador', 'orientador', 'departamento', 'ativo');
        
        for ($i = 0; $i < count($telefone); $i++) { 
            
            $justNumber = str_replace(['(', ')', '-', ' '], '', array_values($telefone));
            
            if(DB::table('telefones')->where('numero', '=', $justNumber[$i])->exists()) {

                return back()->with('message', 'O número ' . $justNumber[$i] . ' já foi cadastrado.');

            }            
        }

        User::create([
            'name' => $request->input('nome'),
            'email' => $request->input('email'),
            'password' => bcrypt('deinfouepg'),
            'permissao' => array_sum(array_values($request->only('banca', 'coordenador', 'orientador'))),
            'mudou_senha' => 0
        ]);

        $lastUser = DB::table('users')
                        ->latest()
                        ->first();

        $membrobanca = new MembroBanca;
        $membrobanca->departamento()->associate($request->input('departamento'));
        $membrobanca->user()->associate($lastUser->id);
        $membrobanca->save();

        for ($i = 0; $i < count($telefone); $i++) {

            $t = new Telefone;
            $t->numero = $justNumber[$i];
            $t->user()->associate($lastUser->id);
            $t->save();
            
        }

        return redirect('/membrobanca')->with('message', 'Membro de Banca cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('create', MembroBanca::class);

        return view('membrobanca.edit', [
            'membrobanca' => MembroBanca::find($id),
            'departamento' => Departamento::all()->pluck('nome', 'id')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MembroBancaRequest $request, $id)
    {
        $this->authorize('update', MembroBanca::class);
        return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', MembroBanca::class);
    }
}
