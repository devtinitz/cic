<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\User;
use App\Models\Siege;
use App\Models\Horaire;
use App\Models\Departement;
use App\Models\Agence;
use App\Models\Adminactivity;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\Models\Country;

class AgenceController extends Controller
{
    public function __construct()
	{
        $this->middleware('auth');
        View::share( 'section_title', 'Module Agence' );
		View::share( 'menu', 'agence' );
        View::share('countries', Country::all());
        View::share('sieges', Siege::where('status', 1)->get());
    }
    
    
    public function index()
    {
        $data['title'] = "Liste des agences - ";
        $data['section_title'] = "Liste des agences";
        $data['agences'] = Agence::orderByDesc('created_at')->paginate(20);
        //For activity
        $module = 'Agences';
        $action = " a consulté la liste des agences." ;
        Activity::saveActivity($module,$action);
        return view('agences.index', $data);
    }

    public function create(){
        $data['title'] = "Création d'une agence - ";
        $data['section_title'] = "Création d'une agence";

        return view('agences.create', $data);
    }

    public function store(Request $request){
        $request->validate([
            'libelle' => 'required|unique:agences',
            'siege' => 'required',
            'contact' => 'required',
            'adresse' => 'required',
            'country' => 'required',
        ]);

        if(!$siege = Siege::find($request->siege)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Aucun siège trouvé');
            return back();
        }

        if(!$country = Country::find($request->country)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Aucun pays trouvé');
            return back();
        }


        $agenceData['siege_id'] = $siege->id;
        $agenceData['libelle'] = htmlspecialchars($request->libelle);
        $agenceData['country_id'] = $country->id;
        $agenceData['contact'] = htmlspecialchars($request->contact);
        $agenceData['adresse'] = htmlspecialchars($request->adresse);
        $agenceData['localisation'] = htmlspecialchars($request->localisation);
        $agenceData['status'] = 1;
        $agenceData['created_by'] = ucfirst(Auth::user()->name).' '.ucfirst(Auth::user()->prenoms);

        //Creation du siege
        if ($agence = Agence::create($agenceData)){
            //For activity
            $module = 'Agence';
            $action = " a procédé à la création de l'agence {$agence->libelle}." ;
            Activity::saveActivity($module,$action);
            session()->flash('type', 'is-success');
            session()->flash('message', 'L\'agence a bien été créée avec succès.');
            return redirect()->route('agences.index');
        }else{
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Une erreur s\'est produite lors de la création de l\'agence');
            return back();
        }
    }

    public function edit(Request $request){
        if(!$data['agence'] = Agence::find($request->id)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Aucune agence trouvée');
            return back();
        }

        $data['title'] = "Modification de l'agence {$data['agence']->libelle} - ";
        $data['section_title'] = "Modificationde l'agence {$data['agence']->libelle}";

        return view('agences.edit', $data);
    }


    public function show(Request $request)
    {
        $id=htmlspecialchars($request->id);
        $agence = Agence::where('id',$id)->first();
        $data['agence'] = $agence;

        if(!$data['agence']){
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Agence introuvable');
            return back();
        }

        $data['title'] = "Détails de l'agence : ".$data['agence']->libelle;
        $data['section_title'] = "Détails de l'agence : ".$data['agence']->libelle;

        $data['horaires'] = Horaire::where('siege_id', $data['agence']->siege_id)->get();
        $data['departements'] = Departement::where('siege_id', $data['agence']->siege_id)->get();

        //For activity
        $module = 'Sièges';
        $action = " a consulté les détails de l'agence {$data['agence']->libelle}." ;
        Activity::saveActivity($module,$action);
        return view('agences.show', $data);
    }


    public function update(Request $request){
        $request->validate([
            'libelle' => 'required',
            'siege' => 'required',
            'contact' => 'required',
            'adresse' => 'required',
            'country' => 'required',
            'id' => 'required'
        ]);


        if(!$agence = Agence::find($request->id)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Aucune agence trouvée');
            return back();
        }

        if(!$siege = Siege::find($request->siege)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Aucun siège trouvé');
            return back();
        }

        //Si le libelle existe deja
        if (Agence::where('libelle', $request->libelle)->where('id', '!=', $agence->id)->first()){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Ce libéllé existe déjà.');
            return back();
        }

        if(!$country = Country::find($request->country)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Aucun pays trouvé');
            return back();
        }

        $agenceData['siege_id'] = $siege->id;
        $agenceData['libelle'] = htmlspecialchars($request->libelle);
        $agenceData['country_id'] = $country->id;
        $agenceData['contact'] = htmlspecialchars($request->contact);
        $agenceData['adresse'] = htmlspecialchars($request->adresse);
        $agenceData['localisation'] = htmlspecialchars($request->localisation);

        //Modification du siege
        if ($agence->update($agenceData)){
            //For activity
            $module = 'Sièges';
            $action = " a procédé à la modification de l'agence {$agence->libelle}." ;
            Activity::saveActivity($module,$action);
            session()->flash('type', 'is-success');
            session()->flash('message', 'L\'agence a bien été modifiée avec succès.');
            return redirect()->route('agences.index');
        }else{
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Une erreur s\'est produite lors de la modification de l\'agence');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($agence = Agence::find($id)){
            $agence->delete();
            //Modification des Departements appartenant à ce siège
            //Departement::where('agence_id', $id)->update(['agence_id' => 0]);

            //For activity
            $module = 'Departements';
            $action = " a procédé à la suppression de l'agence {$agence->libelle}." ;
            Activity::saveActivity($module,$action);
            session()->flash('type', 'is-success');
            session()->flash('message', 'L\'agence a bien été supprimée');
            return redirect()->route('agences.index');
        }else{
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Aucune agence n\'a été trouvée.');
            return redirect()->route('agences.index');
        }
    }
    
    /**
     *
     * update user state
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function editState($id) {
        $id = htmlspecialchars($id);
        $agence = Agence::where('id',$id)->first();
        if(!$agence) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Agence introuvable");
            return back();  
        }
        $agence->status = $agence->status == 1 ? 0 : 1;
        $agence->save();
        session()->flash('type', 'alert-success');
        session()->flash('message', "Statut de l'agence modifié avec succès");
        //For activity
        $module = 'Sièges';
        $action = " a procédé à la modification du statut de l'agence {$agence->libelle}." ;
        Activity::saveActivity($module,$action);
        return back();
    }
    
    
    //Recherche avancée sur les sieges 
    //ceux qui on crée leur compte via linscription et 
    //ceux qui on été rajouté par les administrateur de siege
    //Pour manager lapplication web
    public function search(Request $request)
    {
        
        $data['section_title'] = 'Digipoint - Liste des agences';

        $statut = htmlspecialchars($request->statut);
        $statutComparator = $statut == 'all' ? '!=' : '=';
        
        $validation = htmlspecialchars($request->validation);
        $validationComparator = $validation == 'all' ? '!=' : '=';
        
        $debut = $request->debut != "" ? date('Y-m-d',strtotime( htmlspecialchars($request->debut)))  : "2021-01-01" ;
        $fin = $request->fin != "" ? date('Y-m-d',strtotime(htmlspecialchars($request->fin)))  : date('Y-m-d',strtotime(Carbon::today()));

        //dd($request->all());
        $data['sieges'] = Siege::where('statut', $statutComparator,$statut )
            ->where('statutvalidation', $validationComparator,$validation )
            ->whereBetween('created_at', [$debut, $fin])
            ->orderBy('id','desc')
            ->paginate(100);

        User::logs("Affichage de la page : recherche avancée des sieges");

        return view('agences.index', $data);
    }
}
