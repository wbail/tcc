<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EtapaRequest;

use App\Etapa;

class EtapaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('create', Etapa::class);

        return view('etapa.index', [
            'etapa' => Etapa::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Etapa::class);
        return view('etapa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EtapaRequest $request)
    {
        $this->authorize('create', Etapa::class);
        Etapa::create($request->all());

        return redirect('/etapa')->with('message', 'Etapa cadastrada com sucesso!');
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
        $this->authorize('create', Etapa::class);
        return view('etapa.edit', [
            'etapa' => Etapa::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EtapaRequest $request, $id)
    {
        $this->authorize('create', Etapa::class);
        
        $banca = $request->input('banca');
        
        if($banca == null) {
            $banca = 0;
        }

        Etapa::find($id)->update([
            'desc' => $request->input('desc'),
            'banca' => $banca
        ]);

        return redirect('/etapa')->with('message', 'Etapa atualizada com sucesso!');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('create', Etapa::class);
        Etapa::find($id)->delete();
        return redirect('/etapa');
    }
}
