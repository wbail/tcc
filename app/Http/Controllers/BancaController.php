<?php

namespace App\Http\Controllers;

use App\AcademicoTrabalho;
use App\AnoLetivo;
use App\CoordenadorCurso;
use Illuminate\Http\Request;
use App\Http\Requests\BancaRequest;
use Session;

use App\Policies\BancaPolicy;
use PDF;
use Auth;
use DB;
use App\Banca;
use App\Etapa;
use App\EtapaAno;
use App\User;
use App\Departamento;
use App\Academico;
use App\Trabalho;
use App\MembroBanca;
use \Carbon\Carbon;

class BancaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instituicao = 0;

        $departamento_id = Auth::user()
            ->membrobanca()
            ->value('departamento_id');

        if($departamento_id) {

            $instituicao = Departamento::find($departamento_id)
                ->instituicao()
                ->first();

            $this->authorize('view', $instituicao);

            $d = User::userMembroDepartamento()->departamento_id;

//        $banca = Banca::with(['trabalho.membrobanca' => function($query) use ($d) {
//            $query->where('departamento_id', '=', $d);
//        }], 'trabalho.coorientador')
//            ->with('academicotrabalho')
//            ->get();

//        $banca = collect($banca)
//            ->unique('trabalho_id')
//            ->values()
//            ->all();


//        $banca = DB::select('select t.sigla
//                                  , t.titulo
//                                  , t.id as trabalho_id
//                                  , u.name
//                                  , b.data
//                                  , b.id
//                               from bancas b
//                              inner join trabalhos t
//                                 on b.trabalho_id = t.id
//                              inner join membro_bancas mb
//                                 on b.membrobanca_id = mb.id
//                              inner join academico_trabalhos at
//                                 on t.id = at.trabalho_id
//                              inner join academicos a
//                                 on at.academico_id = a.id
//                              inner join users u
//                                 on a.user_id = u.id
//                              where at.ano_letivo_id = ?
//                              ', [Session::get('anoletivo')->id]);

            $banca = DB::table('bancas as b')
                ->join('trabalhos as t', 't.id', '=', 'b.trabalho_id')
                ->join('membro_bancas as mb', 'mb.id', '=', 'b.membrobanca_id')
                ->join('academico_trabalhos as at', 'at.trabalho_id', '=', 'b.trabalho_id')
                ->join('membro_bancas as mbx', function ($query) use ($d) {
                    $query->where('mbx.departamento_id', $d);
                })
                ->where('at.ano_letivo_id', Session::get('anoletivo')->id)
                ->get();

            $banca = collect($banca)
                ->unique('trabalho_id')
                ->values()
                ->all();

//        return $banca;

            $orientador = array();

            for ($i = 0; $i < count($banca); $i++) {
                if (MembroBanca::find($banca[$i]->coorientador_id)) {

                    $orientador[] = array(
                        'orientador' => User::find(MembroBanca::find($banca[$i]->orientador_id)->user_id)->name,
                        'coorientador' => User::find(MembroBanca::find($banca[$i]->coorientador_id)->user_id)->name,
                    );
                } else {
                    $orientador[] = array(
                        'orientador' => User::find(MembroBanca::find($banca[$i]->orientador_id)->user_id)->name,
                    );
                }
            }

//        return $banca;

            return view('banca.index', [
                'banca' => $banca,
                'orientador' => $orientador,
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
    public function create()
    {
        $this->authorize('create', Banca::class);

        $etapaano = Etapa::where('banca', 1)
            ->first();

        $etapaano = EtapaAno::where('etapa_id', $etapaano->id)
            ->first();

        if ($etapaano == null) {
            return redirect('admin')->with('message', 'Deve-se criar uma etapa de semana de bancas primeiro.');
        }

        $departamento_id = User::userMembroDepartamento()->departamento_id;

        $trabalho = Trabalho::whereHas('membrobanca', function($q) use ($departamento_id) {
            $q->where('departamento_id', '=', $departamento_id);
        })->orWhereHas('coorientador', function($q) use ($departamento_id) {
            $q->where('departamento_id', '=', $departamento_id);
        })->whereHas('anoletivo', function ($query) {
            $query->where('ativo', 1);
        })
        ->orderBy('sigla')
        ->select(DB::raw('concat(trabalhos.sigla, \' - \', trabalhos.titulo) as sigla'), 'trabalhos.id')
        ->pluck('sigla', 'id');

        $membros = MembroBanca::join('users as u', 'u.id', '=', 'membro_bancas.user_id')
            ->leftJoin('bancas as b', 'b.membrobanca_id', '=', 'membro_bancas.id')
            ->groupBy('u.name', 'membro_bancas.id')
            ->select('membro_bancas.id', DB::raw('concat(u.name, \' - \', count(b.membrobanca_id), \' banca(s)\') as nome'))
            ->orderBy('u.name', 'asc')
            ->pluck('nome', 'membro_bancas.id');

        return view('banca.create', [
            'trabalho' => $trabalho,
            'membros' => $membros
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BancaRequest $request)
    {
        $this->authorize('create', Banca::class);
        
//        return $request->all();
        
        $trabalho = Trabalho::find($request->input('trabalho'));

        $valores_membros = array(
            $request->input('membro'),
            $request->input('membro2'),
            $request->input('suplente'),
            $request->input('suplente2')
        );

        if(in_array(2,array_count_values($valores_membros))) {
            return back()
                    ->with('message', 'Os Membros de Banca devem ser distintos.')
                    ->withInput();
        }

        if(in_array($trabalho->orientador_id, $valores_membros)) {
            return back()
                    ->with('message', 'O Orientador já faz parte da banca.')
                    ->withInput();
        } else if(in_array($trabalho->coorientador_id, $valores_membros)) {
            return back()
                    ->with('message', 'O Coorientador não participa da banca.')
                    ->withInput();
        }

        $etapaano = Etapa::where('banca', 1)
                        ->first();
                        
        $etapaano = EtapaAno::where('etapa_id', $etapaano->id)
                ->first();
        
        for ($i = 0; $i < count($valores_membros); $i++) { 
            DB::insert('insert into bancas (papel, membrobanca_id, etapaano_id, trabalho_id, created_at, updated_at) values (?, ?, ?, ?, ?, ?)', [
                ($i+1),
                $valores_membros[$i],
                $etapaano->id,
                $trabalho->id,
                Carbon::now(),
                Carbon::now()
            ]);
        }

        return redirect('/banca')->with('message', 'Banca cadastrada com sucesso');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('create', Banca::class);

        $d = User::userMembroDepartamento()->departamento_id;

//        $banca = Banca::where('trabalho_id', $id)->with(['trabalho.membrobanca' => function($query) use ($d) {
//            $query->where('departamento_id', '=', $d);
//        }], 'trabalho.coorientador')
//            ->with('academicotrabalho')
//            ->get();
//

        $banca = DB::select('select t.sigla
                          , t.titulo
                          , t.id as trabalho_id
                          , u.name as nome_aluno
                          , ux.name as nome_prof
                          , b.data
                          , b.id
                          , b.papel
                       from bancas b
                      inner join trabalhos t
                         on b.trabalho_id = t.id
                      inner join membro_bancas mb
                         on b.membrobanca_id = mb.id
                      inner join users as ux
                         on ux.id = mb.user_id
                      inner join academico_trabalhos at
                         on t.id = at.trabalho_id
                      inner join academicos a
                         on at.academico_id = a.id
                      inner join users u
                         on a.user_id = u.id
                      where at.ano_letivo_id = ?
                        and t.id = ?
                      ', [Session::get('anoletivo')->id, $id]);

        $banca = collect($banca)
//            ->unique('trabalho_id')
            ->values()
            ->all();

//        return $banca;

        $aluno = array();
        $prof = array();
        $orientador = User::find(MembroBanca::find(Trabalho::find($banca[0]->trabalho_id)->orientador_id)->user_id)->name;

        for($i = 0; $i < count($banca); $i++) {
            $aluno[] = $banca[$i]->nome_aluno;
            $prof[] = $banca[$i]->nome_prof;
        }

        $alunos = array ($aluno[0], $aluno[1]);
        $profs = array ($prof[0], $prof[2]);

        if (count(array_unique($alunos)) === 1) {

            return PDF::loadView('banca.cert', [
                'banca' => $banca,
                'coordenadorTcc' => Auth::user()->name,
                'aluno' => $alunos[0],
                'prof' => $profs,
                'orientador' => $orientador,
            ])->stream();
        } else {

            return PDF::loadView('banca.cert', [
                'banca' => $banca,
                'coordenadorTcc' => Auth::user()->name,
                'aluno' => $alunos,
                'prof' => $profs,
                'orientador' => $orientador,
            ])->stream();
        }



        ///////////////////////////////////

        $membrosBanca = array();

        // Pegando apenas as pessoas que teoricamente tem presença confirmada
        // mas e se um membro suplente é quem participou?
        for ($i = 0; $i < count($banca); $i++) {
            if ($banca[$i]->papel == 1 || $banca[$i]->papel == 2) {
                $membrosBanca[] = User::find(MembroBanca::find($banca[$i]->membrobanca_id)->user_id)->name;
            }
        }

//        return $membrosBanca;

        $nomeAluno = array();

        for ($i = 0; $i < count($banca[0]->academicotrabalho); $i++) {
            $nomeAluno[] = \App\Academico::find($banca[0]->academicotrabalho[$i]->academico_id)->user->name;
        }

//        return $nomeAluno;

        return PDF::loadView('banca.cert', [
            'banca' => $banca,
            'coordenadorTcc' => Auth::user()->name,
            'aluno' => $nomeAluno,
            'membro' => $membrosBanca,
        ])->stream();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('create', Banca::class);
        
        $banca =  Banca::where('trabalho_id', $id)
                ->get();

        $academico = AcademicoTrabalho::where('trabalho_id', $id)->get();

        $data = Etapa::where('banca', 1)
                    ->join('etapa_anos as ea', 'ea.etapa_id', '=', 'etapas.id')
                    ->select('data_inicial', 'data_final')
                    ->first();
        
        $membros = MembroBanca::join('users as u', 'u.id', '=', 'membro_bancas.user_id')
                    ->orderBy('u.name')
                    ->pluck('u.name', 'membro_bancas.id');
        
        return view('banca.edit', [
            'banca' => Banca::find($banca[0]->id),
            'data' => $data,
            'membros' => $membros,
            'membro' => $banca,
            'academico' => $academico,
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
        $this->authorize('create', Banca::class);

        $data = Etapa::where('banca', 1)
                    ->join('etapa_anos as ea', 'ea.etapa_id', '=', 'etapas.id')
                    ->select('data_inicial', 'data_final')
                    ->first();

        if($request->input('data') > $data->data_final || $request->input('data') < $data->data_inicial) {
            return back()
                ->with('message', 'A data deve estar no período de Semana de Bancas')
                ->withInput(['data']);
        }

        DB::update('update bancas as b set b.data = ? where b.trabalho_id = ?', [$request->input('data'), $id]);

        return redirect('/banca')
            ->with('message', 'Data adicionada com sucesso');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('create', Banca::class);
    }
}
