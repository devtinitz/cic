<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'siege_id', 'debut', 'fin', 'jours', 'created_by'
    ];

    public function siege(){
        return $this->belongsTo(Siege::class, 'sieges_id');
    }
}
