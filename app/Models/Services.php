<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class services extends Model
{   
    protected $fillable = [
        'name',
        'price',
        'duration'
    ];

    use HasFactory;

    public function appointments()
    {
        return $this->belongsToMany(Appointment::class, 'appointment_services');
    }
    
    public function appointment_services(){
        return $this->hasMany(appointment_services::class);
    }
}
