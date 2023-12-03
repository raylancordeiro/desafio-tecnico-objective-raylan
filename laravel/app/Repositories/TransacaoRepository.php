<?php

namespace App\Repositories;

use App\Models\Transacao;

class TransacaoRepository
{
    public function create(array $data): Transacao
    {
        return Transacao::create($data);
    }
}
