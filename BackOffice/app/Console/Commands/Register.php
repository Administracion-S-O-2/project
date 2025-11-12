<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Administrador;

class Register extends Command
{
    
    // https://laravel.com/docs/12.x/artisan#writing-commands
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask("Nombre? (sin apellido)");
        $lastName = $this->ask("Apellido");
        $email = '';
        while (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email = $this->ask("Email");
        }
        
        $password = $this->ask("Contraseña");
        $role = $this->choice("Es un administrador o usuario?", ['Administrador', 'Usuario']);
        
        $passwordHash = Hash::make($password);
        
        $model = match ($role) {
            'Administrador' => Administrador::class,
            'usuario' => User::class,
        };
        
        $model::create([
            'name' => $name,
            'lastname' => $lastName,
            'email' => $email, 
            'password' => $passwordHash,
        ]);
        
        $this->info("$role creado exitosamente!");
    
        // si se quiere obfuscar
        // $password = $this->secret("Contraseña");
    }
}
