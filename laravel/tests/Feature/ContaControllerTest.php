<?php

namespace Tests\Feature;

use App\Models\Conta;
use App\Repositories\ContaRepository;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ContaControllerTest extends TestCase
{
    public function testCriarConta(): void
    {
        $conta = Conta::factory()->make();
        $response = $this->post('api/conta', $conta->toArray());

        $response->assertStatus(201)
            ->assertJson($conta->toArray());

        $contaCriada = Conta::find($response['conta_id']);
        $contaCriada->delete();
    }
}
