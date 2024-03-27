<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model{

    protected $fillable = [
        'civilite',
        'firstname',
        'lastname',
        'adresse',
        'email',
        'contact',
        'poste',
        'matricule',
        'cnps',
        'type_paiement',
        'type_contrat',
        'avatar',
        'piecerecto',
        'pieceverso',
        's_matrimoniale',
        'nb_enfant',
        'nb_part',
        'salaire',
        'created_by',
        'debut',
        'fin',
        'anciennete',
        'departement_id',
        'siege_id',
        'service_id',
        'person_id',
        'status'
    ];

    public function hasSiege(){
        return $this->belongsTo(Siege::class, 'siege_id');
    }

    public function siege(){
        return $this->hasOne(Siege::class, 'employe_id');
    }

    public function agence(){
        return $this->belongsTo(Agence::class, 'agence_id');
    }

    public function service(){
        return $this->belongsTo(Service::class, 'service_id');
    }

    public static function matricule() {

        $id = (Employe::orderBy('id','desc')->first()->id?? 0) + 1;

        return str_pad($id, 4, '0', STR_PAD_LEFT);

    }



    /*function static de calcul de code part

        valeur d'entree : Situation matrimoniale , Nombre d'enfant

    */

    public static function codepart($situationmatrimoniale, $nbenfant){
        $nbpart = 1;
        if($situationmatrimoniale == "Célibataire"){
            $nbpart = 1 + ($nbenfant  / 2);
        }else{
            $nbpart = 2 + ($nbenfant  / 2);
        }
        return $nbpart;
    }



    public static function anciennete($debut){
        if ($debut){
            $anneeaujourdhui = Carbon::now()->format('Y');
            $anneedebut = date('Y', strtotime($debut));
            $anciennete = $anneeaujourdhui - $anneedebut;

            return $anciennete;
        }else{
            return null;
        }

    }

    public function departement(){
        return $this->belongsTo(Departement::class, 'departement_id', 'id');
    }

    public function permissions(){
        return $this->hasMany(Permission::class, 'employe_id', 'id');
    }

    public function presences(){
        return $this->hasMany(Presencecic::class, 'employe_id', 'id');
    }



}

