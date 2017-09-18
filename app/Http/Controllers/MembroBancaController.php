<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MembroBancaRequest;
use Response;
use Validator;
use Illuminate\Validation\Rule;
use App\Telefone;
use App\Trabalho;
use App\MembroBanca;
use App\User;
use App\Banca;
use App\Departamento;
use DB;
use Auth;
use View;

class MembroBancaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('create', MembroBanca::class);

        if($request->ajax()) {

            $term = $request->term;
            $orientador = DB::table('membro_bancas as a')
                    ->join('users as u', 'u.id', '=', 'a.user_id')
                    ->select('u.name as text', 'a.id as id')
                    ->where('a.departamento_id', '=', User::userMembroDepartamento()->departamento_id)
                    ->where('u.name', 'LIKE', '%'. $term . '%')
                    ->orderBy('u.name')
                    ->pluck('id', 'text');
        
            return Response::json(['itens' => $orientador]);
                        
        }

        return view('membrobanca.index', [
            'membrobanca' => MembroBanca::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', MembroBanca::class);

        $permissao = array(
            '1' => 'Orientador',
            '2' => 'Coorientador',
            '3' => 'Banca',
        );

        $departamento = DB::table('departamentos as d')
                            ->join('instituicaos as i', 'i.id', '=', 'd.instituicao_id')
                            ->where('i.sigla', '=', 'UEPG')
                            ->orderBy('d.nome')
                            ->pluck('d.nome', 'd.id');

        return View('membrobanca.create', [
            'departamento' => $departamento,
            'permissao' => $permissao
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MembroBancaRequest $request)
    {

        $this->authorize('create', MembroBanca::class);

        $telefone = $request->except('_token', 'nome', 'email', 'banca', 'coorientador', 'orientador', 'departamento', 'ativo');
        
        for ($i = 0; $i < count($telefone); $i++) { 
            
            $justNumber = str_replace(['(', ')', '-', ' '], '', array_values($telefone));
            
            if(DB::table('telefones')->where('numero', '=', $justNumber[$i])->exists()) {

                return back()->with('message', 'O número ' . $justNumber[$i] . ' já foi cadastrado.')
                    ->withInput(['telefone', 'ativo']);

            }            
        }

        User::create([
            'name' => $request->input('nome'),
            'email' => $request->input('email'),
            'password' => bcrypt('deinfouepg'),
            'permissao' => array_sum(array_values($request->only('banca', 'coordenador', 'orientador'))),
            'mudou_senha' => 0
        ]);

        $lastUser = DB::table('users')
                        ->latest()
                        ->first();

        $membrobanca = new MembroBanca;
        $membrobanca->departamento()->associate($request->input('departamento'));
        $membrobanca->user()->associate($lastUser->id);
        $membrobanca->save();

        for ($i = 0; $i < count($telefone); $i++) {

            $t = new Telefone;
            $t->numero = $justNumber[$i];
            $t->user()->associate($lastUser->id);
            $t->save();
            
        }

        return redirect('/membrobanca')->with('message', 'Membro de Banca cadastrado com sucesso!');
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
        $this->authorize('create', MembroBanca::class);

        return view('membrobanca.edit', [
            'membrobanca' => MembroBanca::find($id),
            'departamento' => Departamento::all()->pluck('nome', 'id')
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
        if (!Auth::user()->permissao == 9) {
            abort(403, 'Acesso não autorizado.');
        }
        $messages = [
            'nome.required' => 'O campo Nome é obrigatório.',
            'nome.regex' => 'O campo Nome é permitido somente letras.',
            'nome.max' => 'O campo Nome permite até 80 caracteres.',
            'nome.min' => 'O campo Nome exige no mínimo 3 caracteres.',
            'departamento.required' => 'O campo Departamento é obrigatório.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'O campo E-mail deve ter o formato \'exemplo@exemplo.com \'.',
            'telefone0.required' => 'O campo Telefone é obrigatório.',
            'telefone0.digits' => 'O campo Telefone deve ter 11 dígitos.',
            'telefone0.unique' => 'Telefone já cadastrado.',
            'telefone1.digits' => 'O campo Telefone deve ter 11 dígitos.',
            'telefone1.unique' => 'Telefone já cadastrado.',
            'telefone2.digits' => 'O campo Telefone deve ter 11 dígitos.',
            'telefone2.unique' => 'Telefone já cadastrado.',
            'banca.required_without_all' => 'O campo Permissão é obrigatório.',
            'orientador.required_without_all' => 'O campo Permissão é obrigatório.',
            'coorientador.required_without_all' => 'O campo Permissão é obrigatório.',
        ];
        $x = \App\Telefone::where('user_id', $id)->value('id');
        $validator = Validator::make($request->all(), [
            'nome' => 'required|regex:/^[\pL\s\-]+$/u|min:3,max:80',
            'departamento' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
            ],
            'telefone' => [
                'required',
                'digits:11',
                Rule::unique('telefones', 'numero')->ignore($x),
            ],
//            'telefone1' => [
//                'digits:11',
//                Rule::unique('telefones', 'numero')->ignore($x),
//            ],
//            'telefone2' => [
//                'digits:11',
//                Rule::unique('telefones', 'numero')->ignore($x),
//            ],
            'banca' => 'required_without_all:orientador,coorientador',
        ], $messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }


        // Atualiza os campos relacionado a user
        $user = User::find($id);
        $user->update([
            'name' => $request->input('nome'),
            'email' => $request->input('email'),
            'ativo' => $request->input('ativo'),
        ]);

        // Altera o departamento
        MembroBanca::where('user_id', $user->id)
            ->first()
            ->departamento()
            ->associate($request->input('departamento'))
            ->save();

        // Salva apenas os números de telefone, todos
        $telefone = $request->except('_token', '_method', 'nome', 'email', 'departamento', 'permissao', 'orientador', 'coorientador', 'banca', 'ativo');


        for ($i = 0; $i < count($telefone); $i++) {

            $justNumber = str_replace(['(', ')', '-', ' '], '', array_values($telefone));
            $telefoneDono = Telefone::where('user_id', $id)->get();

            if(DB::table('telefones')->where('numero', '=', $justNumber[$i])->exists() && $telefoneDono[$i]->user_id != $id) {

                return back()->with('message-tel-rep', 'Telefone já cadastrado.')
                    ->withInput(['telefone', 'ativo']);

            } else if(DB::table('telefones')->where('numero', '=', $justNumber[$i])->exists() && $telefoneDono[$i]->user_id == $id){
                //
            } else {
                $contato = new Telefone;
                $contato->numero = $justNumber[$i];
                $contato->user_id = $id;
                $contato->save();
            }
        }


        return redirect('/membrobanca')->with('message', 'Professor(a) atualizado com sucesso.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->permissao == 9) {
            abort(403, 'Acesso não autorizado.');
        }

        $trabalho = Trabalho::where('orientador_id', $id)
            ->orWhere('coorientador_id', $id)
            ->get();

        $banca = Banca::where('membrobanca_id', $id)
            ->get();

        if (count($trabalho) > 0 || count($banca) > 0) {
            return back()->with('message-del', 'Não é possível excluir o(a) professor(a).');
        } else {
            User::find(MembroBanca::find($id)->user_id)
                ->update(['ativo' => 0]);

            return back()->with('message', 'Professor(a) excluído(a) com sucesso.');
        }

    }
}
