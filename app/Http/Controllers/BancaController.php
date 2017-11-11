<?php

namespace App\Http\Controllers;

use App\AcademicoTrabalho;
use App\AnoLetivo;
use App\CoordenadorCurso;
use Illuminate\Http\Request;
use App\Http\Requests\BancaRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

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

            $anoLetivo = Session::get('anoletivo');

            $banca = Banca::with(['trabalho' => function($q) use ($anoLetivo) {
               $q->where('anoletivo_id', $anoLetivo->id);
            }])
            ->get();

            $count = 0;

            for ($i = 0; $i < count($banca); $i++) {
                if (empty($banca->trabalho)) {
                    $count++;
                }
            }

            if ($count == 0) {
                return view('banca.index', [
                    'countBancaData' => 0
                ]);
            } else {

                $countBancaData = 0;

                for ($i = 0; $i < count($banca); $i++) {
                    if ($banca[$i]->data != null) {
                        $countBancaData++;
                    }
                }

                return view('banca.index', [
                    'banca' => $banca,
                    'countBancaData' => $countBancaData
                ]);
            }

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

        $trabalho = Trabalho::where('anoletivo_id', Session::get('anoletivo')->id)
        ->whereHas('membrobanca', function($q) use ($departamento_id) {
            $q->where('departamento_id', '=', $departamento_id);
        })
        ->orWhereHas('coorientador', function($q) use ($departamento_id) {
            $q->where('departamento_id', '=', $departamento_id);
        })
        ->orderBy('sigla')
        ->select(DB::raw('concat(trabalhos.sigla, \' - \', trabalhos.titulo) as sigla'), 'trabalhos.id', 'trabalhos.anoletivo_id')
        ->where('trabalhos.anoletivo_id', Session::get('anoletivo')->id)
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


        $banca = new Banca;
        $banca->etapaano_id = $etapaano->id;
        $banca->trabalho_id = $trabalho->id;
        $banca->save();

        $academico = AcademicoTrabalho::where('trabalho_id', $trabalho->id)
            ->get();

        for($i = 0; $i < count($academico); $i++) {
            $banca->academico()->attach($academico[$i]->academico_id);
        }

        for ($i = 0; $i < count($valores_membros); $i++) {
            $banca->membrobanca()->attach($valores_membros[$i], ['papel'=>$i+1]);
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

        $banca = DB::select(/** @lang sql */
                    'select t.sigla
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
                      inner join membro_bancas_bancas mb
                         on b.id = mb.banca_id
                      inner join membro_bancas mb2
                         on mb.membro_banca_id = mb2.id
                      inner join users as ux
                         on ux.id = mb2.user_id
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
            ])->stream(\Carbon\Carbon::now()->format('Y-m-d') . '-banca-participantes');
        } else {

            return PDF::loadView('banca.cert', [
                'banca' => $banca,
                'coordenadorTcc' => Auth::user()->name,
                'aluno' => $alunos,
                'prof' => $profs,
                'orientador' => $orientador,
            ])->stream(\Carbon\Carbon::now()->format('Y-m-d') . '-banca-participantes');
        }


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
        
        $banca = Banca::where('trabalho_id', $id)
            ->with('academico')
            ->with('membrobanca')
            ->first();

        $apr = array();

        for ($i = 0; $i < $banca->academico->count(); $i++) {

            $apr[] = AcademicoTrabalho::where('academico_id', $banca->academico[$i]->id)
                ->where('trabalho_id', $banca->trabalho_id)
                ->value('aprovado');
        }

        $data = Etapa::where('banca', 1)
                    ->join('etapa_anos as ea', 'ea.etapa_id', '=', 'etapas.id')
                    ->select('data_inicial', 'data_final')
                    ->first();
        
        $membros = MembroBanca::join('users as u', 'u.id', '=', 'membro_bancas.user_id')
                    ->orderBy('u.name')
                    ->pluck('u.name', 'membro_bancas.id');
        
        return view('banca.edit', [
            'banca' => $banca,
            'data' => $data,
            'membros' => $membros,
            'apr' => $apr
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

        $alunosAprovados = $request->except([
            '_method',
            '_token',
            'data',
            'membro',
            'membro2',
            'suplente',
            'suplente2',
            'local'
        ]);

        if ($alunosAprovados != null) {

            $soNumeros = array_keys($alunosAprovados);

            for ($i = 0; $i < count($soNumeros); $i++) {
                $soNumeros = preg_replace("/[^0-9,.]/", "", $soNumeros[$i]);
                $at = AcademicoTrabalho::where('academico_id', $soNumeros)->first();
                $at->aprovado = 1;
                $at->save();
            }

            return redirect('/banca')->with('message', 'Aluno(as) aprovado(as) com sucesso.');

        }

        $trabalho = Trabalho::find($id);

        $messages = [
            'data.required' => 'O campo Data é obrigatório.',
            'local.required' => 'O campo Local é obrigatório.',
            'membro.required' => 'O campo Membro de Banca é obrigatório.',
            'membro2.required' => 'O campo Membro de Banca é obrigatório.',
            'suplente.required' => 'O campo Membro Suplente é obrigatório.',
            'suplente2.required' => 'O campo Membro Suplente é obrigatório.',
            'membro.different' => 'Os membros de banca devem ser distintos.',
            'membro2.different' => 'Os membros de banca devem ser distintos.',
            'suplente.different' => 'Os membros de banca devem ser distintos.',
            'suplente2.different' => 'Os membros de banca devem ser distintos.',
        ];

        $validator = Validator::make($request->all(), [
            'data' => 'required',
            'local' => 'required',
            'membro' => 'required',
            'membro2' => 'required',
            'suplente' => 'required',
            'suplente2' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

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

        if ($trabalho->orientador_id != null) {

            if(in_array($trabalho->orientador_id, $valores_membros)) {
                return back()
                    ->with('message', 'O Orientador já faz parte da banca.')
                    ->withInput();
            } else if(!in_array($trabalho->coorientador_id, $valores_membros)) {
                //
            } else {
                return back()
                    ->with('message', 'O Coorientador não participa da banca.')
                    ->withInput();
            }
        }

        $data = Etapa::where('banca', 1)
                    ->join('etapa_anos as ea', 'ea.etapa_id', '=', 'etapas.id')
                    ->select('data_inicial', 'data_final')
                    ->first();

        if($request->input('data') > $data->data_final || $request->input('data') < $data->data_inicial) {
            return back()
                ->with('message', 'A data deve estar no período de Semana de Bancas')
                ->withInput(['data']);
        }

        Banca::where('trabalho_id', $id)
            ->update([
                'data' => $request->input('data'),
                'local' => $request->input('local'),
            ]);


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

    /**
     * Muda a banca para o status 1, indicando que a banca aconteceu.
     * Sendo $id do trabalho.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finaliza($id)
    {
        $this->authorize('create', Banca::class);

        Banca::where('trabalho_id', $id)->update([
            'status' => 1
        ]);

        $academicoTrabalho = AcademicoTrabalho::where('trabalho_id', $id)
            ->get();

        for ($i = 0; $i < count($academicoTrabalho); $i++) {
            if ($academicoTrabalho[$i]->aprovado != 1) {

                DB::insert('insert into academico_trabalhos (aprovado, academico_id, created_at, updated_at) values(?, ?, ?, ?)', [
                    0,
                    $academicoTrabalho[$i]->academico_id,
                    Carbon::now(),
                    Carbon::now()
                ]);
            }
        }

        return redirect('/banca')
            ->with('message', 'Banca realizada');
    }

    /**
     * Lista de todas bancas para impressão, em PDF
     *
     * @return mixed
     */
    public function imprime() {

        $this->authorize('create', Banca::class);

        set_time_limit(0);

        $data = Etapa::where('banca', 1)
            ->join('etapa_anos as ea', 'ea.etapa_id', '=', 'etapas.id')
            ->select('data_inicial', 'data_final')
            ->first();

        $etapaano = EtapaAno::join('etapas as e', 'e.id', '=', 'etapa_anos.etapa_id')
            ->where('e.banca', 1)
            ->select('etapa_anos.id')
            ->first();

        $banca = Banca::where('etapaano_id', $etapaano->id)
            ->with('academico', 'membrobanca')
            ->get();

        return PDF::loadView('banca.imprime', [
            'coordenadorTcc' => Auth::user()->name,
            'cursoupper' => strtoupper(session()->get('curso')->nome),
            'data' => $data,
            'banca' => $banca,
        ])->stream(\Carbon\Carbon::now()->format('Y-m-d') . '-horario-bancas-' . session()->get('curso')->nome);

    }

}
