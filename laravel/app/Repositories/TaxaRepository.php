<?php

namespace App\Repositories;

use App\Models\Taxa;

class TaxaRepository
{
    /**
     * @throws \Exception
     */
    public function getTaxa(string $formaPagamento)
    {
        $taxa = Taxa::where('forma_pagamento', $formaPagamento)->value('porcentagem');
        if (!$taxa) {
            throw new \Exception('Taxa não encontrada na base');
        }

        return $taxa;
    }
}
