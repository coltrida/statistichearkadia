<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presenze extends Model
{
    use HasFactory;

    protected $table = 'presenze';

    public function getGiornoAttribute()
    {
        return Carbon::parse($this->attributes['giorno'])->format('d-m-Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
