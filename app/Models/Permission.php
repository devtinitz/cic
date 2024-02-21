<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model{

    protected $fillable = [
        'employe_id', 'motif', 'description', 'status', 'file', 'debut', 'fin', 'created_by', 'typeconge_id'
    ];

    public function employe(){
        return $this->belongsTo(Employe::class, 'employe_id', 'id');
    }

    public function type(){
        return $this->belongsTo(Typeconge::class, 'typeconge_id');
    }
}