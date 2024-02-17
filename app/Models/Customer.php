<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable =[
        'name',
        'phone_number'
    ];

    public function appointment(){
        return $this->hasMany(appointment::class);
    }
}