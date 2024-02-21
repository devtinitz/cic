<?php



namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Setting extends Model
{
//    Etape d'installation
//    setup_stage = 0 => Debut d'installation
//    setup_stage = 1
    protected $fillable=[
        'companyname',
        'companylogo',
        'companycontact',
        'companycolor',
        'facebook',
        'twitter',
        'linkedin',
        'email',
        'localisation',
        'debut_matin',
        'fin_matin',
        'debut_pause',
        'fin_pause',
        'debut_soir',
        'fin_soir',
        'setup_complete',
        'setup_stage',
    ];

}

