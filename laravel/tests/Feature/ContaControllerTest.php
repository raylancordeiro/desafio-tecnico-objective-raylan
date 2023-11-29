<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCriarConta()
    {
        $data = [
            'conta_id' => 1234,
            'saldo' => 12.34,
        ];

        $response = $this->post('api/conta', $data);

        $response->assertStatus(201)
            ->assertJson([
                'conta_id' => $data['conta_id'],
                'saldo' => $data['saldo']
        ]);

        $this->artisan('migrate:refresh');
    }
}
