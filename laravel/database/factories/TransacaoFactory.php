<?php

namespace Database\Factories;

use App\Models\Transacao;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Conta;

class TransacaoFactory extends Factory
{
    protected $model = Transacao::class;

    public function definition(): array
    {
        return [
            'conta_id' => Conta::factory()->create(),
            'valor' => $this->faker->randomFloat(2, 10, 100),
            'forma_pagamento' => $this->faker->randomElement(['D', 'C', 'P']),
        ];
    }
}
