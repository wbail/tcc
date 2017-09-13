<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
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

                // Composicao do diretorio = ID no AnoLetivo _ ID do Trabalho _ ID da EtapaAno
                $directory = Session::get('anoletivo')->id . '/' . $trabalhoid->id . '/' . $etapaanoid->id . '/';

                // Composiçao do nome do arquivo = AnoMesDiaHoraMinutoSegundo _ ID do Usuario logado _ nome do arquivo
                $nomeArquivo = Carbon::now()->format('YmdHis') . '_' . Auth::user()->id . '_' . $request->descricao->getClientOriginalName();

                Storage::putFileAs($directory, $request->file('descricao'), $nomeArquivo);

                Auth::user()
                    ->etapatrabalho()
                    ->attach($etapaTrabalho->id, [
                        'descricao' => $request->descricao->getClientOriginalName()
                    ]);

            } else {

                $directory = Session::get('anoletivo')->id . '/' . $trabalhoid->id . '/' . $etapaanoid->id . '/';
                $nomeArquivo = Carbon::now()->format('YmdHis') . '_' . Auth::user()->id . '_' . $request->descricao->getClientOriginalName();

                Storage::putFileAs($directory, $request->file('descricao'), $nomeArquivo);

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
     * Retorna os arquivos de um trabalho e etapa
     *
     * @param Request $request
     * @param $etapaanoid
     * @param $trabalhoid
     * @return mixed
     */
    public function show(Request $request, $etapaanoid, $trabalhoid)
    {
        $dir = Session::get('anoletivo')->id . '/' . $trabalhoid . '/' . $etapaanoid . '/';
//        return $dir;
//        return Storage::get(Storage::allFiles($dir));

        $url = array();

        for ($i = 0; $i < count(Storage::allFiles($dir)); $i++) {
            Storage::setVisibility(Storage::allFiles($dir)[$i], 'public');
//            Storage::copy(Storage::allFiles($dir)[$i], 'public/' . Storage::allFiles($dir)[$i]);
            $url[] = Storage::url(Storage::allFiles($dir)[$i]);
        }

        return response()->make(storage_path($url[0]), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'."wfewef.pdf".'"'
        ]);

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
