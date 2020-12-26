<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'activities_clients', 'activity_id', 'id');
    }

    public function clientsAssocia()
    {
        return $this->hasMany(Associa::class, 'activity_id', 'id');
    }
}
