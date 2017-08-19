<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AnoLetivoRequest;

use App\AnoLetivo;

class AnoLetivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('anoletivo.index', [
            'anoletivo' => AnoLetivo::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('anoletivo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnoLetivoRequest $request)
    {
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
        return view('anoletivo.edit', [
            'anoletivo' => AnoLetivo::find($id)
        ]);
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
        AnoLetivo::find($id)
            ->delete();

        return redirect('/anoletivo');
    }

    public function getAnoLetivoAtivo(Request $request)
    {
        $anoletivoativo = AnoLetivo::where('ativo', 1)
                            ->select('rotulo', 'id')
                            ->get();

        if ($request->ajax()) {
            return response()->json($anoletivoativo);
        } else {
            return $anoletivoativo;
        }

    }
}
