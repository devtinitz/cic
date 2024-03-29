<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HeureSupplementaires extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'date',
        'debut',
        'fin',
        'duree',
        'created_by',
        'statut',
        'employes_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'date' => 'date',
        'debut' => 'datetime',
        'fin' => 'datetime',
    ];

    public function employes()
    {
        return $this->belongsTo(Employe::class);
    }
}
