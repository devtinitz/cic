<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Convocations extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'date',
        'statut',
        'created_by',
        'verdict',
        'employes_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'date' => 'date',
    ];

    public function employes()
    {
        return $this->belongsTo(Employe::class);
    }
}
