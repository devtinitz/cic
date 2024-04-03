<?php

namespace App\Models;

use App\Models\Employe;
use App\Models\Scopes\Searchable;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Presencecic extends Model
{
    use HasFactory;

    //protected $primaryKey = 'employe_id';

    protected $fillable = [
        'employe_id',
        'authDateTime',
        'authDate',
        'authTime',
        'direction',
        'deviceName',
        'deviceSN',
        'personName',
        'cardNo'
    ];

    //
    public function employe()
    {
        return $this->belongsTo(Employe::class, 'employe_id', 'id');
    }

    public function firstScan(){
        return 'ok';
    }

    public function scan(){
        return Presencecic::select(
            'authDate',
            DB::raw('MIN(authDateTime) as first_scan'),
            DB::raw('MAX(authDateTime) as last_scan'),
            'employe_id',
        )
        ->where('authDate', $this->authDate)
        ->where('employe_id', $this->employe_id)
        ->first();
    }
}
