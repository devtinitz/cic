<?php
namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

use App\Models\Setting;
use App\Models\Presence;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
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

        $presences = Presence::whereHas('employe')->whereYear('date', date('Y'))->get();

        $days = ['1', '2', '3', '4', '5', '6', '7'];
        $mois = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];

        //Pour les presences de la semaine
        $k = 0;
        $q = [];
        foreach ($days as $key => $value) {
            foreach ($presences as $p){
                if (Carbon::parse($p->date)->dayOfWeek == $value && (Carbon::parse($p->date) >= $weekStartDate && Carbon::parse($p->date) <= $weekEndDate)) {
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
                if (date('m', strtotime($p->date)) == $value) {
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
