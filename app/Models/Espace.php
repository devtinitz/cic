<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Espace extends Model{

    protected $fillable = [
        'nom',
        'defaut',
        'module_espace',
        'module_espace_lst',
        'module_espace_crte',
        'module_espace_edt',
        'module_espace_dlt',
        'module_user',
        'module_user_lst',
        'module_user_crte',
        'module_user_edt',
        'module_user_dlt',
        'module_departement',
        'module_departement_lst',
        'module_departement_crte',
        'module_departement_edt',
        'module_departement_dlt',
        'module_employe',
        'module_employe_lst',
        'module_employe_crte',
        'module_employe_edt',
        'module_employe_dlt',
        'module_presence',
        'module_presence_lst',
        'module_presence_crte',
        'module_presence_edt',
        'module_presence_dlt',
        'module_permission',
        'module_permission_lst',
        'module_permission_crte',
        'module_permission_edt',
        'module_permission_dlt',
        'module_setting',
        'module_setting_edt',
        'created_by',
    ];

    public function users(){
        return $this->hasMany(User::class);
    }

}

