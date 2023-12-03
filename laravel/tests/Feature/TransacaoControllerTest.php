<?php

namespace Tests\Feature\Controllers;

use App\Models\Conta;
use App\Models\Transacao;
use App\Repositories\TaxaRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransacaoControllerTest extends TestCase
{
    use WithFaker;

    public function testStoreTransacao(): void
    {
        $taxaRepository = new TaxaRepository();
        $saldoInicial = 1000.00;
        $conta = Conta::factory()->create(['saldo' => $saldoInicial, 'conta_id' => 8888]);
        $payload = [
            'conta_id' => $conta->conta_id,
            'valor' => 100.00,
            'forma_pagamento' => 'C'
        ];

        $response = $this->post('/api/transacao', $payload);

        $ultimoIdTransacao = Transacao::latest('id')->first()->id;
        $transacao = Transacao::find($ultimoIdTransacao);
        $valorASerCobrado = $payload['valor'] * $taxaRepository->getTaxa($payload['forma_pagamento']);
        $saldoAtualizado = $saldoInicial - $valorASerCobrado;

        $response->assertStatus(201)
            ->assertJson([
                'conta_id' => $payload['conta_id'],
                'saldo' => $saldoAtualizado,
            ]);

        $transacao->delete();
        $conta->delete();

        $this->assertDatabaseMissing('transacoes', ['id' => $ultimoIdTransacao]);
        $this->assertDatabaseMissing('contas', ['conta_id' => $conta->conta_id]);
    }
}
