<?php

namespace Tests\Feature;

use App\Models\Conta;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ContaControllerTest extends TestCase
{
    public function testCriarConta(): void
    {
        $conta = Conta::factory()->make();
        $response = $this->post('api/conta', $conta->toArray());

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson($conta->toArray());

        $contaCriada = Conta::find($response['conta_id']);
        $contaCriada->delete();
    }

    public function testGetConta()
    {
        $conta = Conta::factory()->create();

        $response = $this->get(route('conta', ['id' => $conta->conta_id]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson($conta->toArray());

        $conta->delete();
    }

    public function testNotFound()
    {
        $response = $this->get(route('conta', ['id' => mt_rand(1000, 9999)]));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testNotFoundEmptyId()
    {
        $response = $this->get(route('conta'));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testSetStringId()
    {
        $response = $this->get(route('conta', ['id' => Str::random(4)]));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
