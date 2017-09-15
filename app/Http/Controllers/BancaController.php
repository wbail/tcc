<?php

namespace App\Http\Controllers;

use App\AcademicoTrabalho;
use App\AnoLetivo;
use Illuminate\Http\Request;
use App\Http\Requests\BancaRequest;

// use App\Policies\BancaPolicy;

use Auth;
use DB;
use App\Banca;
use App\Etapa;
use App\EtapaAno;
use App\User;
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
        $this->authorize('create', Banca::class);

        $d = User::userMembroDepartamento()->departamento_id;

        $banca = DB::table('bancas as b')
            ->join('trabalhos as t', 't.id', '=', 'b.trabalho_id')
            ->join('membro_bancas as mb', 'mb.id', '=', 't.orientador_id')
            ->where('mb.departamento_id', $d)
            ->get();

        $banca = collect($banca)
            ->unique('trabalho_id')
            ->values()
            ->all();

        return view('banca.index', [
            'banca' => $banca
        ]);
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
        })
        ->orWhereHas('coorientador', function($q) use ($departamento_id) {
            $q->where('departamento_id', '=', $departamento_id);
        })
        ->whereHas('anoletivo', function ($query) {
            $query->where('ativo', 1);
        })
        ->orderBy('sigla')
        ->pluck('sigla', 'id');

        $membros = '';

        if (Banca::count() > 0) {

            $membros = Banca::rightJoin('membro_bancas as mb', 'mb.id', '=', 'bancas.membrobanca_id')
                ->rightJoin('users as u', 'u.id', '=', 'mb.user_id')
                ->rightJoin('trabalhos as t', 't.id', '=', 'bancas.trabalho_id')
                ->rightJoin('ano_letivos as al', 'al.id', '=', 't.anoletivo_id')
                ->where('al.ativo', 1)
                ->groupBy('mb.id', 'u.name')
                ->orderBy('u.name')
                ->select('mb.id', DB::raw('concat(u.name, \' - \', count(u.name), \' banca(s)\') as nome'))
                ->pluck('nome', 'mb.id');
        } else {
            $membros = MembroBanca::join('users as u', 'u.id', '=', 'membro_bancas.user_id')
                ->orderBy('u.name')
                ->pluck('u.name', 'membro_bancas.id');
        }

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
                ->withInput();
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
