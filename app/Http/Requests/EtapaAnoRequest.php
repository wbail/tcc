<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

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
            'titulo' => 'required',
            'data_final' => 'required|after:today',
            'data_inicial' => 'before:data_final',
            
        ];
    }

    public function messages()
    {
        return [
            'etapa.required' => 'O campo Título é obrigatório.',
            'titulo.required' => 'O campo Descrição é obrigatório.',
            'data_final.required' => 'O campo Data Final é obrigatório.',
            'data_final.after' => 'A Data Final deve ser a partir de amanhã.',
            'data_inicial.before' => 'A Data Inicial deve ser uma data anterior que a Data Final',
        ];
    }
}
