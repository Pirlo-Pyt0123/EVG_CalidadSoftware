<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_redirects_after_web_form_submission(): void
    {
        $response = $this
            ->withHeaders([
                'Accept' => 'text/html,application/xhtml+xml',
            ])
            ->post(route('personas.store'), [
                'nombres' => 'Ana',
                'apellidos' => 'Lopez',
                'correo' => 'ana@example.com',
                'sexo' => 'F',
            ]);

        $response->assertRedirect(route('personas.create'));
        $response->assertSessionHas('success', 'Persona registrada correctamente.');

        $this->assertDatabaseHas('personas', [
            'nombres' => 'Ana',
            'apellidos' => 'Lopez',
            'correo' => 'ana@example.com',
            'sexo' => 'F',
        ]);
    }

    public function test_store_returns_json_with_201_for_json_requests(): void
    {
        $response = $this->postJson('/api/personas', [
            'nombre' => 'Carlos',
            'apellidos' => 'Perez',
            'correo' => 'carlos@example.com',
            'sexo' => 'M',
        ]);

        $response->assertCreated()
            ->assertJson([
                'message' => 'Persona registrada correctamente.',
                'data' => [
                    'nombres' => 'Carlos',
                    'apellidos' => 'Perez',
                    'correo' => 'carlos@example.com',
                    'sexo' => 'M',
                ],
            ]);

        $this->assertDatabaseHas('personas', [
            'correo' => 'carlos@example.com',
        ]);
    }

    public function test_store_returns_201_for_jmeter_style_form_submission(): void
    {
        $response = $this
            ->withHeaders([
                'Accept' => '*/*',
            ])
            ->post(route('personas.store'), [
                '_token' => 'fake-token-for-test',
                'nombre' => 'Luisa',
                'apellidos' => 'Martinez',
                'fechanacimiento' => 'luisa@example.com',
                'sexo' => 'F',
            ]);

        $response->assertCreated()
            ->assertJson([
                'message' => 'Persona registrada correctamente.',
                'data' => [
                    'nombres' => 'Luisa',
                    'apellidos' => 'Martinez',
                    'correo' => 'luisa@example.com',
                    'sexo' => 'F',
                ],
            ]);

        $this->assertDatabaseHas('personas', [
            'correo' => 'luisa@example.com',
        ]);
    }
}