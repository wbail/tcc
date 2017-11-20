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
                'alpha_num',
                'min:5',
                'max:80',
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
            'rotulo.required' => 'O campo Rótulo é obrigatório.',
            'rotulo.unique' => 'Rótulo já cadastrado.',
            'rotulo.min' => 'O campo Rótulo deve conter no mínimo 5 caracteres.',
            'rotulo.max' => 'O campo Rótulo deve conter no máximo 80 caracteres.',
            'rotulo.alpha_num' => 'O campo Rótulo deve conter apenas letras e números.',
            'data.required' => 'O campo Data é obrigatório.',
        ];
    }

}
