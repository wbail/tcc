<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Academico;
use App\Trabalho;
use DB;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Arquivo' => 'App\Policies\ArquivoPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('aluno-view', function(Academico $academico, Trabalho $trabalho) {
            $academicoTrabalho = DB::table('academico_trabalhos as atr')
                                        ->where('atr.academico_id', '=', $academico->id)
                                        ->where('atr.trabalho_id', '=', $trabalho->id)
                                        ->first();
            if($academicoTrabalho) {
                return true;
            } else {
                return false;
            }
        });
    
    }
}
