<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MembroBancaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required|regex:/^[\pL\s\-]+$/u|max:80',
            'departamento' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->id)
            ],
            'telefone0' => 'required|unique:telefones,numero',
            'banca' => 'required_without_all:orientador,coorientador',
            // 'orientador' => 'required_without_all:banca,coorientador',
            // 'coorientador' => 'required_without_all:banca,orientador',
        ];
    }

    /**
     * Mensagens de erro traduzidas
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'nome.required' => 'O campo Nome é obrigatório.',
            'nome.regex' => 'O campo Nome é permitido somente letras.',
            'nome.max' => 'O campo Nome permite até 80 caracteres.',
            'departamento.required' => 'O campo Departamento é obrigatório.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'O campo E-mail deve ter o formato \'exemplo@exemplo.com \'.',
            'telefone0.required' => 'O campo Telefone é obrigatório.',
            'banca.required_without_all' => 'O campo Permissão é obrigatório.',
            'orientador.required_without_all' => 'O campo Permissão é obrigatório.',
            'coorientador.required_without_all' => 'O campo Permissão é obrigatório.',
        ];
    }
}
