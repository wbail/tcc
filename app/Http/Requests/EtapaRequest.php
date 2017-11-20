<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EtapaRequest extends FormRequest {

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
            
            'desc' => [
                'required',
                'alpha',
                'max:45',
                'min:1',
                Rule::unique('etapas')->ignore($this->id)
            ],
            'banca' => 'unique:etapas,banca',
        ];
    }

    /**
     * Retorna as mensagens de erro
     * 
     * @return array
     */
    public function messages() {
        return [
            
            'desc.required' => 'O campo Descrição é obrigatório.',
            'desc.unique' => 'Etapa já cadastrada.',
            'desc.alpha' => 'O campo Descrição deve conter apenas letras.',
            'desc.max' => 'O campo Descrição permite até 45 caracteres.',
            'desc.min' => 'O campo Descrição deve ter no mímino 1 caracter.',
            'desc.alpha_num' => 'O campo Descrição aceita apenas letras e números.',
            'banca.unique' => 'Já existe uma etapa Banca',
        ];
    }
}
