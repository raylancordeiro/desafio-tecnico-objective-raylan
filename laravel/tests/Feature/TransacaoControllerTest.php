<?php

namespace Tests\Feature\Controllers;

use App\Models\Conta;
use App\Models\Transacao;
use App\Repositories\TaxaRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TransacaoControllerTest extends TestCase
{
    use WithFaker;

    public function testStoreTransacao(): void
    {
        $taxaRepository = new TaxaRepository();
        $payload = Transacao::factory()->make();
        $saldoInicial = Conta::find($payload->conta_id)->getSaldo();

        $response = $this->post('/api/transacao', $payload->toArray());

        $ultimoIdTransacao = Transacao::latest('id')->first()->id;
        $transacao = Transacao::find($ultimoIdTransacao);
        $valorASerCobrado = $payload->valor * $taxaRepository->getTaxa($payload->forma_pagamento);
        $saldoAtualizado = Conta::currencyFormat($saldoInicial - $valorASerCobrado);

        $conta = Conta::find($transacao->conta_id);

        $response->assertStatus(201)
            ->assertJson([
                'conta_id' => $payload->conta_id,
                'valor' => Conta::currencyFormat($saldoAtualizado)
            ]);

        $transacao->delete();
        $conta->delete();

        $this->assertDatabaseMissing('transacoes', ['id' => $ultimoIdTransacao]);
        $this->assertDatabaseMissing('contas', ['conta_id' => $conta->conta_id]);
    }

    public function testNotFound()
    {
        $response = $this->post('/api/transacao', [
            'conta_id' => mt_rand(1000, 9999),
            'forma_pagamento' => 'D',
            'valor' => mt_rand(100, 9999) / 100
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }


    public function testUnprocessableEntityInvalidPaymentMethod()
    {
        $conta = Conta::factory()->create();

        $response = $this->post('/api/transacao', [
            'conta_id' => $conta->conta_id,
            'forma_pagamento' => 'E',
            'valor' => mt_rand(100, 9999) / 100
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $conta->delete();
    }

    public function testUnprocessableEntityInvalidValue()
    {
        $conta = Conta::factory()->create();

        $response = $this->post('/api/transacao', [
            'conta_id' => $conta->conta_id,
            'forma_pagamento' => 'P',
            'valor' => Str::random(4),
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $conta->delete();
    }
}
