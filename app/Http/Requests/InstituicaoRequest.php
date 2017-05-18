<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstituicaoRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){

        return [
            'nome' => array('required', 'regex:/([A-Z])\w.+[^0-9]/', 'unique:instituicaos,nome'),
            'sigla' => [
                'required',
                'regex:/([A-Z])\w.+[^0-9]/',
                'max:10',
                'unique:instituicaos,sigla',
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
            'sigla.required' => 'O campo Sigla é obrigatório.',
            'nome.alpha' => 'O campo Nome aceita somente letras.',
            'sigla.alpha' => 'O campo Sigla aceita somente letras.',
            'sigla.max' => 'O campo Sigla deve conter até 10 caracteres.',
            'nome.unique' => 'Nome já cadastrado.',
            'sigla.unique' => 'Sigla já cadastrada.',
        ];
    }
}
