<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        'App\Instituicao' => 'App\Policies\InstituicaoPolicy',
        'App\Trabalho' => 'App\Policies\TrabalhoPolicy',
        'App\Curso' => 'App\Policies\CursoPolicy',
        'App\Departamento' => 'App\Policies\DepartamentoPolicy',
        'App\Etapa' => 'App\Policies\EtapaPolicy',
        'App\Academico' => 'App\Policies\AcademicoPolicy',
        'App\MembroBanca' => 'App\Policies\MembroBancaPolicy',
        'App\EtapaAno' => 'App\Policies\EtapaAnoPolicy',
        'App\Banca' => 'App\Policies\BancaPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
