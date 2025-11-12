<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

#[UseFactory(WorkHoursFactory::class)]
class WorkHours extends Model
{
    use HasFactory;
    
    protected $table = 'work_hours';

    protected $fillable = [
        'user_id',
        'date',
        'hours'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
