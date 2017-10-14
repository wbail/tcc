<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/unauthorized', function() {
	return view('unauthorized');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/admin', function() {
	return view('admin');
})->middleware('auth');

Route::get('primeiroacesso', function() {
	return view('primeiroacesso');
})->middleware('auth');

Route::post('/primeiroacesso/update', function(\Illuminate\Http\Request $request) {

	\App\User::find(Auth::user()->id)->update([
		'password' => bcrypt($request->input('password')),
		'mudou_senha' => 1
	]);

	if(Auth::user()->permissao >= 1 && Auth::user()->permissao <= 8) {
		return redirect('/etapaano');
	} elseif(Auth::user()->permissao == 9) {
		return redirect('/admin');
	} else {
		return redirect('/trabalho');
	}

})->middleware('auth');

//Com autentição
Route::group(['prefix'=>'academico','where'=>['id'=>'[0-9]+']], function() {

	Route::get('', ['as'=>'academico', 'uses'=>'AcademicoController@index', 'middleware' => 'auth']);
	Route::get('novo', ['as'=>'academico.create', 'uses'=>'AcademicoController@create', 'middleware' => 'auth']);
	Route::post('store', ['as'=>'academico.store', 'uses'=>'AcademicoController@store', 'middleware' => 'auth']);
	Route::get('edit/{id}', ['as'=>'academico.edit', 'uses'=>'AcademicoController@edit', 'middleware' => 'auth']);
	Route::put('update/{id}', ['as'=>'academico.update', 'uses'=>'AcademicoController@update', 'middleware' => 'auth']);
	Route::get('destroy/{id}', ['as'=>'academico.destroy', 'uses'=>'AcademicoController@destroy', 'middleware' => 'auth']);
	Route::get('show/{id}', ['as'=>'academico.show', 'uses'=>'AcademicoController@show', 'middleware' => 'auth']);

});

Route::group(['prefix'=>'membrobanca','where'=>['id'=>'[0-9]+']], function() {

	Route::get('', ['as'=>'membrobanca', 'uses'=>'MembroBancaController@index', 'middleware' => 'auth']);
	Route::get('novo', ['as'=>'membrobanca.create', 'uses'=>'MembroBancaController@create', 'middleware' => 'auth']);
	Route::post('store', ['as'=>'membrobanca.store', 'uses'=>'MembroBancaController@store', 'middleware' => 'auth']);
	Route::get('edit/{id}', ['as'=>'membrobanca.edit', 'uses'=>'MembroBancaController@edit', 'middleware' => 'auth']);
	Route::put('update/{id}', ['as'=>'membrobanca.update', 'uses'=>'MembroBancaController@update', 'middleware' => 'auth']);
	Route::get('destroy/{id}', ['as'=>'membrobanca.destroy', 'uses'=>'MembroBancaController@destroy', 'middleware' => 'auth']);
	Route::get('show/{id}', ['as'=>'membrobanca.show', 'uses'=>'MembroBancaController@show', 'middleware' => 'auth']);

});

Route::group(['prefix'=>'departamento','where'=>['id'=>'[0-9]+']], function() {

	Route::get('', ['as'=>'departamento', 'uses'=>'DepartamentoController@index', 'middleware' => 'auth']);
	Route::get('novo', ['as'=>'departamento.create', 'uses'=>'DepartamentoController@create', 'middleware' => 'auth']);
	Route::post('store', ['as'=>'departamento.store', 'uses'=>'DepartamentoController@store', 'middleware' => 'auth']);
	Route::get('edit/{id}', ['as'=>'departamento.edit', 'uses'=>'DepartamentoController@edit', 'middleware' => 'auth']);
	Route::put('update/{id}', ['as'=>'departamento.update', 'uses'=>'DepartamentoController@update', 'middleware' => 'auth']);
	Route::get('destroy/{id}', ['as'=>'departamento.destroy', 'uses'=>'DepartamentoController@destroy', 'middleware' => 'auth']);
	Route::get('show/{id}', ['as'=>'departamento.show', 'uses'=>'DepartamentoController@show', 'middleware' => 'auth']);

});

Route::group(['prefix'=>'trabalho','where'=>['id'=>'[0-9]+']], function() {

	Route::get('', ['as'=>'trabalho', 'uses'=>'TrabalhoController@index', 'middleware' => 'auth']);
	Route::get('novo', ['as'=>'trabalho.create', 'uses'=>'TrabalhoController@create', 'middleware' => 'auth']);
	Route::post('store', ['as'=>'trabalho.store', 'uses'=>'TrabalhoController@store', 'middleware' => 'auth']);
	Route::get('edit/{id}', ['as'=>'trabalho.edit', 'uses'=>'TrabalhoController@edit', 'middleware' => 'auth']);
	Route::put('update/{id}', ['as'=>'trabalho.update', 'uses'=>'TrabalhoController@update', 'middleware' => 'auth']);
	Route::get('destroy/{id}', ['as'=>'trabalho.destroy', 'uses'=>'TrabalhoController@destroy', 'middleware' => 'auth']);
	Route::get('show/{id}', ['as'=>'trabalho.show', 'uses'=>'TrabalhoController@show', 'middleware' => 'auth']);

});

