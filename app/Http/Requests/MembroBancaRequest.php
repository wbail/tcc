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

        $x = \App\Telefone::where('user_id', $this->id)->value('id');
        if ($x) {
            return [
                'nome' => 'required|regex:/^[\pL\s\-]+$/u|min:3,max:80',
                'departamento' => 'required',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($this->id),
                ],
                'telefone' => [
                    'required',
                    'digits:11',
                    Rule::unique('telefones', 'numero')->ignore($x),
                ],
                'telefone1' => [
                    'digits:11',
                    Rule::unique('telefones', 'numero')->ignore($x),
                ],
                'telefone2' => [
                    'digits:11',
                    Rule::unique('telefones', 'numero')->ignore($x),
                ],
                'banca' => 'required_without_all:orientador,coorientador',
                // 'orientador' => 'required_without_all:banca,coorientador',
                // 'coorientador' => 'required_without_all:banca,orientador',
            ];

        } else {
            return [
                'nome' => 'required|regex:/^[\pL\s\-]+$/u|min:3,max:80',
                'departamento' => 'required',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($this->id)
                ],
                'telefone' => [
                    'required',
                    'unique:telefones,numero',
                    'digits:11',
                    Rule::unique('telefones', 'numero'),
                ],
                'telefone1' => [
                    'unique:telefones,numero',
                    'digits:11',
                    Rule::unique('telefones', 'numero'),
                ],
                'telefone2' => [
                    'unique:telefones,numero',
                    'digits:11',
                    Rule::unique('telefones', 'numero'),
                ],
                'banca' => 'required_without_all:orientador,coorientador',
                // 'orientador' => 'required_without_all:banca,coorientador',
                // 'coorientador' => 'required_without_all:banca,orientador',
            ];
        }
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
    }
}
