<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbsenceRetard extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['type', 'date', 'statut', 'duree', 'employes_id', 'agence_id'];

    protected $searchableFields = ['*'];

    protected $casts = [
        'date' => 'date',
    ];

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }

    public function allJustifications()
    {
        return $this->hasMany(Justification::class);
    }
	
	public function Agence()
    {
        return $this->belongsTo(Agence::class);
    }
}
