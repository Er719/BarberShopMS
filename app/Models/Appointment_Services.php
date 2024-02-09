<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment_Services extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'services_id',
    ];

    public function appointment(){
        return $this->belongsTo(appointment::class, 'appointment_id');
    }

    public function services(){
        return $this->belongsTo(services::class, 'services_id');
    }
}
