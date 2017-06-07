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

class CursoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        return view('curso.index', [
            'curso' => Curso::with(['membrobanca.user'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $coordenador = DB::table('membro_bancas as mb')
            ->join('users as u', 'u.id', '=', 'mb.user_id')
            ->join('departamentos as d', 'd.id', '=', 'mb.departamento_id')
            ->join('instituicaos as i', 'i.id', '=', 'd.instituicao_id')
            ->where('i.sigla', '=', 'UEPG')
            ->orderBy('u.name', 'asc')
            ->pluck('u.name', 'mb.id');

        $dept = DB::table('departamentos as d')
            ->join('instituicaos as i', 'i.id', 'd.instituicao_id')
            ->where('i.sigla', '=', 'UEPG')
            ->select('d.id', 'd.nome')
            ->orderBy('d.nome', 'asc')
            ->pluck('d.nome', 'd.id');

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

        $coordenadorTodos = DB::table('membro_bancas as mb')
            ->join('users as u', 'u.id', '=', 'mb.user_id')
            ->orderBy('u.name', 'asc')
            ->pluck('u.name', 'mb.id');

        return view('curso.edit', [
            'curso' => Curso::find($id),
            'coordenadortodos' => $coordenadorTodos,
            'coordenador' => Curso::find($id)->membrobanca[0]->pivot->coordenador_id,
            'departamento' => Departamento::all()->pluck('nome', 'id'),
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

        $curso = Curso::find($id);

        $curso->update([
            'nome' => $request->input('nome'),
            'departamento_id' => $request->input('departamento'),
        ]);

        $coordenadorCurso = Curso::find($id)->membrobanca[0];
        
        if ($coordenadorCurso->pivot->coordenador_id !== $request->input('coordenador')) {
            $curso->membrobanca()->detach($coordenadorCurso->pivot->coordenador_id);   
        }

        if ($request->has('fimvigencia')) {
            $curso->nome = $request->input('nome');
            $curso->departamento()->associate($request->input('departamento'));
            $curso->save();

            $curso->membrobanca()->attach($request->input('coordenador'), [
                'inicio_vigencia' => date("Y-m-d",strtotime(str_replace('/','-',$request->input('iniciovigencia')))),
                'fim_vigencia' => date("Y-m-d",strtotime(str_replace('/','-',$request->input('fimvigencia'))))
            ]);

        } else {

            $curso->nome = $request->input('nome');
            $curso->departamento()->associate($request->input('departamento'));
            $curso->save();

            $curso->membrobanca()->attach($request->input('coordenador'), [
                'inicio_vigencia' => date("Y-m-d",strtotime(str_replace('/','-',$request->input('iniciovigencia'))))
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

        Curso::find($id)->delete();

        return back()->with('message', 'Curso excluído com sucesso');
    }
}
