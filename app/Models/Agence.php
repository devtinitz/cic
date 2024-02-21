<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agence extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'siege_id',
        'libelle',
        'country_id',
        'contact',
        'adresse',
        'localisation',
        'horaire',
        'created_by',
        'status',
    ];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function hasSiege(){
        return $this->hasOne(Siege::class, 'agence_id', 'id');
    }

    public function allNoteServices()
    {
        return $this->hasMany(NoteServices::class);
    }

    public function allRapportMissions()
    {
        return $this->hasMany(RapportMissions::class);
    }

    public function allPermutations()
    {
        return $this->hasMany(Permutations::class);
    }

    public function allEquipements()
    {
        return $this->hasMany(Equipements::class);
    }

    public function allEmployes()
    {
        return $this->hasMany(Employe::class);
    }

    public function siege()
    {
        return $this->belongsTo(Siege::class);
    }

    public function secteur()
    {
        return $this->belongsTo(Secteur::class);
    }

    public function allEvenements()
    {
        return $this->hasMany(Evenements::class);
    }

    public function allNotations()
    {
        return $this->hasMany(Notations::class);
    }

    public function allNotifications()
    {
        return $this->hasMany(Notifications::class);
    }

    public function allHotspots()
    {
        return $this->hasMany(Hotspots::class);
    }

    public function allInterims()
    {
        return $this->hasMany(Interims::class);
    }

    public function allFormations()
    {
        return $this->hasMany(Formations::class);
    }
    
    public function pointages()
    {
        return $this->hasMany(Pointages::class,'agence_id');
    }
    
    public function absenceretard()
    {
        return $this->hasMany(AbsenceRetard::class,'agence_id');
    }
}
