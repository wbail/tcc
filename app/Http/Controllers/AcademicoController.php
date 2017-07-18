<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AcademicoRequest;
use Response;

use App\Pessoa;
use App\Telefone;
use App\Academico;
use App\User;
use App\Curso;
use DB;
use Auth;
use View;


class AcademicoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        if($request->ajax()) {

            $term = $request->term;
            $academico = DB::table('academicos as a')
                    ->join('users as u', 'u.id', '=', 'a.user_id')
                    ->select('u.name as text', 'a.id as id')
                    ->where('u.name', 'LIKE', '%'. $term . '%')
                    ->orderBy('u.name')
                    ->pluck('id', 'text');
        
            return Response::json(['itens' => $academico]);
                        
        }


        $academicos = DB::table('membro_bancas as mb')
                        ->join('users as u', 'u.id', '=', 'mb.user_id')
                        ->join('departamentos as d', 'd.id', '=', 'mb.departamento_id')
                        ->join('cursos as c', 'c.departamento_id', '=', 'd.id')
                        ->join('academicos as a', 'a.curso_id', '=', 'c.id')
                        ->join('users as ua', 'ua.id', '=', 'a.user_id')
                        ->where('u.id', '=', Auth::user()->id)
                        ->select('a.*', 'a.id as academicoid', 'ua.*', 'c.nome as cursonome')
                        ->get();

        // return $academicos;

        return View('academico.index', [
            'academico' => $academicos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $tipo = ['1' => 'Celular', '2' => 'Fixo', '3' => 'Comercial'];

        // apenas os cursos do departamento do coordenador
        $curso = DB::table('cursos as c')
                ->join('departamentos as d', 'd.id', '=', 'c.departamento_id')
                ->join('membro_bancas as mb', 'mb.id', '=', 'd.id')
                ->join('users as u', 'u.id', '=', 'mb.user_id')
                ->where('u.id', '=', Auth::user()->id)
                ->orderBy('c.nome')
                ->select('c.*')
                ->pluck('c.nome', 'c.id');

        return view('academico.create', [
            'curso' => $curso,
            'tipo' => $tipo
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AcademicoRequest $request) {
        
        $telefone = $request->except('_token', 'nome', 'email', 'ra', 'curso');
        
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
            'permissao' => 8,
            'mudou_senha' => 0
        ]);

        $lastUser = DB::table('users')->latest()->first();

        $academico = new Academico;
        $academico->ra = $request->input('ra');
        $academico->curso()->associate($request->input('curso'));
        $academico->user()->associate($lastUser->id);
        $academico->save();

        for ($i = 0; $i < count($telefone); $i++) {

            $t = new Telefone;
            $t->numero = $justNumber[$i];
            $t->user()->associate($lastUser->id);
            $t->save();
            
        }

        return redirect('/academico/novo')->with('message', 'Acadêmico cadastrado com sucesso!');

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

         // apenas os cursos do departamento do coordenador
        $curso = DB::table('cursos as c')
                ->join('departamentos as d', 'd.id', '=', 'c.departamento_id')
                ->join('membro_bancas as mb', 'mb.id', '=', 'd.id')
                ->join('users as u', 'u.id', '=', 'mb.user_id')
                ->where('u.id', '=', Auth::user()->id)
                ->select('c.*')
                ->pluck('c.nome', 'c.id');

        return View('academico.edit', [
            'academico' => Academico::find($id),
            'curso' => $curso
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AcademicoRequest $request, $id) {
        
        return $request->all();

        // Atualiza os campos relacionado a user
        Academico::find($id)->user()->update($request->all());

        // Salva apenas os números de telefone, todos
        $telefone = $request->except('_token', '_method', 'nome', 'email', 'ra', 'curso');
        
        // Pega apenas os valores do request
        $telefone = array_values($telefone);
        
        // Pega o objeto da tabela user em que o academicos está relacionado, para pegar o id da user
        $userid = DB::table('academicos as a')
            ->where('a.id', '=', $id)
            ->first();

        // Retorna todos os números de telefone que está relacionado com a user que é o academico em questão
        $numeros_salvos = DB::select('select c.numero 
                                        from contatos as c 
                                       where c.user_id = ' . $userid->user_id);

        // For para salvar apenas os novos números
        for($i = 0; $i < count($telefone); $i++) {
       
            if (count($numeros_salvos) > $i) {
                if($numeros_salvos[$i]->numero != $telefone[$i]) {
                    $contato = new Telefone;
                    $contato->numero = $telefone[$i];
                    $contato->user_id = $userid->user_id;
                    $contato->save();
                }

            } else {
                $contato = new Telefone;
                $contato->numero = $telefone[$i];
                $contato->user_id = $userid->user_id;
                $contato->save();
            }

        }

        return redirect('/academico')->with('message', 'Acadêmico atualizado com sucesso!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        
        Academico::find($id)->delete();
        return redirect('/academico');

    }
}