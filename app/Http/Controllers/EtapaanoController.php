<?php

namespace App\Http\Controllers;

use App\AcademicoTrabalho;
use Illuminate\Http\Request;
use App\Http\Requests\EtapaAnoRequest;
use Illuminate\Support\Facades\Auth;
use App\Notifications\EtapaLembrete;

use App\Etapa;
use App\Trabalho;
use App\EtapaAno;
use App\EtapaTrabalho;
use App\Arquivo;
use App\User;
use App\Academico;
use App\MembroBanca;
use DB;
use Illuminate\Support\Facades\Session;

class EtapaanoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $membrobanca = MembroBanca::where('user_id', '=', Auth::user()->id)
            ->first();

        $departamento_id = '';

        if (isset($membrobanca->departamento_id)) {
            $departamento_id = $membrobanca->departamento_id;
        }

        $academico = Academico::where('user_id', '=', Auth::user()->id)
            ->first();

        if($membrobanca) {

            if(Auth::user()->permissao == 9) {

                $objetos = array();
                $qntArquivos = array();

                $trabalho = Trabalho::whereHas('membrobanca', function($q) use ($departamento_id) {
                    $q->where('departamento_id', '=', $departamento_id);
                })
                ->orWhereHas('coorientador', function($q) use ($departamento_id) {
                    $q->where('departamento_id', '=', $departamento_id);
                })
                ->whereHas('anoletivo', function ($query) {
                    $query->where('ativo', 1);
                })
                ->get();

                for ($i = 0; $i < count($trabalho); $i++) {

                    $objetos[] = DB::select(/** @lang sql */
                                            'select distinct ea.titulo as descricao
                                                  , t.sigla
                                                  , t.titulo
                                                  , ea.ativa
                                                  , ea.data_final
                                                  , ea.id
                                                  , t.id as trabalho_id
                                               from etapa_anos as ea
                                               left join etapa_trabalhos as et
                                                 on et.etapaano_id = ea.id
                                               left join trabalhos as t
                                                 on t.id = ?
                                              inner join ano_letivos as al
                                                 on al.id = t.anoletivo_id
                                              where al.ativo = ?', [$trabalho[$i]->id, 1]);
                }

//                for ($i = 0; $i < count($objetos) - 1; $i++) {
//                    for ($j = $i; count($objetos[$i][$j]->id); $j++) {
//                        if (!is_null($objetos[$i][$j]->id)) {
//                            $qntArquivos[] = DB::table('arquivos as a')
//                                ->join('etapa_trabalhos as et', 'et.id', '=', 'a.etapatrabalho_id')
//                                ->join('etapa_anos as ea', 'ea.id', '=', 'et.etapaano_id')
//                                ->join('trabalhos as t', 't.id', '=', 'et.trabalho_id')
//                                ->where('ea.id', '=', $objetos[$i][$j]->id)
//                                ->where('t.id', '=', $objetos[$i][$j]->trabalho_id)
//                                ->whereNull('a.deleted_at')
//                                ->count();
//                        }
//                    }
//                }
//
//                return $qntArquivos;

                return view('etapaano.index', [
                    'etapaano' => $objetos
                ]);

            } else {
                $objetos = array();

                $trabalho = Trabalho::where('orientador_id', '=', $membrobanca->id)
                                    ->orWhere('coorientador_id', '=', $membrobanca->id)
                                    ->get();

                for ($i = 0; $i < count($trabalho); $i++) { 
                    
                    $objetos[] = DB::select(/** @lang sql */
                                            'select distinct ea.titulo as descricao
                                                  , t.sigla
                                                  , t.titulo
                                                  , ea.ativa
                                                  , ea.data_final
                                                  , ea.id
                                                  , t.id as trabalho_id
                                               from etapa_anos as ea
                                               left join etapa_trabalhos as et
                                                 on et.etapaano_id = ea.id
                                               left join trabalhos as t
                                                 on t.id = ?
                                               inner join ano_letivos as al
                                                 on al.id = t.anoletivo_id
                                              where al.ativo = ?', [$trabalho[$i]->id, 1]);

                }
                
                return view('etapaano.index', [
                    'etapaano' => $objetos
                ]);
            }


        } elseif($academico) {

            $trabalho = AcademicoTrabalho::where('academico_id', $academico->id)
                ->first();
            
            $objetos[] = DB::select(/** @lang sql */
                                    'select distinct ea.titulo as descricao
                                          , t.sigla
                                          , t.titulo
                                          , ea.ativa
                                          , ea.data_final
                                          , ea.id
                                          , t.id as trabalho_id
                                       from etapa_anos as ea
                                       left join etapa_trabalhos as et
                                         on et.etapaano_id = ea.id
                                       left join trabalhos as t
                                         on t.id = ?
                                      inner join ano_letivos as al
                                         on al.id = t.anoletivo_id
                                      where al.ativo = ?', [$trabalho->trabalho_id, 1]);

            // return $objetos;

            return view('etapaano.index', [
                'etapaano' => $objetos
            ]);

        } else {

            return view('etapaano.index', [
                'etapaano' => EtapaAno::all()
            ]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', EtapaAno::class);

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
    public function store(EtapaAnoRequest $request)
    {
        $this->authorize('create', EtapaAno::class);

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


                $etapaano = DB::table('etapa_anos')
                    ->latest()
                    ->first()
                    ->id;

                $academicoTrabalho = AcademicoTrabalho::where('ano_letivo_id', Session::get('anoletivo')->id)
                    ->get();

                for ($i = 0; $i < count($academicoTrabalho); $i++) {
                    $academico = User::find(Academico::find($academicoTrabalho[$i]->academico_id)->user_id);
                    $academico->notify(new EtapaLembrete($etapaano));
                    $professorOri = User::find(Trabalho::find($academicoTrabalho[$i]->trabalho_id)->membrobanca()->value('user_id'));
                    $professorOri->notify(new EtapaLembrete($etapaano));
                    if (User::find(Trabalho::find($academicoTrabalho[$i]->trabalho_id)->coorientador()->value('user_id')) != null) {
                        $professorCoo = User::find(Trabalho::find($academicoTrabalho[$i]->trabalho_id)->coorientador()->value('user_id'));
                        $professorCoo->notify(new EtapaLembrete($etapaano));
                    }
                    sleep(2);
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

            $etapaano = DB::table('etapa_anos')
                ->latest()
                ->first()
                ->id;

            $academicoTrabalho = AcademicoTrabalho::where('ano_letivo_id', Session::get('anoletivo')->id)
                ->get();

            for ($i = 0; $i < count($academicoTrabalho); $i++) {
                $academico = User::find(Academico::find($academicoTrabalho[$i]->academico_id)->user_id);
                $academico->notify(new EtapaLembrete($etapaano));
                $professorOri = User::find(Trabalho::find($academicoTrabalho[$i]->trabalho_id)->membrobanca()->value('user_id'));
                $professorOri->notify(new EtapaLembrete($etapaano));
                if (User::find(Trabalho::find($academicoTrabalho[$i]->trabalho_id)->coorientador()->value('user_id')) != null) {
                    $professorCoo = User::find(Trabalho::find($academicoTrabalho[$i]->trabalho_id)->coorientador()->value('user_id'));
                    $professorCoo->notify(new EtapaLembrete($etapaano));
                }
                sleep(2);
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
    public function show($id, $trabalhoid)
    {
        $trabalho = DB::table('arquivos as a')
            ->join('users as u', 'u.id', '=', 'a.user_id')
            ->join('etapa_trabalhos as et', 'et.id', '=', 'a.etapatrabalho_id')
            ->join('etapa_anos as ea', 'ea.id', '=', 'et.etapaano_id')
            ->join('trabalhos as t', 't.id', '=', 'et.trabalho_id')
            ->where('ea.id', '=', $id)
            ->where('t.id', '=', $trabalhoid)
            ->whereNull('a.deleted_at')
            ->select('a.id', 'a.descricao', 'a.created_at', 'u.name')
            ->orderBy('a.created_at', 'desc')
            ->get();

        return response()->json($trabalho);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('create', EtapaAno::class);

        return view('etapaano.edit', [
            'etapaano' => EtapaAno::find($id),
            'etapa' => Etapa::all()->pluck('desc', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $etapa = EtapaAno::find($id);

        
        $this->authorize('update', $etapa);
        
        if ($request->has('data_inicial')) {

            if ($request->input('data_inicial') > $request->input('data_final')) {
                return back()->with('message', 'A Data Inicial não pode ser maior que a Data Final');
            } else {

                $etapa->update([
                    'titulo' => $request->input('titulo'),
                    'data_inicial' => $request->input('data_inicial'),
                    'data_final' => $request->input('data_final'),
                    'ativa' => $request->input('ativa')
                ]);

                $etapa->etapa()->dissociate($etapa->etapa_id);
                $etapa->etapa()->associate($request->input('etapa'));
                $etapa->save();

                return redirect('/etapaano')->with('message', 'Etapa atualizada com sucesso');
            }

        } else {
            
            $etapa->update([
                'titulo' => $request->input('titulo'),
                'data_inicial' => $request->input('data_inicial'),
                'data_final' => $request->input('data_final'),
                'ativa' => $request->input('ativa')
            ]);

            $etapa->etapa()->dissociate($etapa->etapa_id);
            $etapa->etapa()->associate($request->input('etapa'));
            $etapa->save();
            
            return redirect('/etapaano')->with('message', 'Etapa atualizada com sucesso');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', EtapaAno::class);
    }
}
