<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[UseFactory(UserFactory::class)]
class User extends Persona implements Authenticatable
{
    use Notifiable, SoftDeletes, AuthenticatableTrait, HasFactory;

    public function Comprobantes(): HasMany
    {
        return $this->hasMany(Comprobante::class);
    }

    public function WorkHours(): HasMany
    {
        return $this->hasMany(WorkHours::class);
    }

    public function UnidadHabitacional(): BelongsTo
    {
        return $this->belongsTo(UnidadHabitacional::class);
    }

    public function participantsList(): HasMany
    {
        return $this->hasMany(ParticipantsList::class);
    }

    public function workedHoursThisMonth(){
        $hours = 0;
        return $hours = $this->WorkHours()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('hours');
    }

    public function monthlyPaymentState(){
        return $this->Comprobantes()
            ->where('type', 'Monthly')
            ->where('state', 'Approved')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->exists();
    }

    public function assigne($unidad_id){
        $this->unidad_habitacional_id = $unidad_id;
        $this->save();
    }

    protected $fillable = [
        'name',
        'lastname',
        'email',
        'phone',       
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
