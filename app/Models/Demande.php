<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Demande extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'description',
        'debut',
        'fin',
        'fichier',
        'statut',
        'created_by',
        'employes_id',
        'type_demande_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'debut' => 'datetime',
        'fin' => 'date',
    ];

    public function employes()
    {
        return $this->belongsTo(Employe::class);
    }

    public function typeDemande()
    {
        return $this->belongsTo(TypeDemande::class);
    }
}