Route::group(['prefix'=>'etapa','where'=>['id'=>'[0-9]+']], function() {

	Route::get('', ['as'=>'etapa', 'uses'=>'EtapaController@index', 'middleware' => 'auth']);
	Route::get('novo', ['as'=>'etapa.create', 'uses'=>'EtapaController@create', 'middleware' => 'auth']);
	Route::post('store', ['as'=>'etapa.store', 'uses'=>'EtapaController@store', 'middleware' => 'auth']);
	Route::get('edit/{id}', ['as'=>'etapa.edit', 'uses'=>'EtapaController@edit', 'middleware' => 'auth']);
	Route::put('update/{id}', ['as'=>'etapa.update', 'uses'=>'EtapaController@update', 'middleware' => 'auth']);
	Route::get('destroy/{id}', ['as'=>'etapa.destroy', 'uses'=>'EtapaController@destroy', 'middleware' => 'auth']);
	Route::get('show/{id}', ['as'=>'etapa.show', 'uses'=>'EtapaController@show', 'middleware' => 'auth']);

});

Route::group(['prefix'=>'etapaano','where'=>['id'=>'[0-9]+']], function() {

	Route::get('', ['as'=>'etapaano', 'uses'=>'EtapaanoController@index', 'middleware' => 'auth']);	
	Route::get('novo', ['as'=>'etapaano.create', 'uses'=>'EtapaanoController@create', 'middleware' => 'auth']);
	Route::post('store', ['as'=>'etapaano.store', 'uses'=>'EtapaanoController@store', 'middleware' => 'auth']);
	Route::get('edit/{id}', ['as'=>'etapaano.edit', 'uses'=>'EtapaanoController@edit', 'middleware' => 'auth']);
	Route::put('update/{id}', ['as'=>'etapaano.update', 'uses'=>'EtapaanoController@update', 'middleware' => 'auth']);
	Route::get('destroy/{id}', ['as'=>'etapaano.destroy', 'uses'=>'EtapaanoController@destroy', 'middleware' => 'auth']);
	Route::get('show/{id}/{trabalhoid}', ['as'=>'etapaano.show', 'uses'=>'EtapaanoController@show']);
    Route::get('email', ['as' => 'etapaano.email']);
});

Route::group(['prefix'=>'instituicao','where'=>['id'=>'[0-9]+']], function() {

	Route::get('', ['as'=>'instituicao', 'uses'=>'InstituicaoController@index', 'middleware' => 'auth']);
	Route::get('novo', ['as'=>'instituicao.create', 'uses'=>'InstituicaoController@create', 'middleware' => 'auth']);
	Route::post('store', ['as'=>'instituicao.store', 'uses'=>'InstituicaoController@store', 'middleware' => 'auth']);
	Route::get('edit/{id}', ['as'=>'instituicao.edit', 'uses'=>'InstituicaoController@edit', 'middleware' => 'auth']);
	Route::put('update/{id}', ['as'=>'instituicao.update', 'uses'=>'InstituicaoController@update', 'middleware' => 'auth']);
	Route::get('destroy/{id}', ['as'=>'instituicao.destroy', 'uses'=>'InstituicaoController@destroy', 'middleware' => 'auth']);
	Route::get('show/{id}', ['as'=>'instituicao.show', 'uses'=>'InstituicaoController@show', 'middleware' => 'auth']);

});

Route::group(['prefix'=>'curso','where'=>['id'=>'[0-9]+']], function() {

	Route::get('', ['as'=>'curso', 'uses'=>'CursoController@index', 'middleware' => 'auth']);
	Route::get('novo', ['as'=>'curso.create', 'uses'=>'CursoController@create', 'middleware' => 'auth']);
	Route::post('store', ['as'=>'curso.store', 'uses'=>'CursoController@store', 'middleware' => 'auth']);
	Route::get('edit/{id}', ['as'=>'curso.edit', 'uses'=>'CursoController@edit', 'middleware' => 'auth']);
	Route::put('update/{id}', ['as'=>'curso.update', 'uses'=>'CursoController@update', 'middleware' => 'auth']);
	Route::get('destroy/{id}', ['as'=>'curso.destroy', 'uses'=>'CursoController@destroy', 'middleware' => 'auth']);
	Route::get('show/{id}', ['as'=>'curso.show', 'uses'=>'CursoController@show', 'middleware' => 'auth']);

});

