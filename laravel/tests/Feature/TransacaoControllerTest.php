<?php

namespace Tests\Feature\Controllers;

use App\Models\Conta;
use App\Models\Transacao;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransacaoControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testStoreTransacao(): void
    {
        $conta = Conta::factory()->create(['saldo' => 1000.00, 'conta_id' => 8888]);

        $payload = [
            'conta_id' => $conta->conta_id,
            'valor' => 100.00,
            'forma_pagamento' => 'C'
        ];

        $response = $this->post('/api/transacao', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'conta_id' => $payload['conta_id'],
                'valor' => $payload['valor'],
                'forma_pagamento' => $payload['forma_pagamento']
            ]);

        $ultimoIdTransacao = Transacao::latest('id')->first()->id;
        $transacao = Transacao::find($ultimoIdTransacao);

        $this->assertEquals($payload['conta_id'], $transacao->conta_id);
        $this->assertEquals($payload['valor'], $transacao->valor);
        $this->assertEquals($payload['forma_pagamento'], $transacao->forma_pagamento);

        $transacao->delete();
        $conta->delete();

        $this->assertDatabaseMissing('transacoes', ['id' => $ultimoIdTransacao]);
        $this->assertDatabaseMissing('contas', ['conta_id' => $conta->conta_id]);
    }
}
