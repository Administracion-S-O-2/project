<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */


    private $clientId = 2;
    private $clientSecret = "FwmUL21y9diSCAmV8PizNnruSPkV0KTe8rt2VrSt";
    private $userName = "testing@gmail.com";
    private $userPassword = "12345678";

    public function test_ObtenerTokenConClientIdValido()
    {
        try {
            User::create([
                'name' => 'testing',
                'lastname' => 'testing',
                'email' => 'testing@gmail.com',
                'phone' => '13232352',
                'password' => Hash::make('12345678'), 
                'email_verified_at' => now(), 
            ]);

            $response = $this->post('/oauth/token',[
                "username" => $this -> userName,
                "password" => $this -> userPassword,
                "grant_type" => "password",
                "client_id" => $this -> clientId,
                "client_secret" => $this -> clientSecret
            ]);

            $response->assertStatus(200);
            $response->assertJsonStructure([
                "token_type",
                "expires_in",
                "access_token",
                "refresh_token"
            ]);

        } catch (Exception $ex){
            echo $ex->getMessage();
        }
    }

}