Route::group(['prefix'=>'arquivo','where'=>['id'=>'[0-9]+']], function() {

	Route::get('', ['as'=>'arquivo', 'uses'=>'ArquivoController@index', 'middleware' => 'auth']);
	Route::get('novo', ['as'=>'arquivo.create', 'uses'=>'ArquivoController@create', 'middleware' => 'auth']);
	Route::post('store/{etapaanoid}/{trabalhoid}', ['as'=>'arquivo.store', 'uses'=>'ArquivoController@store', 'middleware' => 'auth']);
	Route::get('edit/{id}', ['as'=>'arquivo.edit', 'uses'=>'ArquivoController@edit', 'middleware' => 'auth']);
	Route::put('update/{id}', ['as'=>'arquivo.update', 'uses'=>'ArquivoController@update', 'middleware' => 'auth']);
	Route::get('destroy/{id}', ['as'=>'arquivo.destroy', 'uses'=>'ArquivoController@destroy', 'middleware' => 'auth']);
	Route::get('show/{id}/{etapaanoid}/{trabalhoid}', ['as'=>'arquivo.show', 'uses'=>'ArquivoController@show', 'middleware' => 'auth']);

});

Route::group(['prefix'=>'banca','where'=>['id'=>'[0-9]+']], function() {

	Route::get('', ['as'=>'banca', 'uses'=>'BancaController@index', 'middleware' => 'auth']);
	Route::get('novo', ['as'=>'banca.create', 'uses'=>'BancaController@create', 'middleware' => 'auth']);
	Route::post('store', ['as'=>'banca.store', 'uses'=>'BancaController@store', 'middleware' => 'auth']);
	Route::get('edit/{id}', ['as'=>'banca.edit', 'uses'=>'BancaController@edit', 'middleware' => 'auth']);
	Route::put('update/{id}', ['as'=>'banca.update', 'uses'=>'BancaController@update', 'middleware' => 'auth']);
	Route::get('destroy/{id}', ['as'=>'banca.destroy', 'uses'=>'BancaController@destroy', 'middleware' => 'auth']);
	Route::get('show/{id}', ['as'=>'banca.show', 'uses'=>'BancaController@show', 'middleware' => 'auth']);
	Route::get('finaliza/{id}', ['as'=>'banca.finaliza', 'uses'=>'BancaController@finaliza', 'middleware' => 'auth']);

});

Route::group(['prefix'=>'anoletivo','where'=>['id'=>'[0-9]+']], function() {

    Route::get('', ['as'=>'anoletivo', 'uses'=>'AnoLetivoController@index', 'middleware' => 'auth']);
    Route::get('novo', ['as'=>'anoletivo.create', 'uses'=>'AnoLetivoController@create', 'middleware' => 'auth']);
    Route::post('store', ['as'=>'anoletivo.store', 'uses'=>'AnoLetivoController@store', 'middleware' => 'auth']);
    Route::get('edit/{id}', ['as'=>'anoletivo.edit', 'uses'=>'AnoLetivoController@edit', 'middleware' => 'auth']);
    Route::put('update/{id}', ['as'=>'anoletivo.update', 'uses'=>'AnoLetivoController@update', 'middleware' => 'auth']);
    Route::get('destroy/{id}', ['as'=>'anoletivo.destroy', 'uses'=>'AnoLetivoController@destroy', 'middleware' => 'auth']);
    Route::get('show/{id}', ['as'=>'anoletivo.show', 'uses'=>'AnoLetivoController@show', 'middleware' => 'auth']);
    Route::get('anoletivoativo', ['as'=>'anoletivo.getAnoLetivoAtivo', 'uses'=>'AnoLetivoController@getAnoLetivoAtivo']);
});

Route::get('/telefone/destroy/{id}', function($id) {
	\App\Telefone::find($id)->delete();
	return back()->with('message-tel', 'Telefone excluído com sucesso.');
})->middleware('auth');

Route::get('/h/{email}', function($email) {

	$user = DB::table('users as u')
                    ->where('u.email', $email)
                    ->first();

	$isProf = DB::table('membro_bancas as mb')
				->where('mb.user_id', $user->id)
				->first();

	$isAluno = DB::table('academicos as a')
				->where('a.user_id', $user->id)
				->first();

	if($isProf) {
		return \App\Curso::where('departamento_id', $isProf->departamento_id)
			->select('id', 'nome')
			->get();
	} else if($isAluno) {
		return \App\Curso::where('id', $isAluno->curso_id)
			->select('id', 'nome')
			->get();
	}

});