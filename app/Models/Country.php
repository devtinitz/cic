<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //

    protected $fillable = [
        'code','name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function sieges(){
        return $this->hasMany(Siege::class);
    }
}
