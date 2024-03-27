<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Departement;
use App\Models\Siege;
use App\Models\Service;
use App\Models\Employe;
use App\Models\Presence;
use App\Models\Presencecic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class DepartementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        View::share( 'menu', 'module' );
        View::share( 'sousmenu', 'departement' );
        View::share('menugauche', '');
        View::share('sieges', Siege::where('status', 1)->get());
        View::share('departements', Departement::where('status', 1)->get());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
        $data['title'] = "Liste des départements - ";
        $data['section_title'] = "Liste des départements";
        $data['alldepartements'] = Departement::orderBy('created_at', 'desc')->paginate(50);

        //For activity
        $module = 'Département';
        $action = " a consulté la liste des départements." ;
        Activity::saveActivity($module,$action);

        return view('departements.index', $data);
    }

    public function search(Request $request)
    {
        $departement = Departement::query();
        isset($request->libelle) ? $departement->where('libelle', 'LIKE', '%'.$request->libelle.'%') : '';

        $data['employes'] = $departement->orderBy('created_at', 'desc')
            ->paginate(100)
            ->withQueryString();

        $data['title'] = "Recherche d'un département - ";
        $data['section_title'] = "Recherche d'un département ";

        //For activity
        $module = 'Département';
        $action = " a procédé à la recherche d'un département." ;
        Activity::saveActivity($module,$action);

        return view('departements.index', $data);
    }

    public function create(){
        $data['title'] = "Création d'un département - ";
        $data['section_title'] = "Création d'un département";

        //For activity
        $module = 'Departement';
        $action = " a afficher la vue de creation des départements." ;
        Activity::saveActivity($module,$action);

        return view('departements.create', $data);
    }

    public function store(Request $request){
        $request->validate([
            'libelle' => 'required',
            'siege' => 'required',
        ]);

        if (!$siege = Siege::find($request->siege)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Aucun siège n\'a été trouvé');
            return back();
        }

        $departement = new Departement();
        $departement->libelle = htmlspecialchars($request->libelle);
        $departement->siege_id = $siege->id;
        $departement->status = 1;
        $departement->created_by = Auth::user()->name;
        if ($departement->save()){
            session()->flash('type', 'is-success');
            session()->flash('message', 'Département créé avec succès!');
            return redirect()->route('departements.index');
        }else{
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Une erreur s\'est produite, veuillez rééssayer svp !');
            return back();
        }
    }

    public function edit(Request $request){
        $data['departement'] = Departement::where('id',$request->id)->first();
        if(!$data['departement']){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Département introuvable!');
            return back();
        }

        //For activity
        $module = 'Département';
        $action = " a affiché la page de modification d'un département";
        Activity::saveActivity($module,$action);

        $data['title'] = "Modifier un département - ";
        $data['section_title'] = "Modifier un département";
        return view('departements.edit', $data);
    }

    public function show(Request $request){
        $data['departement'] = Departement::where('id',$request->id)->first();
        if(!$data['departement']){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Département introuvable!');
            return back();
        }

        $data['services'] = $data['departement']->services;
        $data['totalService'] = $data['services']->count();
        $data['totalEmploye'] = $data['departement']->employes->count();
        $data['employes'] = Employe::where('departement_id', $data['departement']->id)->paginate(100);

        //For activity
        $module = 'Département';
        $action = " a affiché la page de détail du département {$data['departement']->libelle}";
        Activity::saveActivity($module,$action);

        $data['title'] = "Détails du département {$data['departement']->libelle} - ";
        $data['section_title'] = "Détails du département {$data['departement']->libelle}";
        return view('departements.show', $data);
    }

    public function update(Request $request){
        $request->validate([
            'id' => 'required',
            'libelle' => 'required',
            'siege' => 'required',
            'status' => 'required'
        ]);

        if (!$siege = Siege::find($request->siege)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Aucun siège n\'a été trouvé');
            return back();
        }

        $departement = Departement::find($request->id);
        if (!$departement){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Employé introuvable!');
            return back();
        }

        $departement->libelle = htmlspecialchars($request->libelle);
        $departement->siege_id = $siege->id;
        $departement->status = htmlspecialchars($request->status);
        if ($departement->save()){
            session()->flash('type', 'is-success');
            session()->flash('message', 'Les informations du département ont bien été modifiées avec succès!');
            return redirect()->route('departements.index');
        }else{
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Une erreur s\'est produite, veuillez rééssayer svp !');
            return back();
        }
    }

    public function destroy(Request $request){
        $departement = Departement::where('id', $request->id)->first();
        if(empty($departement)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Erreur département introuvable !');
            return back();
        }


        if ($departement->delete()) {
            //For activity
            $module = 'département';
            $action = " a procédé à la suppression d'un département";
            Activity::saveActivity($module,$action);

            session()->flash('type', 'is-success');
            session()->flash('message', "Le département a été supprimé avec succès!");
            return back();
        }else{
            session()->flash('type', 'is-success');
            session()->flash('message', 'Erreur lors de la suppression du département.');
            return back();
        }
    }

    public function presenceRecap(Request $request){
        if (!$data['departement'] = Departement::find($request->id)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Le département est introuvable.');
            return back();
        }

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
        ->whereHas('employe', function ($q) use ($data){
            $q->where('departement_id', $data['departement']->id);
        })->whereYear('authDate', date('Y'))
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

        $data['title'] = "Récapitulatif de présence du département {$data['departement']->libelle} -";
        $data['section_title'] = "Récapitulatif de présence du département {$data['departement']->libelle}";

        return view('departements.presence', $data);
    }

    public function editState($id) {
        $id = htmlspecialchars($id);
        $departement = Departement::where('id',$id)->first();
        if(!$departement) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Departement introuvable");
            return back();
        }
        $departement->status = $departement->status == 1 ? 0 : 1;
        $departement->save();
        session()->flash('type', 'alert-success');
        session()->flash('message', "Statut du département modifié avec succès");
        //For activity
        $module = 'Sièges';
        $action = " a procédé à la modification du statut du département {$departement->libelle}." ;
        Activity::saveActivity($module,$action);
        return back();
    }

    /********************************************************** Services **********************************************/

    public function indexService(){
        $data['services'] = Service::all();

        $data['title'] = "Liste des services";
        $data['section_title'] = "Liste des services";

        //For activity
        $module = 'Services';
        $action = " a consulté les services." ;
        Activity::saveActivity($module,$action);
        return view('services.index', $data);
    }

    public function createService(){
        //For activity
        $data['title'] = "Créé un service";
        $data['section_title'] = "Créé un service";
        return view('services.create', $data);
    }

    public function storeService(Request $request){
        $request->validate([
            'libelle' => 'required',
            'departement' => 'required'
        ]);

        if(!$departement = Departement::find($request->departement)){
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Aucun département trouvé");
            return back();
        }

        if ($service = Service::create([
            'libelle' => htmlspecialchars($request->libelle),
            'status' => htmlspecialchars($request->status),
            'description' => htmlspecialchars($request->description),
            'departement_id' => $departement->id,
            'status' => 1,
            'created_by' => Auth::user()->name.' '.Auth::user()->prenoms]))
        {
            $module = 'Service';
            $action = " a procédé à la création du type de préavis {$service->libelle}." ;
            Activity::saveActivity($module,$action);

            session()->flash('type', 'alert-success');
            session()->flash('message', "Service enregistré avec succès.");
            return redirect()->route('services.index');
        }else{
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Une erreur s'est produite, veuillez rééssayer svp.");
            return back();
        }
    }

    public function editService(Request $request){
        if(!$data['service'] = Service::find($request->id)){
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Aucun service trouvé");
            return back();
        }

        $data['title'] = "Modifier le service {$data['service']->libelle}";
        $data['section_title'] = "Modifier le service {$data['service']->libelle}";
        return view('services.edit', $data);
    }

    public function updateService(Request $request){
        $request->validate([
            'libelle' => 'required',
            'departement' => 'required'
        ]);

        if(!$service = Service::find($request->id)){
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Aucun type de préavis trouvé");
            return back();
        }

        if(!$departement = Departement::find($request->departement)){
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Aucun département trouvé");
            return back();
        }

        if ($service->update([
            'libelle' => htmlspecialchars($request->libelle),
            'status' => htmlspecialchars($request->status),
            'description' => htmlspecialchars($request->description),
            'departement_id' => $departement->id
        ])){
            $module = 'Type de préavis';
            $action = " a procédé à la modification du service {$service->libelle}." ;
            Activity::saveActivity($module,$action);

            session()->flash('type', 'alert-success');
            session()->flash('message', "Service modifié avec succès.");
            return redirect()->route('services.index');
        }else{
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Une erreur s'est produite, veuillez rééssayer svp.");
            return back();
        }
    }

    public function editStateService($id) {
        $id = htmlspecialchars($id);
        $service = Service::where('id',$id)->first();
        if(!$service) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Service introuvable");
            return back();
        }
        $service->status = $service->status == 1 ? 0 : 1;
        $service->save();

        //For activity
        $module = 'Service';
        $action = " a procédé à la modification du statut du service {$service->libelle}." ;
        Activity::saveActivity($module,$action);
        session()->flash('type', 'alert-success');
        session()->flash('message', "Statut du service modifié avec succès");
        return back();
    }

    public function destroyService(Request $request){
        if($service = Service::find($request->id)){
            $service->delete();

            //For activity
            $module = 'Service';
            $action = " a procédé à la suppression du service {$service->libelle}." ;
            Activity::saveActivity($module,$action);

            session()->flash('type', 'is-success');
            session()->flash('message', 'Le service a bien été supprimé');
            return redirect()->route('services.index');
        }else{
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Aucun service n\'a été trouvé.');
            return redirect()->route('services.index');
        }
    }

    public function getService(Request $request){
        $data['services'] = Service::where('departement_id', $request->id)->get();

        return response()->json($data);
    }
}
