<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Typeconge extends Model
{
    use SoftDeletes;

    protected $fillable = ['libelle', 'status', 'created_by'];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'typeconge_id', 'id');
    }
}
