<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\Auth;

use App\Models\User;



class Activity extends Model

{

    //

     use Notifiable;





    protected $fillable = [

        'user_id','module','action','ip','navigator','pays','codepays','url',

    ];





    public function user() {



        return $this->belongsTo(User::class);

    }

    

    public static function saveActivity($module, $action){

        

            

            $activity = new Activity;            

            $activity->user_id = Auth::user()->id;

            $activity->module = $module;

            $activity->action = $action;

            $activity->save();

            //dd($activity);



        return $activity;

    }

}