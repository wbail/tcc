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
            'nome' => array(
                'required',
                //'regex:/([A-Z])\w.+[^0-9]/',
                'alpha',
                'unique:instituicaos,nome',
                'max:80',
                'min:5'
            ),
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
            'nome.alpha' => 'O campo Nome aceita somente letras.',
            'nome.unique' => 'Nome já cadastrado.',
            'nome.regex' => 'O campo Nome deve conter apenas letras.',
            'nome.max' => 'O campo Nome deve conter no máximo 80 caracteres.',
            'nome.min' => 'O campo Nome deve conter no mínimo 5 caracteres.',
            'sigla.alpha' => 'O campo Sigla aceita somente letras.',
            'sigla.required' => 'O campo Sigla é obrigatório.',
            'sigla.max' => 'O campo Sigla deve conter até 10 caracteres.',
            'sigla.unique' => 'Sigla já cadastrada.',
        ];
    }
}
