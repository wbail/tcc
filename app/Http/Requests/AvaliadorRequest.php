<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AvaliadorRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {

        return [
            'nome' => 'required',
            'departamento' => 'required',
            'permissao' => 'required',
            'telefone' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->id),
            ]
        ];
    }


    /**
     * Retorna as mensagens de erro
     * 
     * @return array
     */
    public function messages() {
        return [
            'nome.required' => 'O campo Nome é obrigatório.',
            'departamento.required' => 'O campo Departamento é obrigatório.',
            'permissao.required' => 'O campo Permissão é obrigatório.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.unique' => 'O E-mail já está em uso.',
            'email.email' => 'O campo E-mail deve ter o formato \'exemplo@exemplo.com\'.',
            'telefone.required' => 'O campo Telefone é obrigatório.',
        ];
    }

}
