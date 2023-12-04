<?php

namespace Tests\Feature\Controllers;

use App\Models\Conta;
use App\Models\Transacao;
use App\Repositories\TaxaRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

/**
 * Testa controller Transacao.
 */
class TransacaoControllerTest extends TestCase
{
    use WithFaker;

    /**
     * Testa POST api/transacao.
     *
     * @return void
     * @throws \Exception
     */
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

    /**
     * Testa exceção da rota POST api/transacao passando uma conta inválida.
     *
     * @return void
     */
    public function testNotFound(): void
    {
        $response = $this->post('/api/transacao', [
            'conta_id' => mt_rand(1000, 9999),
            'forma_pagamento' => 'D',
            'valor' => mt_rand(100, 9999) / 100
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }


    /**
     * Testa exceção da rota POST api/transacao passando uma forma de pagamento inválida.
     *
     * @return void
     */
    public function testUnprocessableEntityInvalidPaymentMethod(): void
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

    /**
     * Testa exceção da rota POST api/transacao passando um valor do tipo string.
     *
     * @return void
     */
    public function testUnprocessableEntityInvalidValue(): void
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
