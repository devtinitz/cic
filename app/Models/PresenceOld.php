<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model{

    protected $fillable = [
        'employe_id', 'date', 'created_by'
    ];

    public function employe(){
        return $this->belongsTo(Employe::class, 'employe_id', 'id');
    }
}