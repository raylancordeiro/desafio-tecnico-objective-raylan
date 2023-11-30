<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransacaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'conta_id' => [
                'required',
                'integer',
                'exists:contas,conta_id'
                ],
            'valor' => [
                'required',
                'numeric',
                'min:0',
                ],
            'forma_pagamento' => [
                'required',
                'in:P,C,D',
                ]
        ];
    }

    public function messages(): array
    {
        return [
            'conta_id.required' => 'O campo conta_id é obrigatório.',
            'conta_id.exists' => 'A conta informada não existe na tabela contas.',
            'valor.required' => 'O campo valor é obrigatório.',
            'valor.numeric' => 'O campo valor deve ser um número.',
            'forma_pagamento.in' => 'O campo forma de pagamento deve ser P, C ou D.',
            'valor.min' => 'O valor da transação não pode ser menor que zero.',
        ];
    }

}
