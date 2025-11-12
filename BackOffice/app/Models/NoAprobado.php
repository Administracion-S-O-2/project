<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\SolicitudAprobada;

#[UseFactory(NoAprobadoFactory::class)]
class NoAprobado extends Model
{
    use SoftDeletes, HasFactory;

    public function Administrador(): BelongsTo
    {
        return $this->belongsTo(Administrador::class);
    }

}

