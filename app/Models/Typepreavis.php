<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Typepreavis extends Model
{
    use SoftDeletes;

    protected $fillable = ['libelle', 'status', 'created_by'];

    public function allPreavis()
    {
        return $this->hasMany(Preavis::class);
    }
}
