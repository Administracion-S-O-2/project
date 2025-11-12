<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Administrador;
use Illuminate\Support\Facades\Hash;

class CreateAdminTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */

    // no anda, falta login validacion
    public function test_succesfull_create(): void
    {
        Administrador::create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'name' => 'admin',
            'lastname' => 'jacinto'
        ]);

        $login = ['email' => 'admin@gmail.com' , 'password' => '12345678'];

        $request = [
            'email' => 'admin@gmail.com',
            'password' => '12345678',
            'name' => 'Juan Pablo',
            'lastname' => 'Perez Hernandez',
            'new_admin_email' => 'juanPablo@gmail.com',
            'new_admin_password' => '12345678'
        ];

        $response = $this->post(route('admin.store'), $request);

        $admin = [
            'email' => 'juanPablo@gmail.com'
        ];

        $this->assertDatabaseHas('administradors', $admin);
    }
}
