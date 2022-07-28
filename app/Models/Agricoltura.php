<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agricoltura extends Model
{
    use HasFactory;

    protected $table = 'agricolturas';
    protected $appends = ['presenza'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'user_id', 'id');
    }

    public function getPresenzaAttribute()
    {
        return $this->tipo == 'P' ? 'Presente' : 'Assente';
    }
}
