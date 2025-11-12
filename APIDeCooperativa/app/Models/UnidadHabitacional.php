<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Etapa;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[UseFactory(UnidadHabitacionalFactory::class)]
class UnidadHabitacional extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'unidad_habitacionals';
    
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'phone',       
        'password',
    ];

    public function etapa(): BelongsTo
    {
        return $this->belongsTo(Etapa::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

}
