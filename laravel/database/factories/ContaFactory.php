<?php

namespace Database\Factories;

use App\Models\Conta;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContaFactory extends Factory
{
    protected $model = Conta::class;

    public function definition(): array
    {
        return [
            'conta_id' => $this->faker->numberBetween(1000, 9999),
            'saldo' => $this->faker->randomFloat(2, 1000.00, 9999.99),
        ];
    }
}
