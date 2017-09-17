<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartamentoRequest extends FormRequest {

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
            'instituicao' => 'required',
            'nome' => [
                'required',
                'min:3',
                'max:40',
                //'regex:/([A-Z])\w.+[^0-9]/',
                Rule::unique('departamentos')->ignore($this->id),
            ],
            'sigla' => [
                'required',
                'alpha',
                'min:3',
                'max:10',
                
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
            'instituicao.required' => 'O campo Instituição é obrigatório.',
            'nome.required' => 'O campo Nome é obrigatório.',
            'nome.alpha' => 'O campo Nome deve ter apenas letras.',
            'nome.min' => 'O campo Nome deve ter no mínimo 3 caracteres.',
            'nome.max' => 'O campo Nome permite até 40 caracteres.',
            'nome.unique' => 'Nome já cadastrado.',
            'nome.regex' => 'O formato ....',
            'sigla.required' => 'O campo Sigla é obrigatório.',
            'sigla.alpha' => 'O campo Sigla deve ter apenas letras.',
            'sigla.min' => 'O campo Sigla deve ter no mínimo 3 caracteres.',
            'sigla.max' => 'O campo Sigla permite até 10 caracteres.',
            'sigla.unique' => 'Sigla já cadastrada.',
        ];
    }
}
