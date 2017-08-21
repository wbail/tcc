<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';


    /**
     * Redireciona para mudar a senha no primeiro acesso.
     *
     * @return Response
     */
    public function redirectTo() {

        if (Auth::user()->mudou_senha == 0) {
            return '/primeiroacesso';
        } else {
            
            if(Auth::user()->permissao >= 1 && Auth::user()->permissao <= 8) {
                return '/etapaano';
            } elseif(Auth::user()->permissao == 9) {
                return 'admin';
            }
        }
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('guest', ['except' => 'logout']);
               
    }

    /**
     * Recebe uma string de email para procurar e retornar o(s) departamento(s) que o usuario pertence.
     *
     * @param $email
     * @return mixed
     */
    public function getCursos($email) {

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

    }




}
