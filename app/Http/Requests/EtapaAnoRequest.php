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
            'titulo.unique' => 'Título já cadaastrado.',
            'data_final.required' => 'O campo Data Final é obrigatório.',
            'data_final.after' => 'A Data Final deve ser a partir de amanhã.',
        ];
    }
}


