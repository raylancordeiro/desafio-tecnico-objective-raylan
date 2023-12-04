<?php

namespace Tests\Feature;

use App\Models\Conta;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

/**
 *  Testa o controller de Conta.
 */
class ContaControllerTest extends TestCase
{
    /**
     * Testa POST api/conta.
     *
     * @return void
     */
    public function testCriarConta(): void
    {
        $conta = Conta::factory()->make();
        $response = $this->post('api/conta', $conta->toArray());

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson($conta->toArray());

        $contaCriada = Conta::find($response['conta_id']);
        $contaCriada->delete();
    }

    /**
     * Testa GET api/conta.
     *
     * @return void
     */
    public function testGetConta(): void
    {
        $conta = Conta::factory()->create();

        $response = $this->get(route('conta', ['id' => $conta->conta_id]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson($conta->toArray());

        $conta->delete();
    }

    /**
     * Testa exceção da rota GET api/conta buscando um id aleatório.
     *
     * @return void
     */
    public function testNotFound(): void
    {
        $response = $this->get(route('conta', ['id' => mt_rand(1000, 9999)]));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Testa exceção da rota GET api/conta sem passar o id da conta.
     *
     * @return void
     */
    public function testNotFoundEmptyId(): void
    {
        $response = $this->get(route('conta'));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Testa exceção da rota GET api/conta passando uma string aleatória.
     *
     * @return void
     */
    public function testSetStringId(): void
    {
        $response = $this->get(route('conta', ['id' => Str::random(4)]));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
