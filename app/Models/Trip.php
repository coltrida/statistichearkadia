<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function car()
    {
        return $this->hasOne(Car::class, 'id', 'car_id');
    }

    public function clienttrip()
    {
        return $this->hasMany(ClientTrip::class, 'trip_id', 'id');
    }

    public function getGiornoAttribute()
    {
        return Carbon::parse($this->attributes['giorno'])->format('d-m-Y');
    }

}
