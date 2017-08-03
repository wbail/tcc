<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
     * Redireciona para mudar a senha no primeiro acesso
     * @return Response
     */
    public function redirectTo() {

        if (Auth::user()->mudou_senha == 0) {
            return '/primeiroacesso';
        } else {
            
            if(Auth::user()->permissao >= 1 && Auth::user()->permissao <= 8) {
                return '/etapaano';
            } elseif(Auth::user()->permissao == 9) {
                return '/admin';
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

}
