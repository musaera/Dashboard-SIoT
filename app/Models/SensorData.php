<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    protected $fillable = ['topic', 'temperature', 'humidity', 'buzzer'];
}
