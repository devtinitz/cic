<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        View::share( 'users', User::all());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function logs(Request $request)
    {
        $data['page_title'] = "Liste des actions menées";
        $data['title'] = "Liste des actions menées";
        $data['section_title'] = "Gestion des actions";
        $data['menu'] = "logs";
        $data['menuProfile'] = "Historique d'activités";
        $data['logs'] = Activity::orderBy('created_at','DESC')->paginate(120);

        //For activity
        $module = 'Dashboard';
        $action = '  a consulté la liste des actions menées.';
        Activity::saveActivity($module,$action);

        return view('logs.index', $data);
    }


    public function logSearch(Request $request)
    {
        $data['page_title'] = "Liste des actions menées - ";
        $data['title'] = "Liste des actions menées - ";
        $data['section_title'] = "Gestion des actions";
        $data['menu'] = "logs";
        $data['menuProfile'] = "Historique d'activités";
        $user = htmlspecialchars($request->user);
        $module = htmlspecialchars($request->module);
        $action = htmlspecialchars($request->action);
        $deb = $request->from != "" ? date('Y-m-d',strtotime( htmlspecialchars($request->from)))  : "2021-01-01" ;
        $fin = $request->to != "" ? date('Y-m-d',strtotime(htmlspecialchars($request->to)))  : date('Y-m-d',strtotime(Carbon::today()));

        $userComparator = $user == 'all' ? '!=' : '=';

        $data['logs'] = Activity::where('user_id', $userComparator ,$user)
            ->where('module', 'like', '%' . $module . '%')
            ->where('action', 'like', '%' . $action . '%')
            ->whereDate('created_at','>=', $deb)
            ->whereDate('created_at','<=', $fin)
            ->orderBy('id','desc')
            ->paginate(500);

        $data['logs']->appends([
            'user' => $request->user,
            'module' => $request->module,
            'action' => $request->action,
            'deb' => $request->from,
            'datefin' => $request->to,
        ]);

        //For activity
        $module = 'Dashboard';
        $action = ' a effectué une recherche avancée sur la liste des actions menées.';
        Activity::saveActivity($module,$action);

        return view('logs.index', $data);
    }
}
