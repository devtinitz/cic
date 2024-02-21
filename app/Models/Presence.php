<?php

namespace App\Models;

use App\Models\Employe;
use App\Models\Scopes\Searchable;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'personId',
        'name',
        'departement_id',
        'date',
        'statut',
        'checkIn',
        'checkOut',
        'imported_by',
        'created_by'
    ];


    protected $casts = [
        'debut' => 'datetime',
        'fin' => 'datetime',
    ];

    public function getInfo($id){
        $setting = Setting::first();
        $debut_matin = Carbon::parse($setting->debut_matin);
        $fin_soir = Carbon::parse($setting->fin_soir);

        $pointage = Presence::where('id', $id)->firstOrFail();
        $firstPointage = Presence::where(['personId' => $pointage->personId, 'date' => $pointage->date])
                                ->whereBetween('authTime', ['06:00:00', $fin_matin])
                                ->where('direction', 'IN')
                                ->first();

        $lastPointage = Presence::where(['employe_id' => $pointage->employe_id, 'authDate' => $pointage->authDate])
                                ->whereBetween('authTime', [$debut_soir, $fin_soir->addHours(2)])
                                ->where('direction', '!=', 'IN')
                                ->latest()
                                ->first();

        //dd($setting->debut_matin, $setting->fin_matin, $setting->debut_soir, $setting->fin_soir, $firstPointage, $lastPointage);

        return [
            'fisrtPointage' => $firstPointage,
            'lastPointage' => $lastPointage,
        ];
    }

    public static function getEmploye($employeId){
        return Employe::where('id', $employeId)->first();
    }

    public function departement(){
        return $this->belongsTo(Departement::class, 'departement_id');
    }


    public function employe()
    {
        return $this->belongsTo(Employe::class, 'personId', 'id');
    }
    
    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    public function horaires()
    {
        return $this->belongsTo(Horaires::class);
    }
}
