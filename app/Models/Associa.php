<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Associa extends Model
{
    use HasFactory;

    protected $table = 'associa';

    public function client()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function activity()
    {
        return $this->hasOne(Activity::class, 'id', 'activity_id');
    }
}
