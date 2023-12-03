<?php
namespace App\Repositories;

use App\Models\Conta;

class ContaRepository
{
    public function create(array $data): Conta
    {
        return Conta::create($data);
    }

    public function findByContaId($contaId): Conta
    {
        return Conta::where('conta_id', $contaId)->first();
    }

    public function persistSaldo(Conta $conta, float $valor): void
    {
        $conta->setSaldo($conta->saldo - $valor);
        $conta->save();
    }
}
