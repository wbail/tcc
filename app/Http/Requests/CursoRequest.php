<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CursoRequest extends FormRequest
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
            'coordenador' => 'required',
            'iniciovigencia' => 'required|date_format:d/m/Y',
            'fimvigencia' => 'date_format:d/m/Y|after:iniciovigencia',
            'nome' => [
                'required',
                'min:3',
                'max:50',
                'regex:/([A-Z])\w.+[^0-9]/',
                Rule::unique('cursos')->ignore($this->id)
            ],
            'departamento' => [
                'required',
            ],
        ];
    }

    public function messages()
    {
        return [
            'coordenador.required' => 'O campo Coordenador é obrigatório.',
            'iniciovigencia.required' => 'O campo Data de Início é obrigatório.',
            'iniciovigencia.date_format' => 'O campo Data de Início deve ter o formato de data \'dd/mm/aaaa\'.',
            'fimvigencia.date_format' => 'O campo Data de Término deve ter o formato de data \'dd/mm/aaaa\'.',
            'fimvigencia.after' => 'O campo Data de Término deve ter uma data superior a Data de Início.',
            'nome.required' => 'O campo Nome do Curso é obrigatório.',
            'nome.regex' => 'O campo Nome do Curso aceita apenas letras.',
            'nome.unique' => 'Já existe um Curso cadastrado com este nome.',
            'nome.min' => 'O campo Nome requer ao menos 3 caracteres.',
            'nome.max' => 'O campo Nome permite até 50 caracteres.',
            'departamento.required' => 'O campo Departamento é obrigatório.',
        ];
    }
}
