<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\EtapaAnoRequest;

use App\Etapa;
use App\Trabalho;
use App\EtapaAno;
use App\EtapaTrabalho;
use DB;
use Carbon\Carbon;


class EtapaanoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('etapaano.index', [
            'etapaano' => EtapaAno::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('etapaano.create', [
            'etapa' => Etapa::all()->pluck('desc', 'id'),
            'trabalho' => Trabalho::all()->pluck('titulo', 'id')
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

        $this->validate($request, [
            'etapa' => 'required',
            'titulo' => 'required',
            'data_final' => 'required|after:today',
        ]);

        if ($request->has('data_inicial')) {

            if ($request->input('data_inicial') > $request->input('data_final')) {
                return back()->with('message', 'A Data Inicial não pode ser maior que a Data Final');
            } else {

                $etapa = new EtapaAno;
                $etapa->titulo = $request->input('titulo');
                $etapa->data_inicial = $request->input('data_inicial');
                $etapa->data_final = $request->input('data_final');
                $etapa->ativa = $request->input('ativa');
                $etapa->etapa()->associate($request->input('etapa'));
                $etapa->save();

                if ($request->has('trabalho')) {
                    $ultimoEtapaano = DB::table('etapa_anos')
                            ->latest()
                            ->first();        
                    EtapaAno::find($ultimoEtapaano->id)->trabalho()->attach(array_values($request->input('trabalho')));
                }

                return redirect('/etapaano')->with('message', 'Etapa cadastrada com sucesso');
            }

        } else {
            $etapa = new EtapaAno;
            $etapa->titulo = $request->input('titulo');
            $etapa->data_final = $request->input('data_final');
            $etapa->ativa = $request->input('ativa');
            $etapa->etapa()->associate($request->input('etapa'));
            $etapa->save();

            if ($request->has('trabalho')) {
                $ultimoEtapaano = DB::table('etapa_anos')
                        ->latest()
                        ->first();        
                EtapaAno::find($ultimoEtapaano->id)->trabalho()->attach(array_values($request->input('trabalho')));
            }

            return redirect('/etapaano')->with('message', 'Etapa cadastrada com sucesso');
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EtapaAnoRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
