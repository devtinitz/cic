<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DossierEmploye extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['ref', 'created_by', 'employes_id'];

    protected $searchableFields = ['*'];

    public function employes()
    {
        return $this->belongsTo(Employe::class);
    }

    public function documentDossiers()
    {
        return $this->hasMany(DocumentDossier::class);
    }
}
