<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnoLetivoRequest extends FormRequest
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
            'rotulo' => [
                'required',
                Rule::unique('ano_letivos')->ignore($this->id)
            ],
            'data' => 'required'
        ];
    }

    /**
     * Retorna mensagem traduzida.
     *
     * @return array
     */
    public function messages() {
        return [
            'rotulo.required' => 'O campo Rotulo e obrigatorio.',
            'rotulo.unique' => 'Rotulo ja cadastrado.',
            'data.required' => 'O campo Data e obrigatorio.',
        ];
    }

}