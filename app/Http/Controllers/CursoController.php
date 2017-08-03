<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CursoRequest;

use App\Curso;
use App\User;
use App\Departamento;
use App\MembroBanca;
use App\CoordenadorCurso;
use DB;
use Auth;

class CursoController extends Controller {

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
        
            $curso = DB::table('cursos as c')
                ->join('coordenador_cursos as cc', 'c.id', '=', 'cc.curso_id')
                ->join('membro_bancas as mb', 'mb.id', '=', 'cc.coordenador_id')
                ->join('users as u', 'u.id', '=', 'mb.user_id')
                ->where('c.departamento_id', '=', User::userMembroDepartamento()->departamento_id)
                ->select('u.name as coordenador', 'c.id', 'c.nome as nome')
                ->get();
        
            return view('curso.index', [
                'curso' => $curso
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

        $this->authorize('create', Curso::class);

        $departamento_id = User::userMembroDepartamento()->departamento_id;

        $coordenador = DB::table('membro_bancas as mb')
            ->join('users as u', 'u.id', '=', 'mb.user_id')
            ->join('departamentos as d', 'd.id', '=', 'mb.departamento_id')
            ->where('d.id', $departamento_id)
            ->orderBy('u.name', 'asc')
            ->pluck('u.name', 'mb.id');

        $dept = Departamento::where('instituicao_id', Departamento::where('id', $departamento_id)->first()->value('instituicao_id'))
                    ->orderBy('nome', 'asc')
                    ->pluck('nome', 'id');

        return view('curso.create', [
            'coordenador' => $coordenador,
            'departamento' => $dept
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CursoRequest $request) {
        
        $this->authorize('create', Curso::class);

        $m = MembroBanca::find($request->input('coordenador'));
        
        if (User::find($m->user_id)->ativo <> 1) {
            return back()
                    ->with('message', 'Coordenador inativo')
                    ->withInput();
        }

        if ($request->has('fimvigencia')) {
            $curso = new Curso;
            $curso->nome = $request->input('nome');
            $curso->departamento()->associate($request->input('departamento'));
            $curso->save();

            $ultimocurso = DB::table('cursos')
                            ->latest()
                            ->first();

            $c = Curso::find($ultimocurso->id);

            $c->membrobanca()->attach($request->input('coordenador'), [
                'inicio_vigencia' => date("Y-m-d",strtotime(str_replace('/','-',$request->input('iniciovigencia')))),
                'fim_vigencia' => date("Y-m-d",strtotime(str_replace('/','-',$request->input('fimvigencia'))))
                
            ]);

            MembroBanca::find($m->id)->user()->update([
                'permissao' => 9
            ]);



        } else {

            $curso = new Curso;
            $curso->nome = $request->input('nome');
            $curso->departamento()->associate($request->input('departamento'));
            $curso->save();
            

            $ultimocurso = DB::table('cursos')
                            ->latest()
                            ->first();

            $c = Curso::find($ultimocurso->id);

            $c->membrobanca()->attach($request->input('coordenador'), [
                'inicio_vigencia' => date("Y-m-d",strtotime(str_replace('/','-',$request->input('iniciovigencia'))))
            ]);

            MembroBanca::find($m->id)->user()->update([
                'permissao' => 9
            ]);
        
        }

        return redirect('/curso')->with('message', 'Curso cadastrado com sucesso!');
        
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

        $this->authorize('create', Curso::class);

        $departamento_id = User::userMembroDepartamento()->departamento_id;

        $coordenadorTodos = DB::table('membro_bancas as mb')
            ->join('departamentos as d', 'd.id', '=', 'mb.departamento_id')
            ->join('users as u', 'u.id', '=', 'mb.user_id')
            ->where('mb.departamento_id', '=', User::userMembroDepartamento()->departamento_id)
            ->orderBy('u.name', 'asc')
            ->pluck('u.name', 'mb.id');

        $dept = Departamento::where('instituicao_id', Departamento::where('id', $departamento_id)->first()->value('instituicao_id'))
                    ->orderBy('nome', 'asc')
                    ->pluck('nome', 'id');

        return view('curso.edit', [
            'curso' => Curso::find($id),
            'coordenadortodos' => $coordenadorTodos,
            'coordenador' => Curso::find($id)->membrobanca[0]->pivot->coordenador_id,
            'departamento' => $dept,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CursoRequest $request, $id) {

        $this->authorize('update', Curso::find($id));


        $curso = Curso::find($id);

        $curso->update([
            'nome' => $request->input('nome'),
            'departamento_id' => $request->input('departamento'),
        ]);

        $coordenadorCurso = Curso::find($id)->membrobanca[0];
        
        if ($coordenadorCurso->pivot->coordenador_id !== $request->input('coordenador')) {
            $curso->membrobanca()->detach($coordenadorCurso->pivot->coordenador_id); 
            
            if(DB::table('coordenador_cursos')->where('coordenador_id', $coordenadorCurso->pivot->coordenador_id)->count() > 0) {

                MembroBanca::find($coordenadorCurso->pivot->coordenador_id)->user()->update([
                    'permissao' => 9
                ]);  
            } else {
                MembroBanca::find($coordenadorCurso->pivot->coordenador_id)->user()->update([
                    'permissao' => 7
                ]);
            }
        }

        if ($request->has('fimvigencia')) {
            $curso->nome = $request->input('nome');
            $curso->departamento()->associate($request->input('departamento'));
            $curso->save();

            $curso->membrobanca()->attach($request->input('coordenador'), [
                'inicio_vigencia' => date("Y-m-d",strtotime(str_replace('/','-',$request->input('iniciovigencia')))),
                'fim_vigencia' => date("Y-m-d",strtotime(str_replace('/','-',$request->input('fimvigencia'))))
            ]);

            MembroBanca::find($request->input('coordenador'))->user()->update([
                'permissao' => 9
            ]);

        } else {

            $curso->nome = $request->input('nome');
            $curso->departamento()->associate($request->input('departamento'));
            $curso->save();

            $curso->membrobanca()->attach($request->input('coordenador'), [
                'inicio_vigencia' => date("Y-m-d",strtotime(str_replace('/','-',$request->input('iniciovigencia'))))
            ]);

            MembroBanca::find($request->input('coordenador'))->user()->update([
                'permissao' => 9
            ]);
            
        }

        return redirect('/curso')->with('message', 'Curso atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $this->authorize('delete', Curso::class);

        Curso::find($id)->delete();

        return back()->with('message', 'Curso excluído com sucesso');
    }
}
