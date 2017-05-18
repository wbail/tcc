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

        return [
            'nome' => 'required',
            'curso' => 'required',
            'telefone0' => 'required|unique:telefones,numero',
            'ra' => [
                'required',
                'numeric',
                'digits:8',
                Rule::unique('academicos')->ignore($this->id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->id),
            ],
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
            'nome.alpha' => 'O campo Nome é somente permitido letras.',
            'ra.required' => 'O campo RA é obrigatório.',
            'ra.numeric' => 'O campo RA é numérico.',
            'ra.unique' => 'O RA já está em uso.',
            'ra.digits' => 'O RA ter ter oito dígitos.',
            'curso.required' => 'O campo Curso é obrigatório.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'O campo E-mail deve ter o formato \'exemplo@exemplo.com\'.',
            'email.unique' => 'O E-mail já está em uso.',
            'telefone0.required' => 'O campo Telefone é obrigatório.',
        ];
    }

}
