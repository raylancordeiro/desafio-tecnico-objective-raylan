<?php

namespace Tests\Unit\Services;

use App\Models\Conta;
use App\Models\Transacao;
use App\Repositories\ContaRepository;
use App\Repositories\TaxaRepository;
use App\Repositories\TransacaoRepository;
use App\Services\TransacaoService;
use Tests\TestCase;

class TransacaoServiceTest extends TestCase
{
    private mixed $transacaoId;

    public function testProcessarTransacao(): void
    {
        $conta = Conta::factory()->create(['saldo' => 1000.00, 'conta_id' => 9999]);

        $transacaoData = [
            'conta_id' => $conta->conta_id,
            'valor' => 100.12,
            'forma_pagamento' => 'D'
        ];

        $transacaoService = new TransacaoService(
            new TransacaoRepository(),
            new ContaRepository(),
            new TaxaRepository()
        );

        $taxaRepository = new TaxaRepository();

        $transacao = Transacao::factory()->make($transacaoData)->makeVisible(['id']);
        $this->transacaoId = $transacao->id;

        $transacao = $transacaoService->processarTransacao($transacao->toArray());
        $contaAtualizada = Conta::find($conta->conta_id);

        $valorDebitado = $transacaoData['valor'] * $taxaRepository->getTaxa($transacaoData['forma_pagamento']);
        $valorEsperado = number_format($conta->getSaldo() - $valorDebitado, 2, '.', '');

        $this->assertEquals($valorEsperado, $contaAtualizada->getSaldo());

        $transacao->delete();
        $conta->delete();

        $this->assertDatabaseMissing('transacoes', ['id' => $transacao->id]);
        $this->assertDatabaseMissing('contas', ['conta_id' => $conta->conta_id]);
    }

    protected function tearDown(): void
    {
        Transacao::where('id', $this->transacaoId)->delete();
        parent::tearDown();
    }
}
