<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'barber_id',
        'services_id',
        'customer_id',
        'date',
        'start_time',
        'end_time',
        'total_price',
        'appointment_code'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate a random 8-character string
            $appointment_code = Str::random(8);
            
            // Set the 'appointment_code' attribute on the model
            $model->attributes['appointment_code'] = $appointment_code;
        });
    }

    public function barber(){
        return $this->belongsTo(barber::class, 'barber_id');
    }

    public function customer(){
        return $this->belongsTo(customer::class, 'customer_id');
    }

    public function services()
    {
        return $this->belongsToMany(Services::class, 'appointment_services');
    }

    public function appointment_services(){
        return $this->hasMany(appointment_services::class);
    }
}
