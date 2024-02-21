<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Setting;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Artisan;

class AccountController extends Controller
{
    public function account(){
        $data['countries'] = Country::all();
        return view('install.account', $data);
    }

    /*
     * Fonction de traitement de la création de l'utilisateur
     * **/
    public function accountSubmit(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required',
                'name' => 'required',
                'prenoms' => 'required',
                'email' => 'required|email',
                'pays' => 'required',
                'ville' => 'required',
                'adresse' => 'required',
                'fonction' => 'required',
                'password' => 'required|min:6',
            ]);

            User::updateOrCreate([
                'email' => $request->email,
            ],[
                'username' => htmlspecialchars($request->username),
                'name' => htmlspecialchars($request->name),
                'prenoms' => htmlspecialchars($request->prenoms),
                'email' => htmlspecialchars($request->email),
                'country_id' => htmlspecialchars($request->pays),
                'ville' => htmlspecialchars($request->ville),
                'adresse' => htmlspecialchars($request->adresse),
                'fonction' => htmlspecialchars($request->fonction),
                'password' => Hash::make($request->password),
                'espace_id' => 1,
                'role' => 'admin',
                'created_by' => 'admin'
            ]);

            Setting::firstOrFail()->update(['setup_stage' => '2']);
            return redirect()->route('install.configuration');
        } catch (Exception $e) {
            return redirect()->route('install.account')->withInput()->withErrors([$e->getMessage()]);
        }
    }
}
