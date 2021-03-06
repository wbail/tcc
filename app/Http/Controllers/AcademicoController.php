<?php

namespace App\Http\Controllers;

use App\AcademicoTrabalho;
use Illuminate\Http\Request;
use App\Http\Requests\AcademicoRequest;
use Illuminate\Support\Facades\Session;
use Response;

use App\Pessoa;
use App\Telefone;
use App\Academico;
use App\User;
use App\Curso;
use DB;
use Auth;
use View;
use Validator;
use Illuminate\Validation\Rule;


class AcademicoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $this->authorize('create', Academico::class);

        if($request->ajax()) {

            $term = $request->term;

            $academico = DB::table('academicos as a')
                ->join('users as u', 'u.id', '=', 'a.user_id')
                ->join('coordenador_cursos as cc', 'cc.curso_id', '=', 'a.curso_id')
                ->join('cursos as c', 'c.id', '=', 'a.curso_id')
                ->join('membro_bancas as mb', 'mb.id', '=', 'cc.coordenador_id')
                ->join('academico_trabalhos as at', 'at.academico_id', '=', 'a.id')
                ->where('mb.user_id', Auth::user()->id)
                ->where('u.name', 'like', '%' . $term . '%')
//                ->where('at.ano_letivo_id', Session::get('anoletivo')->id)
                ->where('c.id', Session::get('curso')->id)
                ->where('at.aprovado', 0)
                ->whereNull('at.trabalho_id')
                ->orderBy('u.name')
                ->pluck('a.id', 'u.name as text');
        
            return Response::json(['itens' => $academico]);
                        
        }

        $academicos = DB::table('academicos as a')
            ->join('users as u', 'u.id', '=', 'a.user_id')
            ->join('coordenador_cursos as cc', 'cc.curso_id', '=', 'a.curso_id')
            ->join('cursos as c', 'c.id', '=', 'a.curso_id')
            ->join('membro_bancas as mb', 'mb.id', '=', 'cc.coordenador_id')
            ->where('mb.user_id', Auth::user()->id)
            ->select('a.id as academicoid', 'a.ra', 'u.name', 'u.ativo', 'u.email', 'c.nome as cursonome')
            ->get();


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

        $this->authorize('create', Academico::class);

        $tipo = ['1' => 'Celular', '2' => 'Fixo', '3' => 'Comercial'];

        // apenas os cursos do departamento do coordenador
        $curso = DB::table('cursos as c')
                ->join('departamentos as d', 'd.id', '=', 'c.departamento_id')
                ->join('membro_bancas as mb', 'mb.departamento_id', '=', 'd.id')
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

        $this->authorize('create', Academico::class);
        
        $telefone = $request->except('_token', 'nome', 'email', 'ra', 'curso', 'tipo');
        
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

        $lastUser = DB::table('users')
                        ->latest()
                        ->first();

        $academico = new Academico;
        $academico->ra = $request->input('ra');
        $academico->curso()->associate($request->input('curso'));
        $academico->user()->associate($lastUser->id);
        $academico->save();
        $academico->anoletivo()->attach(session()->get('anoletivo')->id);

        for ($i = 0; $i < count($telefone); $i++) {

            $t = new Telefone;
            $t->numero = $justNumber[$i];
            $t->user()->associate($lastUser->id);
            $t->save();
            
        }

        return redirect('/academico/novo')
            ->with('message', 'Acadêmico(a) cadastrado(a) com sucesso!')
            ->withInput(['curso' => $request->input('curso')]);


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

        if (!Auth::user()->permissao == 9) {
            abort(403, 'Acesso não autorizado.');
        }

         // apenas os cursos do departamento do coordenador
        $curso = DB::table('cursos as c')
                ->join('departamentos as d', 'd.id', '=', 'c.departamento_id')
                ->join('membro_bancas as mb', 'mb.departamento_id', '=', 'd.id')
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

        if (!Auth::user()->permissao == 9) {
            abort(403, 'Acesso não autorizado.');
        }

        $ativo = 0;
        if ($request->input('ativo') == null) {
            $ativo = 0;
        }

        $academico = Academico::find($id);

        $academico->user()->update([
            'name' => $request->input('nome'),
            'email' => $request->input('email'),
            'ativo' => $ativo,
        ]);

        $academico
            ->curso()
            ->associate($request->input('curso'))
            ->save();

        // Salva apenas os números de telefone, todos
        $telefone = $request->except('_token', '_method', 'nome', 'email', 'ra', 'curso', 'ativo');

        // Pega apenas os valores do request
        $telefone = array_values($telefone);

        $telefoneDono = Telefone::where('user_id', $academico->user_id)
            ->get();

        for ($i = 0; $i < count($telefone); $i++) {

            if((DB::table('telefones')->where('numero', '=', $telefone[$i])->exists()) && ($telefoneDono[$i]->user_id == $academico->user_id)) {
                //
            } else if(DB::table('telefones')->where('numero', '=', $telefone[$i])->exists() && $telefoneDono[$i]->user_id != $academico->user_id) {
                //
            } else {
                $contato = new Telefone;
                $contato->numero = $telefone[$i];
                $contato->user_id = $academico->user_id;
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

        if(!Auth::user()->permissao == 9) {
            abort(403, 'Acesso não autorizado.');
        }

        $trabalho = AcademicoTrabalho::where('academico_id', $id)
            ->whereNull('trabalho_id')
            ->get();


        if (count($trabalho) > 0) {
            User::find(Academico::find($id)->user_id)
                ->update(['ativo' => 0]);

            return back()->with('message', 'Aluno(a) excluído(a) com sucesso.');
        } else {
            return back()->with('message-del', 'Não é possível excluir o(a) aluno(a).');
        }

    }
}