<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[UseFactory(AdministradorFactory::class)]
class Administrador extends Persona implements Authenticatable
{

    use SoftDeletes, AuthenticatableTrait, HasFactory;

    public function Comprobante(): HasMany
    {
        return $this->hasMany(Comprobante::class);
    }

    public function NoAprobados(): HasMany
    {
        return $this->hasMany(NoAprobados::class);
    }

    protected $fillable = [
        'name',
        'lastname',
        'email',
        'phone',       
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
