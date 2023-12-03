<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ContaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'conta_id' => [
                'required',
                'unique:contas',
                'integer',
            ],
            'saldo' => [
                'required',
                'numeric',
                'min:0'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'conta_id.required' => 'O campo conta_id é obrigatório.',
            'conta_id.unique' => 'O valor do campo conta_id já existe.',
            'conta_id.integer' => 'O campo conta_id deve ser um número inteiro.',
            'saldo.required' => 'O campo saldo é obrigatório.',
            'saldo.numeric' => 'O campo saldo deve ser um número.',
            'valor.min' => 'O valor do saldo não pode ser menor que zero.',
        ];
    }
}
