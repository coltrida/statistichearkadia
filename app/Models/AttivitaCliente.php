<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttivitaCliente extends Model
{
    use HasFactory;

    protected $table = 'activities_clients';

    public function client()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function activity()
    {
        return $this->hasOne(Activity::class, 'id', 'activity_id');
    }

    public function getGiornoAttribute()
    {
        return Carbon::parse($this->attributes['giorno'])->format('d-m-Y');
    }
}
