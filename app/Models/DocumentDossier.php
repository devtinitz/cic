<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentDossier extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Searchable;

    protected $fillable = ['created_by', 'dossier_employe_id'];

    protected $searchableFields = ['*'];

    public function dossierEmploye()
    {
        return $this->belongsTo(DossierEmploye::class);
    }
}
