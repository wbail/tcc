<?php

namespace App\Http\Controllers;

use App\EtapaAno;
use App\EtapaTrabalho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TrabalhoRequest;
use Response;

use App\Trabalho;
use App\Academico;
use App\AnoLetivo;
use App\AcademicoTrabalho;
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

//            $trabalho = Trabalho::whereHas('membrobanca', function ($query) use ($departamento_id) {
//               $query->where('departamento_id', '=', $departamento_id);
//            })
//            ->orWhereHas('coorientador', function($query) use ($departamento_id) {
//                $query->where('departamento_id', '=', $departamento_id);
//            })
//            ->with('anoletivo.academico')
//            ->get();

//
//            $trabalhos = AcademicoTrabalho::with(['trabalho' => function ($query) use ($departamento_id) {
//                $query->whereHas('membrobanca', function ($query) use ($departamento_id) {
//                    $query->where('departamento_id', '=', $departamento_id);
//                })->orWhereHas('coorientador', function($query) use ($departamento_id) {
//                    $query->where('departamento_id', '=', $departamento_id);
//                })->with('membrobanca.user', 'coorientador.user')->get();
//            }])->get();

//
//            foreach ($trabalhos as $trabalho) {
//                $trabalhos->academico_id = User::find(Academico::find($trabalho->academico_id)->user_id)->name;
//            }

            $anos = AcademicoTrabalho::all();

            $toView = array();

            foreach ($anos as $ano) {

                if ($ano->trabalho_id != null) {

                    if (MembroBanca::find(Trabalho::find($ano->trabalho_id)->orientador_id)->departamento_id == $departamento_id) {

                        if (Trabalho::find($ano->trabalho_id)->coorientador_id) {

                            if (count(AcademicoTrabalho::where($ano->trabalho_id)) > 1) {

                                $toView[] = array(
                                    'id' => Trabalho::find($ano->trabalho_id)->id,
                                    'periodo' => Trabalho::find($ano->trabalho_id)->periodo,
                                    'anoletivo' => AnoLetivo::find(AcademicoTrabalho::where('trabalho_id', $ano->trabalho_id)->value('ano_letivo_id'))->rotulo,
                                    'academico' => User::find(Academico::find($ano->academico_id)->user_id)->name,
                                    'academico1' => User::find(Academico::find($ano->academico_id)->user_id)->name,
                                    'titulo' => Trabalho::find($ano->trabalho_id)->titulo,
                                    'orientador' => User::find(MembroBanca::find(Trabalho::find($ano->trabalho_id)->orientador_id)->user_id)->name,
                                    'coorientador' => User::find(MembroBanca::find(Trabalho::find($ano->trabalho_id)->coorientador_id)->user_id)->name,
                                );

                            } else {

                                $toView[] = array(
                                    'id' => Trabalho::find($ano->trabalho_id)->id,
                                    'periodo' => Trabalho::find($ano->trabalho_id)->periodo,
                                    'anoletivo' => AnoLetivo::find(AcademicoTrabalho::where('trabalho_id', $ano->trabalho_id)->value('ano_letivo_id'))->rotulo,
                                    'academico' => User::find(Academico::find($ano->academico_id)->user_id)->name,
                                    'titulo' => Trabalho::find($ano->trabalho_id)->titulo,
                                    'orientador' => User::find(MembroBanca::find(Trabalho::find($ano->trabalho_id)->orientador_id)->user_id)->name,
                                    'coorientador' => User::find(MembroBanca::find(Trabalho::find($ano->trabalho_id)->coorientador_id)->user_id)->name,
                                );
                            }

                        } else {
                            $toView[] = array(
                                'id' => Trabalho::find($ano->trabalho_id)->id,
                                'periodo' => Trabalho::find($ano->trabalho_id)->periodo,
                                'anoletivo' => AnoLetivo::find(AcademicoTrabalho::where('trabalho_id', $ano->trabalho_id)->value('ano_letivo_id'))->rotulo,
                                'academico' => User::find(Academico::find($ano->academico_id)->user_id)->name,
                                'titulo' => Trabalho::find($ano->trabalho_id)->titulo,
                                'orientador' => User::find(MembroBanca::find(Trabalho::find($ano->trabalho_id)->orientador_id)->user_id)->name,
                            );
                        }
                    }
                }
            }

            $toView = json_decode(json_encode((object) $toView), FALSE);

