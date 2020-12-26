<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientTrip extends Model
{
    use HasFactory;

    protected $table = 'clients_trips';

    public function ragazzi()
    {
        return $this->hasMany(Client::class, 'id', 'client_id');
    }

    public function trip()
    {
        return $this->hasMany(Trip::class, 'id', 'trip_id');
    }
}
