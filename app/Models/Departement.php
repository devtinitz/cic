<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model{

    protected $fillable = [
      'libelle', 'status', 'created_by'
    ];

    public function employes(){
        return $this->hasMany(Employe::class, 'departement_id', 'id');
    }

    public function siege(){
        return $this->belongsTo(Siege::class);
    }

    public function services(){
        return $this->hasMany(Service::class);
    }

    public function presence(){
        return $this->hasMany(Presence::class);
    }
}