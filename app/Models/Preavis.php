<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Preavis extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'type_preavis_id',
        'motif',
        'description',
        'created_by',
        'employes_id',
    ];

    protected $searchableFields = ['*'];

    public function typePreavis()
    {
        return $this->belongsTo(TypePreavis::class);
    }

    public function employes()
    {
        return $this->belongsTo(Employes::class);
    }
}
