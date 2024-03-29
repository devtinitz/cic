<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComplementJustications extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['fichier', 'justifications_id'];

    protected $searchableFields = ['*'];

    public function justifications()
    {
        return $this->belongsTo(Justifications::class);
    }
}
