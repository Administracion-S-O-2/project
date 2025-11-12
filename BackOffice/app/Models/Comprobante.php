<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[UseFactory(ComprobanteFactory::class)]
class Comprobante extends Model
{
    use SoftDeletes, HasFactory;

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
       
    public function Administrador(): BelongsTo
    {
        return $this->belongsTo(Administrador::class, 'administrador_id');
    }

}
