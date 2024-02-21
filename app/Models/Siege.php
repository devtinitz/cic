<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siege extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'libelle',
        'logo',
        'employe_id',
        'agence_id',
        'created_by',        
        'statutvalidation',
        'horaire',
        'status',
        'validate_by',
        'validate_at',
        'country_id',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function employe(){
        return $this->belongsTo(Employe::class);
    }

    public function allEmploye(){
        return $this->hasMany(Employe::class, 'siege_id');
    }

    public function allFeries()
    {
        return $this->hasMany(Feries::class);
    }

    public function allEvenements()
    {
        return $this->hasMany(Evenements::class);
    }

    public function allFonctions()
    {
        return $this->hasMany(Fonctions::class);
    }

    public function allGrades()
    {
        return $this->hasMany(Grades::class);
    }

    public function allNoteServices()
    {
        return $this->hasMany(NoteServices::class);
    }

    public function allDepartements()
    {
        return $this->hasMany(Departement::class);
    }

    public function agences()
    {
        return $this->hasMany(Agence::class);
    }

    public function hasAgence(){
        return $this->belongsTo(Agence::class, 'agence_id', 'id');
    }

    public function allNotifications()
    {
        return $this->hasMany(Notifications::class);
    }

    public function secteurs()
    {
        return $this->hasMany(Secteur::class);
    }

    public function allHoraires()
    {
        return $this->hasMany(Horaire::class);
    }

    public function allFormations()
    {
        return $this->hasMany(Formations::class);
    }
    
    public function allUsers()
    {
        return $this->hasMany(User::class);
    }
    
    public function services()
    {
        return $this->hasMany(Services::class);
    }
    
   /* public function allUsers()
    {
        return $this->hasMany('App\Models\User', 'siege_id', 'id');
    }*/
}
