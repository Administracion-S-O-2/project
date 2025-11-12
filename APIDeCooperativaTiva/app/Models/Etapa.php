<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Exceptions\EtapaException;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[UseFactory(EtapaFactory::class)]
class Etapa extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'etapas';

    public function UnidadesHabitacionales(): HasMany
    {
        return $this->hasMany(UnidadHabitacional::class);
    }

}
