<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barber extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'image_path'
    ];

    public function appointment(){
        return $this->hasMany(appointment::class);
    }
}
