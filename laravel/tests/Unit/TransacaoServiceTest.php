<?php

namespace Tests\Unit\Services;

use App\Models\Conta;
use App\Models\Transacao;
use App\Repositories\ContaRepository;
use App\Repositories\TransacaoRepository;
use App\Services\TransacaoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransacaoServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testProcessarTransacao()
    {
        $conta = Conta::factory()->create(['saldo' => 1000.00, 'conta_id' => 9999]);

        $transacaoData = [
            'conta_id' => $conta->conta_id,
            'valor' => 100.00,
            'forma_pagamento' => 'D'
        ];

        $transacaoService = new TransacaoService(new TransacaoRepository(), new ContaRepository());

        $transacao = Transacao::factory()->make($transacaoData)->makeVisible(['id']);

        $transacao = $transacaoService->processarTransacao($transacao->toArray());

        $contaAtualizada = Conta::find($conta->conta_id);

        $valorDebitado = $transacaoData['valor'] * TransacaoService::TAXA[$transacaoData['forma_pagamento']];

        $this->assertEquals($conta->saldo - $valorDebitado, $contaAtualizada->saldo);

        $transacao->delete();
        $conta->delete();

        $this->assertDatabaseMissing('transacoes', ['id' => $transacao->id]);
        $this->assertDatabaseMissing('contas', ['conta_id' => $conta->conta_id]);
    }
}
