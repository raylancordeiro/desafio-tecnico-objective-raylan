<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class TransacaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtém regras de validação da requisição transação
     *
     * @return array<string, ValidationRule|array|string>
     */
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

    /**
     * Personaliza um retorno de erro específico para exceções de validação do atributo conta_id
     *
     * @param Validator $validator
     * @return void
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors();

        if ($errors->has('conta_id')) {
            $customMessage = 'A conta informada não existe na tabela contas.';
            throw new ValidationException(
                $validator,
                response()->json(
                    ['message' => $customMessage],
                    Response::HTTP_NOT_FOUND
                )
            );
        }

        parent::failedValidation($validator);
    }

    /**
     * Obtém mensagens de erro personalizadas
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'conta_id.required' => 'O campo conta_id é obrigatório.',
            'valor.required' => 'O campo valor é obrigatório.',
            'valor.numeric' => 'O campo valor deve ser um número.',
            'forma_pagamento.in' => 'O campo forma de pagamento deve ser P, C ou D.',
            'valor.min' => 'O valor da transação não pode ser menor que zero.',
        ];
    }

}
