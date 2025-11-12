<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;
use App\Exceptions\NoAprobadoException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class NoAprobado extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [ 
        'name',
        'lastname',
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'created_at',
        'id',
        'updated_at'
    ];

}
