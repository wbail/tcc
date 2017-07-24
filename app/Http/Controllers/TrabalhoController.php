<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TrabalhoRequest;

use App\Trabalho;
use App\Academico;
use App\User;
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

        // return Trabalho::with('membrobanca')->with('coorientador')->get();

        return view('trabalho.index', [
            'trabalho' => Trabalho::with('membrobanca')->with('coorientador')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

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
        
        if ($request->has('academico1') && $request->has('coorientador')) {

            $trabalho = new Trabalho;
            $trabalho->titulo = $request->input('titulo');
            $trabalho->ano = $request->input('ano');
            $trabalho->periodo = $request->input('periodo');
            $trabalho->orientador_id = $request->input('orientador');
            $trabalho->coorientador_id = $request->input('coorientador');
            $trabalho->save();

            $lastTrabalho = DB::table('trabalhos')
                        ->latest()
                        ->first();

            $lastTrabalho = Trabalho::find($lastTrabalho->id);

            $lastTrabalho->academico()->sync([$request->input('academico'), $request->input('academico1')]);
            

            // $directory = 'trabalhos/' . $request->input('ano') . '/' . $request->input('titulo');
            // Storage::makeDirectory($directory);

            return redirect('/trabalho')->with('message', 'Trabalho cadastrado com sucesso');
            

        } else {
            
            $trabalho = new Trabalho;
            $trabalho->titulo = $request->input('titulo');
            $trabalho->ano = $request->input('ano');
            $trabalho->periodo = $request->input('periodo');
            $trabalho->orientador_id = $request->input('orientador');
            $trabalho->save();

            $lastTrabalho = DB::table('trabalhos')
                                ->latest()
                                ->first();

            $lastTrabalho = Trabalho::find($lastTrabalho->id);

            $lastTrabalho->academico()->attach($request->input('academico'));
            
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

        $qntacademicos = Trabalho::find($id)
                            ->academico()
                            ->count();

        $trabalho = Trabalho::find($id);
   
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

        if($request->input('aprovado') == null) {
            $aprovado = 0;
        } else {
            $aprovado = 1;
        }

        if(Trabalho::find($id)->titulo != $request->input('titulo')) {
            //Storage::move('trabalhos/' . Carbon::parse(Trabalho::find($id)->ano)->format('Y') . '/' . Trabalho::find($id)->titulo, 
              //  'trabalhos/' . Carbon::parse(Trabalho::find($id)->ano)->format('Y') . '/' . $request->input('titulo'));
        }

        if ($request->input('academico1') != null && $request->input('coorientador') != null) {
            
            $trabalho->titulo = $request->input('titulo');
            $trabalho->ano = $request->input('ano');
            $trabalho->periodo = $request->input('periodo');
            $trabalho->aprovado = $aprovado;
            $trabalho->orientador_id = $request->input('orientador');
            $trabalho->coorientador_id = $request->input('coorientador');
            $trabalho->save();

            $trabalho->academico()->updateExistingPivot($request->input('academico'), [$request->input('academico')]);
            $trabalho->academico()->updateExistingPivot($request->input('academico1'), [$request->input('academico1')]);

            return redirect('/trabalho');

        } else {

            $trabalho->titulo = $request->input('titulo');
            $trabalho->ano = $request->input('ano');
            $trabalho->periodo = $request->input('periodo');
            $trabalho->aprovado = $aprovado;
            $trabalho->orientador_id = $request->input('orientador');
            $trabalho->coorientador_id = $request->input('coorientador');
            $trabalho->save();

            $trabalho->academico()->updateExistingPivot($request->input('academico'), [$request->input('academico')]);

            return redirect('/trabalho');
           
        }



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
