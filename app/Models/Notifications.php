<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notifications extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'libelle',
        'message',
        'created_by',
        'siege_id',
        'agence_id',
    ];

    protected $searchableFields = ['*'];

    public function siege()
    {
        return $this->belongsTo(Siege::class);
    }

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }
}
