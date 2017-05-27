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

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/admin', function() {
	return view('admin');
});


Route::get('primeiroacesso', function() {
	return view('primeiroacesso');
})->middleware('auth');

Route::post('/primeiroacesso/update', function(\Illuminate\Http\Request $request) {

	\App\User::find(Auth::user()->id)->update([
		'password' => bcrypt($request->input('password')),
		'mudou_senha' => 1
	]);

	return redirect('/admin'); 

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
	Route::get('show/{id}', ['as'=>'etapaano.show', 'uses'=>'EtapaanoController@show', 'middleware' => 'auth']);
	
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


Route::get('/contato/destroy/{id}', function($id) {
	\App\Contato::find($id)->delete();
	return back();
});

