<?php

namespace App\Models;

use App\Models\Employe;
use App\Models\Scopes\Searchable;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
