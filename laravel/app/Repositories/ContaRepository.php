<?php
namespace App\Repositories;

use App\Models\Conta;

class ContaRepository
{
    public function create(array $data) {
        return Conta::create($data);
    }

    public function getAllContas() {
        return Conta::all();
    }

    public function findByContaId($contaId)
    {
        return Conta::where('conta_id', $contaId)->first();
    }

    public function persistSaldo(Conta $conta, float $valor)
    {
        $conta->setSaldo($conta->saldo - $valor);
        $conta->save();
    }
}
