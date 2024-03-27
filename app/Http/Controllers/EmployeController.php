<?php

namespace App\Http\Controllers;
//use App\\ImportUser;
use App\Imports\EmployerImport;
use App\Models\Activity;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Employe;
use App\Models\Departement;
use App\Models\Agence;
use App\Models\Service;
use App\Models\Siege;
use App\Models\Presence;
use App\Models\Presencecic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use \Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EmployeController extends Controller
{
    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        View::share( 'menu', 'module' );
        View::share( 'sousmenu', 'employé' );
        View::share('menugauche', '');
        View::share('employes', Employe::orderBy('firstname')->get());
        View::share('matricule', Employe::matricule());
        View::share('departements', Departement::where('status', 1)->get());
        View::share('agences', Agence::where('status', 1)->get());
        View::share('services', Service::where('status', 1)->get());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
        $data['title'] = "Liste des employés - ";
        $data['section_title'] = "Liste des employés";
        $data['employes'] = Employe::orderBy('firstname')->paginate(100);

        //For activity
        $module = 'Paiement';
        $action = " a consulté la liste des employés." ;
        Activity::saveActivity($module,$action);

        return view('employes.index', $data);
    }

    public function search(Request $request)
    {
        $employe = Employe::query();
        isset($request->service) ? $employe->where('service_id', $request->service) : '';
        isset($request->departement) ? $employe->where('departement_id', $request->departement) : '';
        isset($request->matricule) ? $employe->where('matricule', $request->matricule) : '';
        isset($request->nom) ? $employe->where('firstname', 'LIKE', '%'.$request->nom.'%') : '';
        isset($request->prenoms) ? $employe->where('lastname', 'LIKE', '%'.$request->prenoms.'%') : '';
        isset($request->poste) ? $employe->where('poste', 'LIKE', '%'.$request->poste.'%') : '';
        $request->s_matrimoniale != 'all' ? $employe->where('s_matrimoniale', $request->s_matrimoniale) : '';
        $request->type_contrat != 'all' ? $employe->where('type_contrat', $request->type_contrat) : '';

        $data['employes'] = $employe->orderBy('firstname')
            ->paginate(100)
            ->appends([
                'matricule' => $request->matricule,
                'nom' => $request->nom,
                'prenoms' => $request->prenoms,
                's_matrimoniale' => $request->s_matrimoniale,
                'type_contrat' => $request->type_contrat,
            ]);

        $data['title'] = "Recherche d'un employé - ";
        $data['section_title'] = "Recherche d'un employé ";

        //For activity
        $module = 'Paiement';
        $action = " a procédé à la recherche d'un employé." ;
        Activity::saveActivity($module,$action);

        return view('employes.index', $data);
    }

    public function create(){
        $data['title'] = "Création d'un employé - ";
        $data['section_title'] = "Création d'un employé";

        //For activity
        $module = 'Paiement';
        $action = " a afficher la vue de creation des employés." ;
        Activity::saveActivity($module,$action);

        return view('employes.create', $data);
    }

    public function store(Request $request){
        $request->validate([
            'civilite' => 'required',
            'matricule' => 'required',
            'nom' => 'required',
            'prenoms' => 'required',
            'poste' => 'required',
            'adresse' => 'nullable',
            'email' => 'nullable',
            'contact' => 'nullable',
            'photo' => 'nullable',
            'cnps' => 'nullable',
            'salaire' => 'nullable',
            'nbenfant' => 'required',
            's_matrimoniale' => 'required',
            'type_contrat' => 'required',
            'piecerecto' => 'nullable',
            'pieceverso' => 'nullable',
            'service' => 'nullable',
            'debut' => 'nullable',
            'departement' => 'nullable|integer',
            'agence' => 'nullable|integer'
        ]);

        $employe = new Employe();
        //Enregistrement de la photo
        if ($request->photo){
            $photo = htmlspecialchars($request->nom).time(). '.'. $request->photo->extension();
            $annee = date('Y');
            $mois = date('m');
            $lien = 'employes/'.$annee.'/'.$mois;
            $request->photo->move($lien, $photo);
            $employe->avatar = URL::to('/') .'/'. $lien .'/'. $photo;
        }
        //Enregistrement des pieces
        if ($request->piecerecto){
            $piece = htmlspecialchars($request->nom).time(). '.'. $request->piecerecto->extension();
            $annee = date('Y');
            $mois = date('m');
            $lien = 'employes/'.$annee.'/'.$mois;
            $request->piecerecto->move($lien, $piece);
            $employe->piecerecto = URL::to('/') .'/'. $lien .'/'. $piece;
        }
        if ($request->pieceverso){
            $piece = htmlspecialchars($request->nom).time(). '.'. $request->pieceverso->extension();
            $annee = date('Y');
            $mois = date('m');
            $lien = 'employes/'.$annee.'/'.$mois;
            $request->pieceverso->move($lien, $piece);
            $employe->pieceverso = URL::to('/') .'/'. $lien .'/'. $piece;
        }

        $agence = Agence::find($request->agence);
        $departement = Departement::find($request->departement);
        $service = Service::find($request->service);

        $employe->departement_id = !empty($departement) ? $departement->id : 0;
        $employe->siege_id = !empty($agence) ? $agence->siege_id : 0;
        $employe->agence_id = !empty($agence) ? $agence->id : 0;
        $employe->service_id = !empty($service) ? $service->id : 0;
        $employe->civilite = htmlspecialchars($request->civilite);
        $employe->matricule = htmlspecialchars($request->matricule);
        $employe->firstname = htmlspecialchars($request->nom);
        $employe->lastname = htmlspecialchars($request->prenoms);
        $employe->poste = htmlspecialchars($request->poste);
        $employe->adresse = htmlspecialchars($request->adresse);
        $employe->email = htmlspecialchars($request->email);
        $employe->contact = htmlspecialchars($request->contact);
        $employe->cnps = htmlspecialchars($request->cnps);
        $employe->salaire = htmlspecialchars($request->salaire);
        $employe->nb_enfant = htmlspecialchars($request->nbenfant);
        $employe->s_matrimoniale = htmlspecialchars($request->s_matrimoniale);
        $employe->debut = htmlspecialchars($request->debut);
        $employe->nb_part = Employe::codepart($request->s_matrimoniale, $request->nbenfant);
        $employe->anciennete = Employe::anciennete($request->debut);
        $employe->type_contrat =  htmlspecialchars($request->type_contrat);
        $employe->created_by = Auth::user()->name;
        if ($employe->save()){
            session()->flash('type', 'is-success');
            session()->flash('message', 'Employé créé avec succès!');
            return redirect()->route('employes.index');
        }else{
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Une erreur s\'est produite, veuillez rééssayer svp !');
            return back();
        }
    }

    public function edit(Request $request){
        $data['employe'] = Employe::where('id',$request->id)->first();
        if(!$data['employe']){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Employé introuvable!');
            return back();
        }

        //For activity
        $module = 'Paiement';
        $action = " a affiché la page de modification de l'employé :".$data['employe']->firstname." ".$data['employe']->lastname."." ;
        Activity::saveActivity($module,$action);

        $data['title'] = "Modifier un employé - ";
        $data['section_title'] = "Modifier un employé";
        return view('employes.edit', $data);
    }

    public function update(Request $request){
        $request->validate([
            'civilite' => 'required',
            'matricule' => 'required',
            'nom' => 'required',
            'prenoms' => 'required',
            'adresse' => 'nullable',
            'email' => 'nullable',
            'contact' => 'nullable',
            'photo' => 'nullable',
            'cnps' => 'nullable',
            'salaire' => 'nullable',
            'nbenfant' => 'required',
            's_matrimoniale' => 'required',
            'type_contrat' => 'required',
            'piecerecto' => 'nullable',
            'pieceverso' => 'nullable',
            'poste' => 'required',
            'debut' => 'nullable',
            'fin' => 'nullable',
            'id' => 'required',
        ]);

        $employe = Employe::find($request->id);
        if (!$employe){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Employé introuvable!');
            return back();
        }

//        if (!$departement = Departement::find($request->departement)){
//            session()->flash('type', 'is-danger');
//            session()->flash('message', 'Aucun département trouvé');
//            return back();
//        }

        //Enregistrement de la photo
        if ($request->photo){
            $photo = htmlspecialchars($request->nom).time(). '.'. $request->photo->extension();
            $annee = date('Y');
            $mois = date('m');
            $lien = 'employes/'.$annee.'/'.$mois;
            $request->photo->move($lien, $photo);
            $employe->avatar = URL::to('/') .'/'. $lien .'/'. $photo;
        }
        //Enregistrement des pieces
        if ($request->piecerecto){
            $piece = htmlspecialchars($request->nom).time(). '.'. $request->piecerecto->extension();
            $annee = date('Y');
            $mois = date('m');
            $lien = 'employes/'.$annee.'/'.$mois;
            $request->piecerecto->move($lien, $piece);
            $employe->piecerecto = URL::to('/') .'/'. $lien .'/'. $piece;
        }
        if ($request->pieceverso){
            $piece = htmlspecialchars($request->nom).time(). '.'. $request->pieceverso->extension();
            $annee = date('Y');
            $mois = date('m');
            $lien = 'employes/'.$annee.'/'.$mois;
            $request->pieceverso->move($lien, $piece);
            $employe->pieceverso = URL::to('/') .'/'. $lien .'/'. $piece;
        }

        $agence = Agence::find($request->agence);
        $departement = Departement::find($request->departement);
        $service = Service::find($request->service);

        $employe->departement_id = !empty($departement) ? $departement->id : $employe->departement_id;
        $employe->siege_id = !empty($agence) ? $agence->siege_id : $employe->siege_id;
        $employe->agence_id = !empty($agence) ? $agence->id : $employe->agence_id;
        $employe->service_id = !empty($service) ? $service->id : $employe->service_id;
        $employe->civilite = htmlspecialchars($request->civilite);
        $employe->matricule = htmlspecialchars($request->matricule);
        $employe->firstname = htmlspecialchars($request->nom);
        $employe->lastname = htmlspecialchars($request->prenoms);
        $employe->poste = htmlspecialchars($request->poste);
        $employe->adresse = htmlspecialchars($request->adresse);
        $employe->email = htmlspecialchars($request->email);
        $employe->contact = htmlspecialchars($request->contact);
        $employe->cnps = htmlspecialchars($request->cnps);
        $employe->salaire = htmlspecialchars($request->salaire);
        $employe->nb_enfant = htmlspecialchars($request->nbenfant);
        $employe->s_matrimoniale = htmlspecialchars($request->s_matrimoniale);
        $employe->type_contrat = htmlspecialchars($request->type_contrat);
        $employe->debut = htmlspecialchars($request->debut);
        $employe->fin = !empty($request->fin) ? htmlspecialchars($request->fin) : null;
        $employe->nb_part = Employe::codepart($request->s_matrimoniale, $request->nbenfant);
        $employe->anciennete = Employe::anciennete($request->debut);
        if ($employe->save()){
            session()->flash('type', 'is-success');
            session()->flash('message', 'Les informations sur l\'employé ont bien été modifiées avec succès!');
            return redirect()->route('employes.index');
        }else{
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Une erreur s\'est produite, veuillez rééssayer svp !');
            return back();
        }
    }

    public function destroy(Request $request){
        $employe = Employe::where('id', $request->id)->first();
        if(empty($employe)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Erreur employé introuvable !');
            return back();
        }


        if ($employe->delete()) {
            //For activity
            $module = 'Paiement';
            $action = " a procédé à la suppression de l'agent : ".$employe->firstname." ".$employe->lastname;
            Activity::saveActivity($module,$action);

            session()->flash('type', 'is-success');
            session()->flash('message', "L'employé a été supprimé avec succès!");
            return back();
        }else{
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Erreur lors de la suppression de l\'employé.');
            return back();
        }
    }

    public function presenceRecap(Request $request){
        if (!$data['employe'] = Employe::find($request->id)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'L\'employé est introuvable.');
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
        ->where('employe_id', $data['employe']->person_id)
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

        $data['title'] = "Récapitulatif de présence de l'employé {$data['employe']->firstname} {$data['employe']->lastname} -";
        $data['section_title'] = "Récapitulatif de présence de l'employé {$data['employe']->firstname} {$data['employe']->lastname}";

        return view('employes.presence', $data);
    }


    public function importEmploye(Request $request){
        if(is_null($request->file)){
            session()->flash('type', 'is-danger');
            session()->flash('message', "Le fichier est obligatoire!!!");
            return back();
        }
        $path = $request->file("file")->getRealPath();
        Excel::import(new EmployerImport, $request->file('file')->store('files'));
        session()->flash('type', 'is-success');
        session()->flash('message', "Fichier importé avec succès!");
        return redirect()->back();
    }
}
