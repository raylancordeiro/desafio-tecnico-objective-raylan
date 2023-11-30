<?php

namespace Database\Factories;

use App\Models\Conta;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContaFactory extends Factory
{
    protected $model = Conta::class;

    public function definition()
    {
        return [
            'saldo' => $this->faker->numberBetween(100, 1000),
        ];
    }
}
