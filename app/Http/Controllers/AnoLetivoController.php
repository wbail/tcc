<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AnoLetivoRequest;

use App\AnoLetivo;
use Auth;
use App\Departamento;

class AnoLetivoController extends Controller
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

            return view('anoletivo.index', [
                'anoletivo' => AnoLetivo::all()
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

        //$this->authorize('view', AnoLetivo::class);

        $instituicao = 0;

        $departamento_id = Auth::user()
            ->membrobanca()
            ->value('departamento_id');

        if($departamento_id) {

            $instituicao = Departamento::find($departamento_id)
                ->instituicao()
                ->first();

            $this->authorize('view', $instituicao);

            return view('anoletivo.create');

        } else {
            return abort(403, 'Usuário não Autorizado.');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnoLetivoRequest $request)
    {
        if (!Auth::user()->permissao == 9) {
            abort(403, 'Aceso não autorizado.');
        }

        $ativo = $request->input('ativo');

        if ($ativo == null) {
            $ativo = 0;
        } else {
            $ativo = 1;
        }

        AnoLetivo::create([
            'rotulo' => $request->input('rotulo'),
            'data' => $request->input('data'),
            'ativo' => $ativo
        ]);

        return redirect('/anoletivo')->with('message', 'Ano Letivo cadastrado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', AnoLetivo::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

//        $this->authorize('view', Auth::user());

        if (Auth::user()->permissao == 9) {

            return view('anoletivo.edit', [
                'anoletivo' => AnoLetivo::find($id)
            ]);
        } else {
            abort(403, 'Acesso não autorizado');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnoLetivoRequest $request, $id)
    {

        if (!Auth::user()->permissao == 9) {
            abort(403, 'Aceso não autorizado.');
        }

        if ($id == session()->get('anoletivo')->id) {
            return back()
                ->with('message', 'Nao pode atualizar um ano letivo estando logado no mesmo.');
        }

        $ativo = $request->input('ativo');

        if ($ativo == null) {
            $ativo = 0;
        } else {
            $ativo = 1;
        }

        AnoLetivo::find($id)->update([
            'rotulo' => $request->input('rotulo'),
            'data' => $request->input('data'),
            'ativo' => $ativo
        ]);

        session()->forget('anoletivoativo');

        $anoletivoativo = AnoLetivo::where('ativo', 1)
            ->select('id', 'rotulo')
            ->get();

        $request->session()->put([
            'anoletivoativo' => $anoletivoativo
        ]);

        return redirect('/anoletivo')->with('message', 'Ano Letivo atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::user()->permissao == 9) {
            abort(403, 'Aceso não autorizado.');
        }

        AnoLetivo::find($id)
            ->delete();

        return redirect('/anoletivo');
    }

    /**
     * Retorna uma coleçao de AnoLetivo. Se a requisiçao for ajax retorna um Json, se nao retorna um array
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getAnoLetivoAtivo()
    {
        $anoletivoativo = AnoLetivo::where('ativo', 1)
                            ->select('rotulo', 'id')
                            ->get();

        return response()->json($anoletivoativo);

    }
}
