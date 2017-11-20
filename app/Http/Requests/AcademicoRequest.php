<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AcademicoRequest extends FormRequest {

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

        $x = \App\Academico::find($this->id);
        if ($x){

            return [
                'nome' => 'required|regex:/^[\pL\s\-]+$/u|min:3,max:80',
                'curso' => 'required',
                'telefone' => [
                    'required',
                    'digits:11',
                ],
                'telefone1' => [
                    'digits:11',
                ],
                'telefone2' => [
                    'digits:11',
                ],
                'ra' => [
                    'required',
                    'numeric',
                    'digits:8',
                    Rule::unique('academicos', 'ra')->ignore($this->id),
                ],
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore(\App\Academico::find($this->id)->user_id),
                ],
            ];
        } else {
            return [
                'nome' => 'required|regex:/^[\pL\s\-]+$/u|min:3,max:80',
                'curso' => 'required',
                'telefone' => [
                    'required',
                    'digits:11',
                    Rule::unique('telefones', 'numero'),
                ],
                'telefone1' => [
                    'digits:11',
                    Rule::unique('telefones', 'numero'),
                ],
                'telefone2' => [
                    'digits:11',
                    Rule::unique('telefones', 'numero'),
                ],
                'ra' => [
                    'required',
                    'numeric',
                    'digits:8',
                    Rule::unique('academicos', 'ra')->ignore($this->id),
                ],
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')
                ],
            ];
        }

    }


    /**
     * Retorna as mensagens de erro traduzidas
     * 
     * @return array
     */
    public function messages() {
        return [
            'nome.required' => 'O campo Nome é obrigatório.',
            'nome.min' => 'O campo Nome deve ter no mínimo 3 caracteres.',
            'nome.max' => 'O campo Nome deve ter no máximo 80 caracteres.',
            'nome.alpha' => 'O campo Nome é somente permitido letras.',
            'nome.regex' => 'O campo Nome deve conter apenas letras.',
            'ra.required' => 'O campo RA é obrigatório.',
            'ra.numeric' => 'O campo RA é numérico.',
            'ra.unique' => 'RA já cadastrado.',
            'ra.digits' => 'O RA ter ter oito dígitos.',
            'curso.required' => 'O campo Curso é obrigatório.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'O campo E-mail deve ter o formato \'exemplo@exemplo.com\'.',
            'email.unique' => 'E-mail já cadastrado.',
            'telefone.required' => 'O campo Telefone é obrigatório.',
            'telefone.unique' => 'Telefone já cadastrado.',
            'telefone.digits' => 'O campo telefone deve ter 11 dígitos',
            'telefone1.unique' => 'Telefone já cadastrado.',
            'telefone2.unique' => 'Telefone já cadastrado.',
            'telefone1.digits' => 'O campo telefone deve ter 11 dígitos',
            'telefone2.digits' => 'O campo telefone deve ter 11 dígitos',

        ];
    }

}
