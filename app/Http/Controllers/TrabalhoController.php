<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TrabalhoRequest;

use App\Trabalho;
use App\Academico;
use App\User;
use App\Departamento;
use App\MembroBanca;
use DB;
use Auth;
use View;
use Carbon\Carbon;

class TrabalhoController extends Controller {

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
            
            $trabalho = Trabalho::whereHas('membrobanca', function($q) use ($departamento_id) {
                $q->where('departamento_id', '=', $departamento_id);
            })
            ->orWhereHas('coorientador', function($q) use ($departamento_id) {
                $q->where('departamento_id', '=', $departamento_id);
            })
            ->with('academico')
            ->get();

            return view('trabalho.index', [
                'trabalho' => $trabalho,
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

        $this->authorize('create', Trabalho::class);


        $academico = DB::table('academicos as a')
                        ->join('users as u', 'u.id', '=', 'a.user_id')
                        ->orderBy('u.name')
                        ->pluck('u.name', 'a.id');

        $orientador = DB::table('membro_bancas as mb')
                        ->join('users as u', 'u.id', '=', 'mb.user_id')
                        ->orderBy('u.name')
                        ->pluck('u.name', 'mb.id');

        return View('trabalho.create', [
            'academico' => $academico,
            'orientador' => $orientador
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrabalhoRequest $request) {

        // return $request->all();
        $this->authorize('create', Trabalho::class);
        
        if ($request->has('academico1') && $request->has('coorientador')) {
        
            $trabalho = new Trabalho;
            $trabalho->titulo = $request->input('titulo');
            $trabalho->ano = $request->input('ano');
            $trabalho->periodo = $request->input('periodo');
            $trabalho->orientador_id = $request->input('orientador');
            $trabalho->coorientador_id = $request->input('coorientador');
            $trabalho->academico()->sync([$request->input('academico'), $request->input('academico1')]);
            $trabalho->save();

            // $directory = 'trabalhos/' . $request->input('ano') . '/' . $request->input('titulo');
            // Storage::makeDirectory($directory);

            return redirect('/trabalho')->with('message', 'Trabalho cadastrado com sucesso');
            
        } elseif($request->has('academico1')) {
            
            $trabalho = new Trabalho;
            $trabalho->titulo = $request->input('titulo');
            $trabalho->ano = $request->input('ano');
            $trabalho->periodo = $request->input('periodo');
            $trabalho->orientador_id = $request->input('orientador');
            $trabalho->academico()->sync([$request->input('academico'), $request->input('academico1')]);
            $trabalho->save();
            
            // $directory = 'trabalhos/' . $request->input('ano') . '/' . $request->input('titulo');
            // Storage::makeDirectory($directory);

            return redirect('/trabalho')->with('message', 'Trabalho cadastrado com sucesso');
           

        } else {
            
            $trabalho = new Trabalho;
            $trabalho->titulo = $request->input('titulo');
            $trabalho->ano = $request->input('ano');
            $trabalho->periodo = $request->input('periodo');
            $trabalho->orientador_id = $request->input('orientador');
            $trabalho->academico()->attach($request->input('academico'));
            $trabalho->save();
            
            // $directory = 'trabalhos/' . $request->input('ano') . '/' . $request->input('titulo');
            // Storage::makeDirectory($directory);

            return redirect('/trabalho')->with('message', 'Trabalho cadastrado com sucesso');

        }


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

        $trabalho = Trabalho::find($id);

        $this->authorize('update', $trabalho);

        $qntacademicos = Trabalho::find($id)
                            ->academico()
                            ->count();

   
        $academico = DB::table('academicos as a')
                        ->join('users as u', 'u.id', '=', 'a.user_id')
                        ->orderBy('u.name')
                        ->pluck('u.name', 'a.id');

        $orientador = DB::table('membro_bancas as mb')
                        ->join('users as u', 'u.id', '=', 'mb.user_id')
                        ->orderBy('u.name')
                        ->pluck('u.name', 'mb.id');

        return view('trabalho.edit', [
            'trabalho' => $trabalho,
            'academico' => $academico,
            'orientador' => $orientador,
            'qntacademicos' => $qntacademicos,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TrabalhoRequest $request, $id) {
       
        // return $request->all();

        $trabalho = Trabalho::find($id);

        $this->authorize('update', $trabalho);

        $aprovado = 0;

        if($request->input('aprovado') == null) {
            $aprovado = 0;
        } else {
            $aprovado = 1;
        }

        if($trabalho->titulo != $request->input('titulo')) {
            //Storage::move('trabalhos/' . Carbon::parse(Trabalho::find($id)->ano)->format('Y') . '/' . Trabalho::find($id)->titulo, 
              //  'trabalhos/' . Carbon::parse(Trabalho::find($id)->ano)->format('Y') . '/' . $request->input('titulo'));
        }

        if ($request->input('academico1') != null && $request->input('coorientador') != null) {
            
            $qntacademicos = DB::table('academico_trabalhos as at')
                                    ->where('academico_id', $request->input('academico'))
                                    ->orWhere('academico_id', $request->input('academico1'))
                                    ->count();
            
            if($qntacademicos > 1) {
                return back()->with('message', 'Acadêmico já vinculado a um trabalho');
            }

            $trabalho->titulo = $request->input('titulo');
            $trabalho->ano = $request->input('ano');
            $trabalho->periodo = $request->input('periodo');
            $trabalho->aprovado = $aprovado;
            $trabalho->orientador_id = $request->input('orientador');
            $trabalho->coorientador_id = $request->input('coorientador');
            $trabalho->save();

            //$trabalho->academico()->sync([$request->input('academico') => $request->input('academico')]);
            //$trabalho->academico()->sync([$request->input('academico1') => $request->input('academico1')]);

            return redirect('/trabalho')->with('message', 'Trabalho atualizado com sucesso');

        } else {

            $qntacademicos = DB::table('academico_trabalhos as at')
                                    ->where('academico_id', $request->input('academico'))
                                    ->count();
            
            if($qntacademicos > 1) {
                return back()->with('message', 'Acadêmico já vinculado a um trabalho');
            }

            $trabalho->titulo = $request->input('titulo');
            $trabalho->ano = $request->input('ano');
            $trabalho->periodo = $request->input('periodo');
            $trabalho->aprovado = $aprovado;
            $trabalho->orientador_id = $request->input('orientador');
            $trabalho->coorientador_id = $request->input('coorientador');
            $trabalho->save();

            //$trabalho->academico()->updateExistingPivot($request->input('academico'), [$request->input('academico')]);

            return redirect('/trabalho')->with('message', 'Trabalho atualizado com sucesso');
           
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $this->authorize('delete', Trabalho::class);
    }
}
