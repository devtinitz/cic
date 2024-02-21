<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use SoftDeletes;
    use HasFactory;
    //use Searchable;

    protected $fillable = [
        'libelle',
        'created_by',
        'departement_id',
        'siege_id',
        'status',
    ];

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
    
    public function siege()
    {
        return $this->belongsTo(Siege::class,'siege_id');
    }

    public function employes(){
        return $this->hasMany(Employe::class, 'service_id');
    }
}
