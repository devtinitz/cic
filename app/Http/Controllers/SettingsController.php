<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon;
use App\Models\Setting;
use App\Models\Activity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        View::share( 'menu', 'parametrage' );
        View::share( 'sousmenu', 'setting' );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $data['title'] = "Configuration - ";
        $data['section_title'] = "Configuration";
        $data['setting'] = Setting::first();
        //dd($data['setting']);

        //For activity
        $module = 'Setting';
        $action = " a consulté la page de configuration générale." ;
        Activity::saveActivity($module,$action);

        return view('settings.index', $data);
    }

    public function updatesettings(Request $request){

        $validate = Validator::make($request->all(), [
            'companyname' => ['required', 'max:255'],
            'localisation' => 'required',
            'companycolor' => 'required',
        ]);

        if($validate->fails()) {
            return back()->withErrors($validate->errors());
        }
        $settings = Setting::first();
        $settings->companyname = htmlspecialchars($request->companyname);
        $settings->localisation = htmlspecialchars($request->localisation);
        $settings->companycolor = htmlspecialchars($request->companycolor);
        $settings->companycontact = htmlspecialchars($request->companycontact);
        $settings->email = htmlspecialchars($request->email);
        $settings->twitter = htmlspecialchars($request->twitter);
        $settings->facebook = htmlspecialchars($request->facebook);
        $settings->linkedin = htmlspecialchars($request->linkedin);
        $settings->debut_matin = htmlspecialchars($request->debut_matin);
        $settings->fin_matin = htmlspecialchars($request->fin_matin);
        $settings->debut_pause = htmlspecialchars($request->debut_pause);
        $settings->fin_pause = htmlspecialchars($request->fin_pause);
        $settings->debut_soir = htmlspecialchars($request->debut_soir);
        $settings->fin_soir = htmlspecialchars($request->fin_soir);

        //Enregistrement de l'image du logo
        if(file_exists($request->file('logo'))) {
            $settings->companylogo = storeImage($request->logo);
        }

        if($settings->save()){

            //For activity
            $module = 'Setting';
            $action = " a procédé à la mise à jour des informations de configuration générale." ;
            Activity::saveActivity($module,$action);

            session()->flash('type', 'is-success');
            session()->flash('message', 'Paramétrage enregistré avec succès');
            return back();
        }else{
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Erreur lors de l\'enregistrement du parametrage');
            return back();
        }
    }

}
