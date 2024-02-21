<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use Hash;

class ConfigurationController extends Controller
{
    public function setting()
    {
        return view('install.setting');
    }


    public function configurationSubmit(Request $request)
    {
        try{
            $configurations = $request->validate([
                'companyname' => 'required',
                'companycontact' => 'required|max:20',
                'email' => 'required|email|max:255',
                'localisation' => 'required|max:150',
            ]);

            $configurations['companylogo'] = $request->file('companylogo') ? storeImage($request->companylogo) : '/img/logo-default.jpg';
            $configurations['companycolor'] = htmlspecialchars($request->companycolor);
            $configurations['facebook'] = htmlspecialchars($request->facebook);
            $configurations['twitter'] = htmlspecialchars($request->twitter);
            $configurations['linkedin'] = htmlspecialchars($request->linkedin);
            $configurations['setup_stage'] = '3';
            foreach($configurations as $key => $config){
                Setting::first()->update(
                    [
                        $key => $config
                    ]
                );
            }
            return redirect()->route('install.complete');
        }catch(Exception $e){
            return redirect()
                ->route('install.configuration')
                ->withInput()
                ->withErrors([$e->getMessage()]);
        }
    }
}
