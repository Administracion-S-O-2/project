<?php

namespace Database\Seeders;
use App\Models\Post;
use App\Models\User;
use App\Models\UnidadHabitacional;
use App\Models\Etapa;
use App\Models\NoAprobado;
use App\Models\Comprobante;
use App\Models\WorkHours;
use App\Models\Administrador;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->loadOAuthClients();
        $this->loadNoAprobados();
        $this->loadEtapas();
        $this->loadUnidades();
        $this->loadUsers();
        $this->loadComprobantes();
        $this->loadHours();
        $this->loadAdmin();
    }

    public function loadOAuthClients(){
        DB::table('oauth_clients')->insert([
            'id' => 1,
            'user_id' => null,
            'name' => 'LandingPage Password Grant Client',
            'secret' => '8TiQkuxtbz960ABz1KZ7MxroINvqx1g8SJiylfvc',
            'provider' => 'users',
            'redirect' => 'http://localhost',
            'personal_access_client' => 0,
            'password_client' => 1,
            'revoked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('oauth_clients')->insert([
            'id' => 2,
            'user_id' => null,
            'name' => 'UsuariosDeLaCooperativa Password Grant Client',
            'secret' => 'ElEP1LeengsUgpcPOdhSYuP6KQN2zdf49Npp2B2Q',
            'provider' => 'users',
            'redirect' => 'http://localhost',
            'personal_access_client' => 0,
            'password_client' => 1,
            'revoked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function loadNoAprobados(){
        NoAprobado::factory(5)->create();
    }

    public function loadUsers(){
        User::factory(2)->create([
            'unidad_habitacional_id' => 1
        ]);
        User::factory(1)->create([
            'unidad_habitacional_id' => 2
        ]);
        User::factory(3)->create([
            'unidad_habitacional_id' => 3
        ]);

        $user = User::factory()->create([
            'name' => 'vicenzo',
            'lastname' => 'moneta',
            'email' => 'vicenzomoneta612@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'unidad_habitacional_id' => 4
        ]);
    }

    public function loadEtapas(){
        Etapa::factory(3)->create();
        Etapa::factory()->create([
            'id' => 4,
            'name' => 'Planificacion',
        ]);
    }

    public function loadUnidades(){
        UnidadHabitacional::factory()
            ->count(5)
            ->create([
                'etapa_id' => 4,
            ]);
    }

    public function loadComprobantes(){
        Comprobante::factory()
            ->count(3)
            ->create([
                'user_id' => 1,
            ]);
        Comprobante::factory()
            ->count(2)
            ->create([
                'user_id' => 2,
            ]);
        Comprobante::factory()
            ->count(3)
            ->create([
                'user_id' => 3,
            ]);
    }

    public function loadHours(){
        WorkHours::factory()
            ->count(3)
            ->create([
                'user_id' => 1,
            ]);
        WorkHours::factory()
            ->count(2)
            ->create([
                'user_id' => 2,
            ]);
        WorkHours::factory()
            ->count(3)
            ->create([
                'user_id' => 3,
            ]);
    }

    public function loadAdmin(){
        Administrador::factory()->create([
            'name' => 'vicenzo',
            'lastname' => 'moneta',
            'email' => 'vicenzo@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
        ]);
    }

}
            