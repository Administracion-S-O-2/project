<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\NoAprobado;
use Illuminate\Support\Facades\Hash;
use App\Exceptions;

class NoAprobadoTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_exitoso()
    {
        $data = [
            'name' => 'vicenzo',
            'lastname' => 'moneta' ,
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'email' => 'vicenzo@gmail.com'
        ];

        $response = $this->post('/api/noAprobado' , $data);

        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'Registro exitoso',
            'solicitud' => [
                'email' => 'vicenzo@gmail.com',
                'lastname' => 'moneta',
                'name' => 'vicenzo',
            ]
        ]);
        $this->assertDatabaseHas('no_aprobados', [
            'email' => 'vicenzo@gmail.com'
        ]);
    }

    public function test_create_email_repetido()
    {
        $solicitud = NoAprobado::create([
            'name' => 'vicenzo',
            'lastname' => 'moneta',
            'password' => Hash::make('12345678'),
            'email' => 'vicenzo@gmail.com'
        ]);   

        $data = [
            'name' => 'halley',
            'lastname' => 'hernandez' ,
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'email' => 'vicenzo@gmail.com'
        ];

        $response = $this->post('/api/noAprobado' , $data);
        $response->assertStatus(401);
        $response->assertJson([
            'error' => '{"email":["The email has already been taken."]}'
        ]);
    }

    public function test_create_password_invalida()
    {
        $data = [
            'name' => 'halley',
            'lastname' => 'hernandez' ,
            'password' => '1234',
            'password_confirmation' => '1234',
            'email' => 'halley@gmail.com'
        ];

        $response = $this->post('/api/noAprobado' , $data);

        $response->assertStatus(401);
        $response->assertJson([
            'error' => '{"password":["The password must be at least 8 characters."]}'
        ]);
    }
}
