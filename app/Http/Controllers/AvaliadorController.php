<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AvaliadorRequest;
use Response;

use App\Pessoa;
use App\Telefone;
use App\Avaliador;
use App\User;
use DB;
use Auth;
use View;

class AvaliadorController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        if($request->ajax()) {

            $term = $request->term;
            $avaliador = DB::table('avaliadors as a')
                    ->join('pessoas as p', 'p.id', '=', 'a.pessoa_id')
                    ->select('p.nome as text', 'a.id as id')
                    ->where('p.nome', 'LIKE', '%'. $term . '%')
                    ->orderBy('p.nome')
                    ->pluck('id', 'text');
        
            return Response::json(['itens' => $avaliador]);
                        
        }


        return View('avaliador.index', [
            'avaliador' => Avaliador::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $departamento = DB::table('departamentos')->orderBy('nome')->pluck('nome', 'id');

        return View('avaliador.create', [
            'departamento' => $departamento
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AvaliadorRequest $request) {
        
                
        $telefone = $request->except('_token', 'nome', 'email', 'departamento', 'banca', 'coordenador', 'orientador');
        $telefone = array_values($telefone);


        $pessoa = new Pessoa;
        $pessoa->nome = $request->input('nome');
        $pessoa->email = $request->input('email');
        $pessoa->save();

        $ultimapessoa = DB::table('pessoas')
                    ->orderBy('created_at', 'desc')
                    ->first();

        for($i = 0; $i < count($telefone); $i++) { 
            $t = new Telefone;
            $t->numero = $telefone[$i];
            $t->pessoa_id = $ultimapessoa->id;
            $t->save();
        }

        
        $avaliador = new Avaliador;
        $avaliador->departamento()->associate($request->input('departamento'));
        $avaliador->pessoa()->associate($ultimapessoa->id);
        $avaliador->permissao = array_sum(array_values($request->only('banca', 'coordenador', 'orientador')));
        $avaliador->save();


        User::create([
            'name' => $request->input('nome'),
            'email' => $request->input('email'),
            'password' => bcrypt('deinfouepg'),
            'mudou_senha' => 0
        ]);

        return redirect('/avaliador');

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

        return View('avaliador.edit', [
            'avaliador' => Avaliador::find($id),
            'departamento' => DB::table('departamentos')->orderBy('descricao')->pluck('descricao', 'id')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AvaliadorRequest $request, $id) {
        

        // Atualiza os campos relacionado a pessoa e avaliador
        $avaliador = Avaliador::find($id);
        $avaliador->pessoa()->update($request->only('nome', 'email'));
        $avaliador->update([
            'permissao' => array_sum(array_values($request->only('banca', 'coordenador', 'orientador'))),
            'departamento_id' => $request->input('departamento')
        ]);
        

        // Salva apenas os números de telefone, todos
        $telefone = $request->except('_token', '_method', 'nome', 'email', 'permissao', 'banca', 'orientador', 'coordenador', 'departamento');
        

        // Pega apenas os valores do request
        $telefone = array_values($telefone);
        

        // Retorna todos os números de telefone que está relacionado com a pessoa que é o academico em questão
        $numeros_salvos = DB::select('select c.numero 
                                        from contatos as c 
                                       where c.pessoa_id = ' . $avaliador->pessoa_id);

        // For para salvar apenas os novos números
        for($i = 0; $i < count($telefone); $i++) {
       
            if (count($numeros_salvos) > $i) {
                if($numeros_salvos[$i]->numero != $telefone[$i]) {
                    $contato = new Telefone;
                    $contato->numero = $telefone[$i];
                    $contato->pessoa_id = $avaliador->pessoa_id;
                    $contato->save();
                }

            } else {
                $contato = new Telefone;
                $contato->numero = $telefone[$i];
                $contato->pessoa_id = $avaliador->pessoa_id;
                $contato->save();
            }

        }

        return redirect('/avaliador');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}
