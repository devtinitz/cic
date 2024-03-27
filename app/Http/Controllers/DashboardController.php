<?php
namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

use App\Models\Setting;
use App\Models\Presence;
use App\Models\Presencecic;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource    
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware('auth');
        View::share( 'menu', 'dashboard' );
        View::share( 'setting', Setting::first());
    }

    public function index(){

        $data['title'] = "Tableau de bord super admin - ";
        $data['section_title'] = "Tableau de bord";
        $data['user'] = Auth::user();

        $now = Carbon::now();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i:s');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i:s');

        $presences = Presencecic::select(
            'authDate',
            DB::raw('MIN(authDateTime) as first_scan'),
            DB::raw('MAX(authDateTime) as last_scan'),
            'employe_id',
            DB::raw('MAX(deviceName) as deviceName'),
            DB::raw('MAX(personName) as personName'),
        )
        ->whereYear('authDate', date('Y'))
        ->groupBy('authDate', 'employe_id')
        ->get();

        $days = ['1', '2', '3', '4', '5', '6', '7'];
        $mois = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];

        //Pour les presences de la semaine
        $k = 0;
        $q = [];
        foreach ($days as $key => $value) {
            foreach ($presences as $p){
                if (Carbon::parse($p->authDate)->dayOfWeek == $value && (Carbon::parse($p->authDate) >= $weekStartDate && Carbon::parse($p->authDate) <= $weekEndDate)) {
                    $q[$k] = $p;
                    $k++;
                }
            }
            $pres[] = count($q);
            $q = [];
        }

        //Pour les presences du mois
        $l = 0;
        $x = [];
        foreach ($mois as $key => $value) {
            foreach ($presences as $p){
                if (date('m', strtotime($p->authDate)) == $value) {
                    $x[$l] = $p;
                    $l++;
                }
            }
            $presenceMonth [] = count($x);
            $x = [];
        }


        $data['presence_semaine'] = json_encode($pres, JSON_NUMERIC_CHECK);
        $data['presence_mois'] = json_encode($presenceMonth, JSON_NUMERIC_CHECK);

        return view('dashboard',$data);
    }

}
