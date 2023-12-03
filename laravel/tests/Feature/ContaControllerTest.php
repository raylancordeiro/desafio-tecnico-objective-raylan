<?php

namespace Tests\Feature;

use App\Models\Conta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContaControllerTest extends TestCase
{
    private $contaId;

    public function testCriarConta(): void
    {
        $data = [
            'conta_id' => 1234,
            'saldo' => 12.34,
        ];

        $response = $this->post('api/conta', $data);

        $response->assertStatus(201)
            ->assertJson($data);

        $this->contaId = $data['conta_id'];
    }

    protected function tearDown(): void
    {
        Conta::where('conta_id', $this->contaId)->delete();
        parent::tearDown();
    }
}
