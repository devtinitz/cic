<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\Presence;
use App\Models\Employe;
use App\Models\Departement;
use App\Models\Service;
use App\Exports\PresenceExport;
use App\Imports\PresenceImport;
use App\Jobs\GeneratePdf;
use App\Models\Presencecic;
use App\Models\Setting;
use Illuminate\Support\Facades\Queue;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class PresenceController extends Controller{

    public function __construct()
    {
        $this->middleware('auth')->except('exportToPdf');
        View::share( 'menu', 'Presence' );
        View::share( 'sousmenu', 'presence' );
        View::share('employes', Employe::all());
        View::share('departements', Departement::where('status', 1)->get());
        View::share('services', Service::where('status', 1)->get());
    }

    public function index(){
        $data['title'] = "Liste des pointages - ";
        $data['section_title'] = "Liste des pointages";
        $data['presences'] = Presencecic::orderByDesc('authDate')->paginate(100);

        //For activity
        $module = 'Presence';
        $action = " a consulté la liste des pointages." ;
        Activity::saveActivity($module,$action);

        return view('presences.index', $data);
    }

    public function presence(){
        $data['title'] = "Liste des pointages - ";
        $data['section_title'] = "Liste des présences";
        $data['presences'] = DB::table('presences')
            ->select('presences.*')
            ->whereIn('id', function($query){
                $query->select(DB::raw('MIN(id)'))
                    ->from('presences')
                    ->groupBy('employe_id', 'authDate');
            })
            ->orderByDesc('date')
            ->paginate(100);

        //For activity
        $module = 'Presence';
        $action = " a consulté la liste des présences." ;
        Activity::saveActivity($module,$action);

        return view('presences.liste', $data);
    }

    public function pointage(){
        $data['title'] = "Liste des pointages - ";
        $data['section_title'] = "Liste des pointages";
        $data['presences'] = Presencecic::select(
                                'authDate',
                                DB::raw('MIN(authDateTime) as first_scan'),
                                DB::raw('MAX(authDateTime) as last_scan'),
                                'employe_id',
                                DB::raw('MAX(deviceName) as deviceName'),
                                DB::raw('MAX(personName) as personName'),
                            )
                            ->groupBy('authDate', 'employe_id')
                            ->orderByDesc('last_scan')
                            ->paginate(100);


        //For activity
        $module = 'Presence';
        $action = " a consulté la liste des présences." ;
        Activity::saveActivity($module,$action);

        return view('presences.presence', $data);
    }

    public function search(Request $request){
        $presence = Presencecic::when(!empty($request->employe), fn($q) => $q->where('personId', $request->employe))
            ->when(!empty($request->departement), fn($q) => $q->whereHas('employe', fn($q) => $q->where('service_id', $request->departement)))
            ->when(!empty($request->service), fn($q) => $q->whereHas('employe', fn($q) => $q->where('service_id', $request->service)))
            ->when(!empty($request->debut), fn($q) => $q->whereDate('authDate', '>=', $request->debut))
            ->when(!empty($request->fin), fn($q) => $q->whereDate('authDate', '>=', $request->fin))
            ->select(
                'employe_id',
                'authDate',
                DB::raw('MIN(authDateTime) as first_scan'),
                DB::raw('MAX(authDateTime) as last_scan'),
                'employe_id',
                DB::raw('MAX(deviceName) as deviceName'),
                DB::raw('MAX(personName) as personName'),
            )
            ->groupBy('authDate', 'employe_id')
            ->orderByDesc('last_scan');

        //Exportation de donnees en pdf
        if ($request->export){
            $data['presences'] = $presence->cursor();
            //dd($data);
            $data['total'] = $data['presences']->count();
            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->setPaper('a4', 'landscape')
                ->loadView('presences.pdf', $data);
            $name = "presences.pdf";
            return $pdf->stream($name);
        }

        //Exportation de donnees en excel
        if ($request->excel){
            try {
                return Excel::download(new PresenceExport($presence->cursor()), 'presences.xlsx');
            } catch (\Exception $e) {
                // Affichez l'erreur ou enregistrez-la dans les logs
                dd($e->getMessage());
            }
        }

        $data['presences'] = $presence->paginate(100)->withQueryString();

        //For activity
        $module = 'Presence';
        $action = " a éffectué une recherche dans la liste des pointages." ;
        Activity::saveActivity($module,$action);

        $data['title'] = "Liste des pointages - ";
        $data['section_title'] = "Résultats de la recherche";
        return view('presences.presence', $data);
    }

    public function import(Request $request){
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls'
        ]);

        $row = Excel::toArray(new PresenceImport,request()->file('file'));

        //dd($row);
        for ($i=2; $i < count($row[0]) ; $i++) { 
            //Checking employe
            $employe = Employe::where('person_id', $row[0][$i][0])->first();
            if (!empty($employe) && !strtotime($row[0][$i][0])) {
                $presence = new Presence();
                $presence->personId = htmlspecialchars($row[0][$i][0]);
                $presence->name = ucfirst($employe->firstname).' '.ucfirst($employe->lastname);

                //Recuperation du departement
                $departement = Departement::firstOrCreate(
                    ['libelle' => ucfirst($row[0][$i][2])],
                    [
                        'libelle' => ucfirst($row[0][$i][2]), 
                        'created_by' => ucfirst(auth()->user()->name).' '.ucfirst(auth()->user()->prenoms),
                        'siege_id' => 1,
                        'statut' => 1
                    ]
                );                

                $presence->departement_id = $departement->id;
                
                //On verifie si la valeur est une date
                if (!strtotime($row[0][$i][3])) {
                    //Si la date existe deja
                    $presence->date = htmlspecialchars($row[0][$i][4]);
                    $presence->statut = htmlspecialchars($row[0][$i][7]);
                    $presence->checkIn = $row[0][$i][8] !== '-' ? htmlspecialchars($row[0][$i][8]) : null;
                    $presence->checkOut = $row[0][$i][8] !== '-' ? htmlspecialchars($row[0][$i][8]) : null;
                }else{
                    $presence->date = htmlspecialchars($row[0][$i][3]);
                    $presence->statut = htmlspecialchars($row[0][$i][6]);
                    $presence->checkIn = $row[0][$i][7] !== '-' ? htmlspecialchars($row[0][$i][7]) : null;
                    $presence->checkOut = $row[0][$i][8] !== '-' ? htmlspecialchars($row[0][$i][8]) : null;
                }
                
                $presence->imported_by = ucfirst(auth()->user()->name).' '.ucfirst(auth()->user()->prenoms);
                $presence->created_by = ucfirst(auth()->user()->name).' '.ucfirst(auth()->user()->prenoms);
                $presence->save();
            
            }
        }

        //For activity
        $module = 'Presence';
        $action = " a importé la liste des pointages en fichier excel." ;
        Activity::saveActivity($module,$action);

        session()->flash('type', 'is-success');
        session()->flash('message', 'Fichier importé avec succès!');
 
         return back();
    }


    //Exportation en pdf
    public function exportToPdf(Request $request){
        
        $presences = Presencecic::when(!empty($request->employe), fn($q) => $q->where('personId', $request->employe))
            ->when(!empty($request->departement), fn($q) => $q->whereHas('employe', fn($q) => $q->where('service_id', $request->departement)))
            ->when(!empty($request->service), fn($q) => $q->whereHas('employe', fn($q) => $q->where('service_id', $request->service)))
            ->when(!empty($request->debut), fn($q) => $q->whereDate('authDate', '>=', $request->debut))
            ->when(!empty($request->fin), fn($q) => $q->whereDate('authDate', '>=', $request->fin))
            ->select(
                'id',
                'authDate',
                DB::raw('MIN(authDateTime) as first_scan'),
                DB::raw('MAX(authDateTime) as last_scan'),
                'employe_id',
                DB::raw('MAX(deviceName) as deviceName'),
                DB::raw('MAX(personName) as personName'),
            )
            ->groupBy('authDate', 'id')
            ->orderByDesc('last_scan')
            ->get();


        $setting = Setting::first();        
        //Mise en file d'attente
        GeneratePdf::dispatch($presences, $setting);
        
        return response()->json([
            'success' => true,
        ]);
    }

}