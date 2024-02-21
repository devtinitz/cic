<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TypeDemande extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['libelle', 'statut', 'created_by'];

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}
