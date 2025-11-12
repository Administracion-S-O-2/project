<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\ComprobanteException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Comprobante extends Model
{
    use HasFactory, SoftDeletes;

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
