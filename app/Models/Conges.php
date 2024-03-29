<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conges extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'debut',
        'fin',
        'created_by',
        'employes_id',
        'type_conges_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'debut' => 'date',
        'fin' => 'date',
    ];

    public function employes()
    {
        return $this->belongsTo(Employe::class);
    }

    public function typeConges()
    {
        return $this->belongsTo(Typeconge::class);
    }
}
