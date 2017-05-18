<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrabalhoRequest extends FormRequest {

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
            'titulo' => 'required',
            'academico' => 'required',
            'ano' => 'required|date_format:Y|after_or_equal:' . \Carbon\Carbon::now()->format('Y'),
            'periodo' => 'required|integer|min:1|max:2',
            'avaliador' => 'required'            
        ];
    }

    /**
     * Retorna as mensagens de erro
     * 
     * @return array
     */
    public function messages() {
        return [
            'titulo.required' => 'O campo Título é obrigatório.',
            'academico.required' => 'O campo Acadêmico(a) é obrigatório.',
            'academico.different' => 'Os(as) acadêmicos(as) devem ser diferentes.',
            'ano.required' => 'O campo Ano é obrigatório.',
            'ano.date_format' => 'O campo Ano deve ter quatro dígitos.',
            'ano.after_or_equal' => 'O campo Ano deve ser igual ou maior ao ano atual.',
            'avaliador.required' => 'O campo Avaliador(a) é obrigatório.',
            'periodo.required' => 'O campo Período é obrigatório.',
        ];
    }
}
