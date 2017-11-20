<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'sigla' => [
                'required',
                'max:10',
                'alpha_num',
                Rule::unique('trabalhos')->ignore($this->id),
            ],
            'titulo' => [
                'required',
                'max: 190',
                'alpha',
                Rule::unique('trabalhos')->ignore($this->id),
            ],
            'academico_id' => [
                'required',
                Rule::unique('academico_trabalhos')->ignore($this->id),
            ],
            'academico_id' => [
                'different:academico_id',
                Rule::unique('academico_trabalhos')->ignore($this->id),
            ],
            'ano' => 'date_format:Y|after_or_equal:' . \Carbon\Carbon::now()->format('Y'),
            'periodo' => 'required|integer|min:1|max:3',
            'orientador' => 'required',
            'coorientador' => 'different:orientador'
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
            'sigla.required' => 'O campo Sigla é obrigatório.',
            'titulo.unique' => 'Trabalho já cadastrado.',
            'titulo.alpha' => 'O Título deve conter apenas letras.',
            'titulo.max' => 'O Título deve conter até 190 caracteres.',
            'sigla.unique' => 'Sigla já cadastrada.',
            'sigla.max' => 'O campo Sigla deve conter até 10 caracteres.',
            'sigla.alpha_num' => 'O campo Sigla deve conter apenas letras e números.',
            'academico.required' => 'O campo Acadêmico(a) é obrigatório.',
            //'academico.unique' => 'O Acadêmico já está vinculado a um trabalho',
            'academico1.different' => 'Os(as) acadêmicos(as) devem ser diferentes.',
            'academico1.unique' => 'O segundo Acadêmico já está vinculado a um trabalho',
            'ano.required' => 'O campo Ano é obrigatório.',
            'ano.date_format' => 'O campo Ano deve ter quatro dígitos.',
            'ano.after_or_equal' => 'O campo Ano deve ser igual ou maior ao ano atual.',
            'orientador.required' => 'O campo Orientador(a) é obrigatório.',
            'coorientador.different' => 'Os orientadores devem ser diferentes.',
            'periodo.required' => 'O campo Período é obrigatório.',
        ];
    }
}
