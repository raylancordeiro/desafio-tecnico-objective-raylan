<?php

namespace App\Services;

use App\Models\Conta;
use App\Models\Transacao;
use App\Repositories\ContaRepository;
use App\Repositories\TransacaoRepository;

class TransacaoService
{
    public const TAXA = [
        'D' => 1.03,
        'C' => 1.05,
        'P' => 1
    ];
    private ContaRepository $contaRepository;
    private TransacaoRepository $transacaoRepository;

    public function __construct(TransacaoRepository $transacaoRepository, ContaRepository $contaRepository)
    {
        $this->transacaoRepository = $transacaoRepository;
        $this->contaRepository = $contaRepository;
    }

    /**
     * @throws \Exception
     */
    public function processarTransacao(array $transacaoData): Transacao
    {
        $transacao = new Transacao($transacaoData);

        $conta = $this->contaRepository->findByContaId($transacao->conta_id);

        $valorTransacao = $transacao->valor;
        $formaPagamento = $transacao->forma_pagamento;

        $valorASerCobrado = $valorTransacao * self::TAXA[$formaPagamento];

        $this->deduzirSaldo($conta, $valorASerCobrado);
        $transacao = $this->transacaoRepository->create($transacaoData);


        return $transacao;
    }

    /**
     * @throws \Exception
     */
    private function deduzirSaldo(Conta $conta, float $valor): void
    {
        if ($conta->saldo >= $valor) {
            $this->contaRepository->persistSaldo($conta, $valor);
        } else {
            throw new \Exception('Saldo insuficiente.');
        }
    }
}
