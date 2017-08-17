<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArquivoRequest;

use App\Arquivo;
use App\Trabalho;
use App\EtapaAno;
use Auth;
use DB;

class ArquivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArquivoRequest $request, EtapaAno $etapaanoid, Trabalho $trabalhoid)
    {
        
        if($request->hasFile('descricao')) {
            
            // return [
            //     $request->descricao->path(),
            //     $request->descricao->getClientOriginalName(),
            //     $request->descricao->getClientOriginalExtension(),
            //     $request->descricao->getClientSize(),
            //     $request->descricao->guessClientExtension(),
            //     $request->descricao->getMimeType(),
            // ];

            $etapaTrabalho = DB::table('etapa_trabalhos as et')
                                ->where('et.trabalho_id', $trabalhoid->id)
                                ->where('et.etapaano_id', $etapaanoid->id)
                                ->first();

            if($etapaTrabalho) {
                Auth::user()
                    ->etapatrabalho()
                    ->attach($etapaTrabalho->id, [
                        'descricao' => $request->descricao->getClientOriginalName()
                    ]);
                    
            } else {

                $etapaanoid->trabalho()->attach($trabalhoid);

                $etapaTrabalho = DB::table('etapa_trabalhos')
                                    ->latest()
                                    ->first();
                
                Auth::user()
                    ->etapatrabalho()
                    ->attach($etapaTrabalho->id, [
                        'descricao' => $request->descricao->getClientOriginalName()
                    ]);
            }

            return redirect('/etapaano')->with('message', 'Arquivo enviado com sucesso');
        
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
    public function update(ArquivoRequest $request, $id)
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
        Arquivo::find($id)->delete();
        return back()->with('message', 'Arquivo excluído com sucesso');
    }
}