//            $trabalho = DB::table('academico_trabalhos as at')
//                ->join('trabalhos as t', 't.id', '=', 'at.trabalho_id')
//                ->join('membro_bancas as mb', function ($query) {
//                    $query->on('mb.id', '=', 't.orientador_id')
//                        ->orOn('mb.id', '=', 't.coorientador_id');
//                })
//                ->join('academicos as a', 'a.id', '=', 'at.academico_id')
//                ->join('users as u', function($query) {
//                    $query->on('u.id', '=', 'a.user_id')
//                        ->orOn('u.id', '=', 'mb.user_id');
//                })
//                ->join('ano_letivos as al', 'al.id', '=', 'at.ano_letivo_id')
//                ->where('mb.departamento_id', $departamento_id)
//                ->select('t.id', 't.titulo', 'u.name', 't.periodo', 'al.rotulo')
//                ->get();


            return view('trabalho.index', [
                'trabalhos' => $toView,
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
            ->join('academico_trabalhos as at', 'at.academico_id', '=', 'a.id')
            ->where('a.curso_id', Session::get('curso')->id)
            ->whereNull('at.trabalho_id')
            ->where('at.aprovado', 0)
            ->orderBy('u.name')
            ->pluck('u.name', 'a.id');

        $orientador = DB::table('membro_bancas as mb')
            ->join('users as u', 'u.id', '=', 'mb.user_id')
            ->where('mb.departamento_id', User::userMembroDepartamento()->departamento_id)
            ->orderBy('u.name')
            ->pluck('u.name', 'mb.id');

        $coorientador = DB::table('membro_bancas as mb')
            ->join('users as u', 'u.id', '=', 'mb.user_id')
            ->orderBy('u.name')
            ->pluck('u.name', 'mb.id');

        return View('trabalho.create', [
            'academico' => $academico,
            'orientador' => $orientador,
            'coorientador' => $coorientador
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TrabalhoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrabalhoRequest $request) {

        $this->authorize('create', Trabalho::class);
        
        if ($request->has('academico1') && $request->has('coorientador')) {

            if (Academico::find($request->input('academico'))->curso_id != Academico::find($request->input('academico1'))->curso_id) {
                return back()->with('message', 'Os alunos devem ser do mesmo curso.')
                    ->withInput();
            }
        
            $trabalho = new Trabalho;
            $trabalho->sigla = $request->input('sigla');
            $trabalho->titulo = $request->input('titulo');
            $trabalho->periodo = $request->input('periodo');
            $trabalho->orientador_id = $request->input('orientador');
            $trabalho->coorientador_id = $request->input('coorientador');
            $trabalho->anoletivo_id = session()->get('anoletivo')->id;
            $trabalho->save();

            $academico = Academico::find($request->input('academico'));
            $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)->count();
            if ($academicoTrabalho > 1) {

                $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)
                    ->where('ano_letivo_id', Session::get('anoletivo')->id);
                $academicoTrabalho->trabalho_id = $trabalho->id;
                $academicoTrabalho->save();

            } else {
                $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)->first();
                $academicoTrabalho->trabalho_id = $trabalho->id;
                $academicoTrabalho->save();
            }

            $academico = Academico::find($request->input('academico1'));
            $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)->count();
            if ($academicoTrabalho > 1) {

                $academico->anoletivo()->attach(session()->get('anoletivo')->id);
                $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)
                    ->where('ano_letivo_id', Session::get('anoletivo')->id);
                $academicoTrabalho->trabalho_id = $trabalho->id;
                $academicoTrabalho->save();

            } else {
                $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)->first();
                $academicoTrabalho->trabalho_id = $trabalho->id;
                $academicoTrabalho->save();
            }


            return redirect('/trabalho')->with('message', 'Trabalho cadastrado com sucesso');
            
        } elseif($request->has('academico1')) {

            if (Academico::find($request->input('academico'))->curso_id != Academico::find($request->input('academico1'))->curso_id) {
                return back()->with('message', 'Os alunos devem ser do mesmo curso')
                    ->withInput();
            }
            
            $trabalho = new Trabalho;
            $trabalho->sigla = $request->input('sigla');
            $trabalho->titulo = $request->input('titulo');
            $trabalho->periodo = $request->input('periodo');
            $trabalho->orientador_id = $request->input('orientador');
            $trabalho->anoletivo_id = session()->get('anoletivo')->id;
            $trabalho->save();

//            $academico = Academico::find($request->input('academico'));
//            $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)->first();
//            $academicoTrabalho->trabalho_id = $trabalho->id;
//            $academicoTrabalho->save();

            $academico = Academico::find($request->input('academico'));
            $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)->count();
            if ($academicoTrabalho > 1) {

                $academico->anoletivo()->attach(session()->get('anoletivo')->id);
                $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)
                    ->where('ano_letivo_id', Session::get('anoletivo')->id);
                $academicoTrabalho->trabalho_id = $trabalho->id;
                $academicoTrabalho->save();

            } else {
                $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)->first();
                $academicoTrabalho->trabalho_id = $trabalho->id;
                $academicoTrabalho->save();
            }

            $academico = Academico::find($request->input('academico1'));
            $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)->count();
            if ($academicoTrabalho > 1) {

                $academico->anoletivo()->attach(session()->get('anoletivo')->id);
                $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)
                    ->where('ano_letivo_id', Session::get('anoletivo')->id);
                $academicoTrabalho->trabalho_id = $trabalho->id;
                $academicoTrabalho->save();

            } else {
                $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)->first();
                $academicoTrabalho->trabalho_id = $trabalho->id;
                $academicoTrabalho->save();
            }


            return redirect('/trabalho')->with('message', 'Trabalho cadastrado com sucesso');
           

        } else {

            $trabalho = new Trabalho;
            $trabalho->titulo = $request->input('titulo');
            $trabalho->sigla = $request->input('sigla');
            $trabalho->periodo = $request->input('periodo');
            $trabalho->orientador_id = $request->input('orientador');
            $trabalho->anoletivo_id = session()->get('anoletivo')->id;
            $trabalho->save();

            $academico = Academico::find($request->input('academico'));
            $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)->count();

            if ($academicoTrabalho > 1) {

                $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)
                    ->whereNull('ano_letivo_id')
                    ->first();
                $academicoTrabalho->ano_letivo_id = Session::get('anoletivo')->id;
                $academicoTrabalho->trabalho_id = $trabalho->id;
                $academicoTrabalho->save();

            } else {
                $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)->first();
                $academicoTrabalho->trabalho_id = $trabalho->id;
                $academicoTrabalho->save();
            }

            return redirect('/trabalho')->with('message', 'Trabalho cadastrado com sucesso');

        }

        $etapaano = EtapaAno::all();

        for ($i = 0; $i < count($etapaano); $i++) {
            $etapaano[$i]->trabalho()->attach(DB::table('trabalhos')->latest()->value('id'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $trabalho = AcademicoTrabalho::where('trabalho_id', $id)
                    ->join('academicos as a', 'a.id', '=', 'academico_trabalhos.academico_id')
                    ->join('users as u', 'u.id', '=', 'a.user_id')
                    ->join('trabalhos as t', 't.id', '=', 'academico_trabalhos.trabalho_id')
                    ->join('membro_bancas as mb', function($q) {
                        $q->on('mb.id', '=', 't.orientador_id')
                        ->orOn('mb.id', '=', 't.coorientador_id');
                    })
                    ->join('users as us', 'us.id', '=', 'mb.user_id')
                    ->select('a.id as aid', 'u.name as nome_aluno', 'mb.id as mid', 'us.name as nome_ori')
                    ->get();
                
        return Response::json($trabalho);
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

        $academicos = AcademicoTrabalho::where('trabalho_id', $id)
            ->get();

        $qntacademicos = AcademicoTrabalho::where('trabalho_id', $id)
                            ->count();

        $academico = DB::table('academicos as a')
                        ->join('users as u', 'u.id', '=', 'a.user_id')
                        ->orderBy('u.name')
                        ->pluck('u.name', 'a.id');

        $orientador = DB::table('membro_bancas as mb')
            ->join('users as u', 'u.id', '=', 'mb.user_id')
            ->where('mb.departamento_id', User::userMembroDepartamento()->departamento_id)
            ->orderBy('u.name')
            ->pluck('u.name', 'mb.id');

        $coorientador = DB::table('membro_bancas as mb')
            ->join('users as u', 'u.id', '=', 'mb.user_id')
            ->orderBy('u.name')
            ->pluck('u.name', 'mb.id');

        return view('trabalho.edit', [
            'trabalho' => $trabalho,
            'academico' => $academico,
            'orientador' => $orientador,
            'coorientador' => $coorientador,
            'qntacademicos' => $qntacademicos,
            'academicos' => $academicos,
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

        if ($request->input('academico1') != null && $request->input('coorientador') != null) {

            if (Academico::find($request->input('academico'))->curso_id != Academico::find($request->input('academico1'))->curso_id) {
                return back()->with('message', 'Os alunos devem ser do mesmo curso.')
                    ->withInput();
            }


            $trabalho->titulo = $request->input('titulo');
            $trabalho->sigla = $request->input('sigla');
            $trabalho->periodo = $request->input('periodo');
            $trabalho->aprovado = $aprovado;
            $trabalho->orientador_id = $request->input('orientador');
            $trabalho->coorientador_id = $request->input('coorientador');
            $trabalho->save();

            $academicoTrabalho = AcademicoTrabalho::where('trabalho_id', $trabalho->id)
                ->count();

            if ($academicoTrabalho > 1) {
                $academicoTrabalho = AcademicoTrabalho::where('trabalho_id', $trabalho->id)
                    ->get();
                for ($i = 0; $i < count($academicoTrabalho); $i++) {

                }
            }

            $academico = Academico::find($request->input('academico'));
            $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)->first();
            $academicoTrabalho->trabalho_id = $trabalho->id;
            $academicoTrabalho->save();

            $academico = Academico::find($request->input('academico1'));
            $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)->first();
            $academicoTrabalho->trabalho_id = $trabalho->id;
            $academicoTrabalho->save();

            $at = AcademicoTrabalho::where('academico_id', $request->input('academico1'))
                ->first();
            $at->ano_letivo_id = Session::get('anoletivo')->id;
            $at->save();

            return redirect('/trabalho')->with('message', 'Trabalho atualizado com sucesso');

        } elseif($request->input('academico1') != null) {

            if (Academico::find($request->input('academico'))->curso_id != Academico::find($request->input('academico1'))->curso_id) {
                return back()->with('message', 'Os alunos devem ser do mesmo curso.')
                    ->withInput();
            }

            $trabalho->titulo = $request->input('titulo');
            $trabalho->sigla = $request->input('sigla');
            $trabalho->periodo = $request->input('periodo');
            $trabalho->aprovado = $aprovado;
            $trabalho->orientador_id = $request->input('orientador');
            $trabalho->coorientador_id = $request->input('coorientador');
            $trabalho->save();

            $academico = Academico::find($request->input('academico1'));
            $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)->first();
            $academicoTrabalho->trabalho_id = $trabalho->id;
            $academicoTrabalho->save();

            $at = AcademicoTrabalho::where('academico_id', $request->input('academico1'))
                ->first();

            if ($at->ano_letivo_id == null) {
                $at->ano_letivo_id = Session::get('anoletivo')->id;
            }

            $at->save();

            return redirect('/trabalho')->with('message', 'Trabalho atualizado com sucesso');


        } else {

            $qntacademicos = DB::table('academico_trabalhos as at')
                                    ->where('academico_id', $request->input('academico'))
                                    ->count();
            
            if($qntacademicos > 1) {
                return back()->with('message', 'Acadêmico já vinculado a um trabalho');
            }

            $trabalho->titulo = $request->input('titulo');
            $trabalho->sigla = $request->input('sigla');
            $trabalho->periodo = $request->input('periodo');
            $trabalho->aprovado = $aprovado;
            $trabalho->orientador_id = $request->input('orientador');
            $trabalho->coorientador_id = $request->input('coorientador');
            $trabalho->save();

            $academico = Academico::find($request->input('academico'));
            $academicoTrabalho = AcademicoTrabalho::where('academico_id', $academico->id)->first();
            $academicoTrabalho->trabalho_id = $trabalho->id;
            $academicoTrabalho->save();

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

        $this->authorize('create', Trabalho::class);

        if (EtapaTrabalho::where('trabalho_id', $id)->count() > 0) {
            return back()->with('message-del', 'Não é possível excluir o trabalho.');
        } else {
            AcademicoTrabalho::where('trabalho_id', $id)
                ->update([
                    'trabalho_id' => null
                ]);

            Trabalho::find($id)->delete();

            return redirect('/trabalho')->with('message', 'Trabalho excluído com sucesso.');
        }

    }
}
