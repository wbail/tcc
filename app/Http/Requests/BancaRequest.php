<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BancaRequest extends FormRequest
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
            // 'data' => 'required',
            'trabalho' => 'required|unique:bancas,trabalho_id',
            'membro' => 'required',
            'membro2' => 'required',
            'suplente' => 'required',
            'suplente2' => 'required'
        ];
    }

    /**
     * Tradução das mensagens de erros
     *
     * @return array
     */
    public function messages()
    {
        return [
            'data.required' => 'O campo Data é obrigatório.',
            'trabalho.unique' => 'Trabalho já cadastrado para Bancas.',
            'membro.required' => 'O campo Membro de Banca é obrigatório.',
            'membro2.required' => 'O campo Membro de Banca é obrigatório.',
            'suplente.required' => 'O campo Membro Suplente é obrigatório.',
            'suplente2.required' => 'O campo Membro Suplente é obrigatório.',
            'membro.different' => 'Os membros de banca devem ser distintos.',
            'membro2.different' => 'Os membros de banca devem ser distintos.',
            'suplente.different' => 'Os membros de banca devem ser distintos.',
            'suplente2.different' => 'Os membros de banca devem ser distintos.',
        ];
    }
}
