<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArquivoRequest extends FormRequest
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
            'descricao' => 'required|file|min:0.1|max:1000|mimes:doc,docx,txt,pdf'
        ];
    }

    /**
     * Retonar as mensagens traduzidas
     *
     * @return array
     */
    public function messages()
    {
        return [
            'descricao.required' => 'O campo Arquivo é obrigatório.',
            'descricao.min' => 'O Arquivo deve ter no mínimo 3 Kb.',
            'descricao.max' => 'O Arquivo deve ter no máximo 1 Megabyte.',
            'descricao.mimes' => 'O Arquivo deve ter umas seguintes extenções: doc, docx, txt ou pdf.',
        ];
    }
}
