<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TrabalhoRequest;

use App\Trabalho;
use App\Academico;
use App\User;
use DB;
use Auth;
use View;
use Carbon\Carbon;
// https://www.instagram.com/juolimon/
// Patricia Fecher
// https://www.facebook.com/luana.collaneri.1

class TrabalhoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        return view('trabalho.index', [
            'trabalho' => Trabalho::all()
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

        $avaliador = DB::table('membro_bancas as mb')
                        ->join('users as u', 'u.id', '=', 'mb.user_id')
                        ->orderBy('u.name')
                        ->pluck('u.name', 'mb.id');

        return View('trabalho.create', [
            'academico' => $academico,
            'avaliador' => $avaliador
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrabalhoRequest $request) {

        return $request->all();
        
        if ($request->has('academico1')) {

            $trabalho = new Trabalho;
            $trabalho->titulo = $request->input('titulo');
            $trabalho->ano = Carbon::createFromDate($request->input('ano'), 1, 1, 'America/Sao_Paulo');
            $trabalho->periodo = $request->input('periodo');
            $trabalho->avaliador()->associate($request->input('avaliador'));
            $trabalho->save();

            $ultimotrabalho = DB::table('trabalhos')
                                ->latest()
                                ->first();

            Academico::find($request->input('academico'))
                ->trabalho()
                ->associate($ultimotrabalho->id)
                ->save();
            
            Academico::find($request->input('academico1'))
                ->trabalho()
                ->associate($ultimotrabalho->id)
                ->save();

            $directory = 'trabalhos/' . $request->input('ano') . '/' . $request->input('titulo');
            Storage::makeDirectory($directory);

            return redirect('/trabalho');
            

        } else {
            
            $trabalho = new Trabalho;
            $trabalho->titulo = $request->input('titulo');
            $trabalho->ano = Carbon::createFromDate($request->input('ano'), 1, 1, 'America/Sao_Paulo');
            $trabalho->periodo = $request->input('periodo');
            $trabalho->avaliador()->associate($request->input('avaliador'));
            $trabalho->save();

            $ultimotrabalho = DB::table('trabalhos')
                                ->latest()
                                ->first();

            Academico::find($request->input('academico'))
                ->trabalho()
                ->associate($ultimotrabalho->id)
                ->save();
            
            $directory = 'trabalhos/' . $request->input('ano') . '/' . $request->input('titulo');
            Storage::makeDirectory($directory);

            return redirect('/trabalho');


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

        $academico = DB::table('academicos as a')
                        ->join('pessoas as p', 'p.id', '=', 'a.pessoa_id')
                        ->orderBy('p.nome')
                        ->pluck('p.nome', 'a.id');

        $avaliador = DB::table('avaliadors as a')
                        ->join('pessoas as p', 'p.id', '=', 'a.pessoa_id')
                        ->orderBy('p.nome')
                        ->pluck('p.nome', 'a.id');

        return view('trabalho.edit', [
            'trabalho' => $trabalho,
            'academico' => $academico,
            'avaliador' => $avaliador
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

        if(Trabalho::find($id)->titulo != $request->input('titulo')) {
            Storage::move('trabalhos/' . Carbon::parse(Trabalho::find($id)->ano)->format('Y') . '/' . Trabalho::find($id)->titulo, 
                'trabalhos/' . Carbon::parse(Trabalho::find($id)->ano)->format('Y') . '/' . $request->input('titulo'));
        }

        if ($request->input('academico1') != null) {
            
            Trabalho::find($id)->update([
                'titulo' => $request->input('titulo'),
                'periodo' => $request->input('periodo'),
                'ano' => Carbon::createFromDate($request->input('ano'), 1, 1, 'America/Sao_Paulo'),
                'aprovado' => $request->input('aprovado'),
                'avaliador_id' => $request->input('avaliador')
            ]);


            Academico::find($request->input('academico1'))
                        ->trabalho()
                        ->associate($id)
                        ->save();

            return redirect('/trabalho');

        } else {

            // Retornou os dois academicos
            $qntacademicos = DB::table('academicos as a')
                        ->where('a.trabalho_id', '=', $id)
                        ->get();
        
        
            if (count($qntacademicos) > 1) {
                // Ver qual academico foi retirado          
            
                for ($i = 0; $i < 2; $i++) { 
                    if ($qntacademicos[$i]->id != $request->input('academico')) {
                        Academico::find($qntacademicos[$i]->id)
                                ->trabalho()
                                ->dissociate($id)
                                ->save();
                    }
                }

            }

            Trabalho::find($id)->update([
                'titulo' => $request->input('titulo'),
                'periodo' => $request->input('periodo'),
                'ano' => Carbon::createFromDate($request->input('ano'), 1, 1, 'America/Sao_Paulo'),
                'aprovado' => $request->input('aprovado'),
                'avaliador_id' => $request->input('avaliador')
            ]);


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
