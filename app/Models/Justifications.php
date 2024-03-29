<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Justifications extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'message',
        'statut',
        'created_by',
        'absence_retard_id',
    ];

    protected $searchableFields = ['*'];

    public function absenceRetard()
    {
        return $this->belongsTo(AbsenceRetard::class);
    }

    public function allComplementJustications()
    {
        return $this->hasMany(ComplementJustications::class);
    }
}
