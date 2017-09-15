<?php

namespace App\Http\Controllers;

use App\Notifications\ArquivoEnviado;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\ArquivoRequest;

use App\Arquivo;
use App\Trabalho;
use App\EtapaAno;
use App\AcademicoTrabalho;
use Auth;
use App\User;
use App\Academico;
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
            
//             return [
//                 $request->descricao->path(),
//                 $request->descricao->getClientOriginalName(),
//                 $request->descricao->getClientOriginalExtension(),
//                 $request->descricao->getClientSize(),
//                 $request->descricao->guessClientExtension(),
//                 $request->descricao->getMimeType(),
//             ];

            $etapaTrabalho = DB::table('etapa_trabalhos as et')
                                ->where('et.trabalho_id', $trabalhoid->id)
                                ->where('et.etapaano_id', $etapaanoid->id)
                                ->first();

            if($etapaTrabalho) {

                Auth::user()
                    ->etapatrabalho()
                    ->attach($etapaTrabalho->id, [
                        'descricao' => $request->descricao->getClientOriginalName(),
                        'extensao' => $request->descricao->getClientOriginalExtension(),
                        'mime' => $request->descricao->getMimeType()
                    ]);

                // Composicao do diretorio = ID no AnoLetivo _ ID do Trabalho _ ID da EtapaAno
                $directory = Session::get('anoletivo')->id . '/' . $trabalhoid->id . '/' . $etapaanoid->id . '/';

                // Composiçao do nome do arquivo = ID do Arquivo _ ID do Usuario logado _ nome do arquivo
                $nomeArquivo = $request->descricao->getClientOriginalName();

                Storage::putFileAs('public/' . $directory, $request->file('descricao'), $nomeArquivo);

                $ultimoArq = DB::table('arquivos')
                    ->latest()
                    ->first()
                    ->id;

                $academicoTrabalho = AcademicoTrabalho::where('ano_letivo_id', Session::get('anoletivo')->id)
                    ->where('trabalho_id', $trabalhoid->id)
                    ->get();

                for ($i = 0; $i < count($academicoTrabalho); $i++) {
                    $academico = User::find(Academico::find($academicoTrabalho[$i]->academico_id)->user_id);
                    $academico->notify(new ArquivoEnviado($ultimoArq));
                    $professorOri = User::find(Trabalho::find($academicoTrabalho[$i]->trabalho_id)->membrobanca()->value('user_id'));
                    $professorOri->notify(new ArquivoEnviado($ultimoArq));
                    if (User::find(Trabalho::find($academicoTrabalho[$i]->trabalho_id)->coorientador()->value('user_id')) != null) {
                        $professorCoo = User::find(Trabalho::find($academicoTrabalho[$i]->trabalho_id)->coorientador()->value('user_id'));
                        $professorCoo->notify(new ArquivoEnviado($ultimoArq));
                    }
                    sleep(1);
                }

            } else {

                $etapaanoid->trabalho()->attach($trabalhoid);

                $etapaTrabalho = DB::table('etapa_trabalhos')
                    ->latest()
                    ->first();

                Auth::user()
                    ->etapatrabalho()
                    ->attach($etapaTrabalho->id, [
                        'descricao' => $request->descricao->getClientOriginalName(),
                        'extensao' => $request->descricao->getClientOriginalExtension(),
                        'mime' => $request->descricao->getMimeType()
                    ]);

                // Composicao do diretorio = ID no AnoLetivo _ ID do Trabalho _ ID da EtapaAno
                $directory = Session::get('anoletivo')->id . '/' . $trabalhoid->id . '/' . $etapaanoid->id . '/';

                $ultimoArq = DB::table('arquivos')
                    ->latest()
                    ->first();

                // Composiçao do nome do arquivo = ID do Arquivo _ ID do Usuario logado _ nome do arquivo
                $nomeArquivo = $request->descricao->getClientOriginalName();

                Storage::putFileAs('public/' . $directory, $request->file('descricao'), $nomeArquivo);

                $ultimoArq = DB::table('arquivos')
                    ->latest()
                    ->first()
                    ->id;

                $academicoTrabalho = AcademicoTrabalho::where('ano_letivo_id', Session::get('anoletivo')->id)
                    ->where('trabalho_id', $trabalhoid->id)
                    ->get();

                for ($i = 0; $i < count($academicoTrabalho); $i++) {
                    $academico = User::find(Academico::find($academicoTrabalho[$i]->academico_id)->user_id);
                    $academico->notify(new ArquivoEnviado($ultimoArq));
                    $professorOri = User::find(Trabalho::find($academicoTrabalho[$i]->trabalho_id)->membrobanca()->value('user_id'));
                    $professorOri->notify(new ArquivoEnviado($ultimoArq));
                    if (User::find(Trabalho::find($academicoTrabalho[$i]->trabalho_id)->coorientador()->value('user_id')) != null) {
                        $professorCoo = User::find(Trabalho::find($academicoTrabalho[$i]->trabalho_id)->coorientador()->value('user_id'));
                        $professorCoo->notify(new ArquivoEnviado($ultimoArq));
                    }
                    sleep(1);
                }


            }

            return redirect('/etapaano')->with('message', 'Arquivo enviado com sucesso');
        
        } 

    }

    /**
     * Retorna os arquivos de um trabalho e etapa
     *
     * @param $id
     * @param $etapaanoid
     * @param $trabalhoid
     * @return mixed
     */
    public function show($id, $etapaanoid, $trabalhoid)
    {
        return response()->download(storage_path('app/public/' . Session::get('anoletivo')->id . '/' . $trabalhoid . '/' . $etapaanoid . '/' . Arquivo::find($id)->descricao));


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
     * Remove the specified resource from st/orage.
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
