<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EtapaAnoRequest extends FormRequest
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
            'etapa' => 'required',
            'titulo' => [
                'required',
                'unique:etapa_anos,titulo',
                'min:5',
                'max:100',
                'alpha_num',
                Rule::unique('etapa_anos')->ignore($this->id),
            ],
            'data_final' => 'required|after:today',            
        ];
    }

    public function messages()
    {
        return [
            'etapa.required' => 'O campo Título é obrigatório.',
            'titulo.required' => 'O campo Descrição é obrigatório.',
            'titulo.unique' => 'Título já cadastrado.',
            'titulo.min' => 'O campo Descrição deve conter no mínimo 5 caracteres.',
            'titulo.max' => 'O campo Descrição deve conter no máximo 100 caracteres.',
            'titulo.alpha_num' => 'O campo Descrição deve conter apenas letras e números.',
            'data_final.required' => 'O campo Data Final é obrigatório.',
            'data_final.after' => 'A Data Final deve ser a partir de amanhã.',
        ];
    }
}


