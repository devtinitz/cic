<?php

namespace App\Models;

//use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fonctions extends Model
{
    use SoftDeletes;
    use HasFactory;
    //use Searchable;

    protected $fillable = ['libelle', 'description','status', 'siege_id'];

    protected $searchableFields = ['*'];

    public function siege()
    {
        return $this->belongsTo(Siege::class);
    }
    
    public function employes()
    {
        return $this->hasMany(Employe::class,'fonction_id','id');
    }
}
