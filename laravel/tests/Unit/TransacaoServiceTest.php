<?php

namespace Tests\Unit\Services;

use App\Models\Conta;
use App\Models\Transacao;
use App\Repositories\ContaRepository;
use App\Repositories\TaxaRepository;
use App\Repositories\TransacaoRepository;
use App\Services\TransacaoService;
use Tests\TestCase;

/**
 * Teste unitário da classe TransacaoService
 */
class TransacaoServiceTest extends TestCase
{
    /**
     * Testa calculo da função TransacaoService::processarPagamento()
     *
     * @return void
     * @throws \Exception
     */
    public function testProcessarTransacao(): void
    {
        $transacao = Transacao::factory()->make()->makeVisible(['id']);
        $taxaRepository = new TaxaRepository();
        $transacaoService = new TransacaoService(
            new TransacaoRepository(),
            new ContaRepository(),
            new TaxaRepository()
        );

        $conta = Conta::find($transacao->conta_id);
        $saldoInicial = $conta->getSaldo();

        $contaAtualizada = $transacaoService->processarTransacao($transacao->toArray());

        $valorCobrado = $transacao->valor * $taxaRepository->getTaxa($transacao->forma_pagamento);
        $saldoEsperado = Conta::currencyFormat($saldoInicial - $valorCobrado);

        $this->assertEquals($saldoEsperado, $contaAtualizada->getSaldo());

        $conta->delete();
        $transacao->delete();

        $this->assertDatabaseMissing('transacoes', ['id' => $transacao->id]);
        $this->assertDatabaseMissing('contas', ['conta_id' => $conta->conta_id]);
    }
}
