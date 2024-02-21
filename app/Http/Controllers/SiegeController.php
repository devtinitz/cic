<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Country;
use App\Models\Employe;
use App\Models\Horaire;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siege;
use App\Models\Agence;
use App\Models\Horaires;
use App\Models\Typeconge;
use App\Models\Service;
use App\Models\Typepreavis;

use App\Models\Adminactivity;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class SiegeController extends Controller
{
    public function __construct()
	{
        $this->middleware('auth');
        View::share( 'section_title', 'Module Siège' );
		View::share( 'menu', 'sieges' );
        View::share( 'sieges', Siege::orderByDesc('created_at')->paginate(20) );
        View::share('employes', Employe::where('status', 1)->get());
        View::share('countries', Country::all());

        View::share( 'menu', 'siege' );
        View::share( 'sousmenu', 'siege' );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data['title'] = "Liste des sièges - ";
        $data['section_title'] = "Liste des sièges";
        //For activity
        $module = 'Sièges';
        $action = " a consulté la liste des sièges." ;
        Activity::saveActivity($module,$action);
        return view('sieges.index', $data);
    }

    public function create(){
        $data['title'] = "Création de siège - ";
        $data['section_title'] = "Création de siège";
        $data['employes'] = Employe::where('status', 1)->get();
        $data['countries'] = Country::all();
        return view('sieges.create', $data);
    }

    public function store(Request $request){
        $request->validate([
            'libelle' => 'required|unique:sieges|unique:agences',
            'logo' => 'nullable',
            'horaire' => 'required',
            'employe' => 'required',
            'country' => 'required',
            'contact' => 'required',
            'adresse' => 'required',
        ]);

        if(!$employe = Employe::find($request->employe)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Aucun utilisateur trouvé');
            return back();
        }

        if(!$country = Country::find($request->country)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Aucun pays trouvé');
            return back();
        }

        if($request->hasFile('logo')){
            $data['logo'] = storeImage($request->logo);
        }

        $data['libelle'] = htmlspecialchars($request->libelle);
        $data['horaire'] = htmlspecialchars($request->horaire);
        $data['employe_id'] = $employe->id;
        $data['country_id'] = $country->id;
        $data['status'] = 1;
        $data['created_by'] = ucfirst(Auth::user()->name).' '.ucfirst(Auth::user()->prenoms);

        //Creation du siege
        if ($siege = Siege::create($data)){
            $agenceData['siege_id'] = $siege->id;
            $agenceData['libelle'] = htmlspecialchars($request->libelle);
            $agenceData['country_id'] = $country->id;
            $agenceData['contact'] = htmlspecialchars($request->contact);
            $agenceData['adresse'] = htmlspecialchars($request->adresse);
            $agenceData['localisation'] = htmlspecialchars($request->localisation);
            $agenceData['status'] = 1;
            $agenceData['created_by'] = ucfirst(Auth::user()->name).' '.ucfirst(Auth::user()->prenoms);

            //creation de l'agence
            if ($agence = Agence::create($agenceData)){
                $siege->update(['agence_id' => $agence->id]);
            }

            //For activity
            $module = 'Sièges';
            $action = " a procédé à la création du siège {$siege->libelle}." ;
            Activity::saveActivity($module,$action);
            session()->flash('type', 'is-success');
            session()->flash('message', 'Le siège a bien été créé avec succès.');
            return redirect()->route('sieges.index');
        }else{
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Une erreur s\'est produite lors de la création du siège');
            return back();
        }
    }

    public function edit(Request $request){
        if(!$data['siege'] = Siege::find($request->id)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Aucun siège trouvé');
            return back();
        }

        $data['title'] = "Modification du siège {$data['siege']->libelle} - ";
        $data['section_title'] = "Modification du siège {$data['siege']->libelle}";

        return view('sieges.edit', $data);
    }

    public function update(Request $request){
        $request->validate([
            'libelle' => 'required',
            'logo' => 'nullable',
            'horaire' => 'required',
            'employe' => 'required',
            'country' => 'required',
            'contact' => 'required',
            'adresse' => 'required',
            'id' => 'required'
        ]);


        if(!$siege = Siege::find($request->id)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Aucun siège trouvé');
            return back();
        }

        //Si le libelle existe deja
        if (Siege::where('libelle', $request->libelle)->where('id', '!=', $siege->id)->first()){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Ce libéllé existe déjà.');
            return back();
        }

        if(!$employe = Employe::find($request->employe)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Aucun utilisateur trouvé');
            return back();
        }

        if(!$country = Country::find($request->country)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Aucun pays trouvé');
            return back();
        }

        if($request->hasFile('logo')){
            $data['logo'] = storeImage($request->logo);
        }

        $data['libelle'] = htmlspecialchars($request->libelle);
        $data['horaire'] = htmlspecialchars($request->horaire);
        $data['employe_id'] = $employe->id;
        $data['country_id'] = $country->id;

        //Modification du siege
        if ($siege->update($data)){
            $agenceData['siege_id'] = $siege->id;
            $agenceData['libelle'] = htmlspecialchars($request->libelle);
            $agenceData['country_id'] = $country->id;
            $agenceData['contact'] = htmlspecialchars($request->contact);
            $agenceData['adresse'] = htmlspecialchars($request->adresse);
            $agenceData['localisation'] = htmlspecialchars($request->localisation);

            if (!empty($siege->hasAgence)) $siege->hasAgence->update($agenceData);

            //For activity
            $module = 'Sièges';
            $action = " a procédé à la modification du siège {$siege->libelle}." ;
            Activity::saveActivity($module,$action);
            session()->flash('type', 'is-success');
            session()->flash('message', 'Le siège a bien été modifié avec succès.');
            return redirect()->route('sieges.index');
        }else{
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Une erreur s\'est produite lors de la modification du siège');
            return back();
        }
    }


    public function show(Request $request)
    {
		$id=htmlspecialchars($request->id);
        $siege = Siege::where('id',$id)->first();
        $data['siege'] = $siege;

		if(!$data['siege']){
			session()->flash('type', 'alert-success');
            session()->flash('message', 'Siège introuvable');
			return back();
		}

		$data['title'] = "Détails du siège : ".$data['siege']->libelle;
		$data['section_title'] = "Détails du siège : ".$data['siege']->libelle;

        //For activity
        $module = 'Sièges';
        $action = " a consulté les détails du siège {$data['siege']->libelle}." ;
        Activity::saveActivity($module,$action);

        return view('sieges.show', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeHoraire(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "jours" => "required",
            "fin" => "required",
            "debut" => "required",
            "siege_id" => "required",
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $siege = Siege::where('id',htmlspecialchars($request->siege_id))->first();
        if(!$siege){
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Siège introuvable');
            return back();
        }

        $siege->allHoraires()->delete();

        //save element
        for($i=0; $i<count($request->jours); $i++){
            Horaire::create([
                'jours'=> htmlspecialchars($request->jours[$i]),
                'debut'=>htmlspecialchars($request->debut[$i]),
                'fin'=>htmlspecialchars($request->fin[$i]),
                'siege_id'=>$siege->id,
                'created_by'=> Auth::user()->nom.' '.Auth::user()->prenoms,
            ]);
        }

        //For activity
        $module = 'Sièges';
        $action = " a procédé à la sauvegarde des horaires du siège {$siege->libelle}." ;
        Activity::saveActivity($module,$action);

        session()->flash('type', 'alert-success');
        session()->flash('message', 'Horaire enregistré avec succes');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($siege = Siege::find($id)){
            $siege->delete();
            //Modification des agences appartenant à ce siège
            Agence::where('siege_id', $id)->update(['siege_ud' => 0]);

            //For activity
            $module = 'Sièges';
            $action = " a procédé à la suppression du siège {$siege->libelle}." ;
            Activity::saveActivity($module,$action);

            session()->flash('type', 'is-success');
            session()->flash('message', 'Le siège a bien été supprimé');
            return redirect()->route('sieges.index');
        }else{
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Aucun siège n\'a été trouvé.');
            return redirect()->route('sieges.index');
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
        $siege = Siege::where('id',$id)->first();
        if(!$siege) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Compte Siège introuvable");
            return back();
        }
        $siege->status = $siege->status == 1 ? 0 : 1;
        $siege->save();

        //For activity
        $module = 'Sièges';
        $action = " a procédé à la modification du statut du siège {$siege->libelle}." ;
        Activity::saveActivity($module,$action);
        session()->flash('type', 'alert-success');
        session()->flash('message', "Statut du siège modifié avec succès");
        return back();
    }


    //Recherche avancée sur les sieges
    //ceux qui on crée leur compte via linscription et
    //ceux qui on été rajouté par les administrateur de siege
    //Pour manager lapplication web
    public function search(Request $request)
    {

        $data['section_title'] = 'Digipoint - Liste des sièges';
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

        return view('sieges.index', $data);
    }

    /************************************************* Type congé *****************************************************/

    public function indexConge(){
        $data['typeconges'] = Typeconge::all();

        $data['title'] = "Liste des types de congé";
        $data['section_title'] = "Liste des types de congé";

        //For activity
        $module = 'Type de congé';
        $action = " a consulté les types de congé." ;
        Activity::saveActivity($module,$action);
        return view('typeconges.index', $data);
    }

    public function createConge(){
        //For activity
        $data['title'] = "Créé un type de congé";
        $data['section_title'] = "Créé un type de congé";
        return view('typeconges.create', $data);
    }

    public function storeConge(Request $request){
        $request->validate([
            'libelle' => 'required'
        ]);

        if ($typeconge = Typeconge::create([
            'libelle' => htmlspecialchars($request->libelle),
            'status' => 1,
            'created_by' => Auth::user()->name.' '.Auth::user()->prenoms]))
        {
            $module = 'Type de congé';
            $action = " a procédé à la création du type de congé {$typeconge->libelle}." ;
            Activity::saveActivity($module,$action);

            session()->flash('type', 'alert-success');
            session()->flash('message', "Type de congé enregistré avec succès.");
            return back();
        }else{
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Une erreur s'est produite, veuillez rééssayer svp.");
            return back();
        }
    }

    public function editConge(Request $request){
        if(!$data['typeconge'] = Typeconge::find($request->id)){
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Aucun type de congé trouvé");
            return back();
        }

        $data['title'] = "Modifier le type de congé {$data['typeconge']->libelle}";
        $data['section_title'] = "Modifier le type de congé {$data['typeconge']->libelle}";
        return view('typeconges.edit', $data);
    }

    public function updateConge(Request $request){
        $request->validate([
            'libelle' => 'required'
        ]);

        if(!$typeconge = Typeconge::find($request->id)){
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Aucun type de congé trouvé");
            return back();
        }

        if ($typeconge->update(['libelle' => htmlspecialchars($request->libelle), 'status' => htmlspecialchars($request->status)])){
            $module = 'Type de congé';
            $action = " a procédé à la modification du type de congé {$typeconge->libelle}." ;
            Activity::saveActivity($module,$action);

            session()->flash('type', 'alert-success');
            session()->flash('message', "Type de congé modifié avec succès.");
            return redirect()->route('typeconges.index');
        }else{
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Une erreur s'est produite, veuillez rééssayer svp.");
            return back();
        }
    }

    public function editStateConge($id) {
        $id = htmlspecialchars($id);
        $typeconge = Typeconge::where('id',$id)->first();
        if(!$typeconge) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Type de congé introuvable");
            return back();
        }
        $typeconge->status = $typeconge->status == 1 ? 0 : 1;
        $typeconge->save();

        //For activity
        $module = 'Type congé';
        $action = " a procédé à la modification du statut du Type de congé {$typeconge->libelle}." ;
        Activity::saveActivity($module,$action);
        session()->flash('type', 'alert-success');
        session()->flash('message', "Statut du type de congé modifié avec succès");
        return back();
    }

    public function destroyConge(Request $request){
        if($typeconge = Typeconge::find($request->id)){
            $typeconge->delete();

            //For activity
            $module = 'Type de congé';
            $action = " a procédé à la suppression du Type de congé {$typeconge->libelle}." ;
            Activity::saveActivity($module,$action);

            session()->flash('type', 'is-success');
            session()->flash('message', 'Le Type de congé a bien été supprimé');
            return redirect()->route('typeconges.index');
        }else{
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Aucun Type de congé n\'a été trouvé.');
            return redirect()->route('typeconges.index');
        }
    }

    /************************************************* Type préavis *****************************************************/

    public function indexPreavis(){
        $data['typepreavis'] = Typepreavis::all();

        $data['title'] = "Liste des types de péavis";
        $data['section_title'] = "Liste des types de préavis";

        //For activity
        $module = 'Type de préavis';
        $action = " a consulté les types de préavis." ;
        Activity::saveActivity($module,$action);
        return view('typepreavis.index', $data);
    }

    public function createPreavis(){
        //For activity
        $data['title'] = "Créé un type de préavis";
        $data['section_title'] = "Créé un type de préavis";
        return view('typepreavis.create', $data);
    }

    public function storePreavis(Request $request){
        $request->validate([
            'libelle' => 'required'
        ]);

        if ($typepreavis = Typepreavis::create([
            'libelle' => htmlspecialchars($request->libelle),
            'status' => 1,
            'created_by' => Auth::user()->name.' '.Auth::user()->prenoms]))
        {
            $module = 'Type de préavis';
            $action = " a procédé à la création du type de préavis {$typepreavis->libelle}." ;
            Activity::saveActivity($module,$action);

            session()->flash('type', 'alert-success');
            session()->flash('message', "Type de préavis enregistré avec succès.");
            return redirect()->route('typepreavis.index');
        }else{
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Une erreur s'est produite, veuillez rééssayer svp.");
            return back();
        }
    }

    public function editPreavis(Request $request){
        if(!$data['typepreavis'] = Typepreavis::find($request->id)){
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Aucun type de préavis trouvé");
            return back();
        }

        $data['title'] = "Modifier le type de préavis {$data['typepreavis']->libelle}";
        $data['section_title'] = "Modifier le type de préavis {$data['typepreavis']->libelle}";
        return view('typepreavis.edit', $data);
    }

    public function updatePreavis(Request $request){
        $request->validate([
            'libelle' => 'required'
        ]);

        if(!$typepreavis = Typepreavis::find($request->id)){
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Aucun type de préavis trouvé");
            return back();
        }

        if ($typepreavis->update(['libelle' => htmlspecialchars($request->libelle), 'status' => htmlspecialchars($request->status)])){
            $module = 'Type de préavis';
            $action = " a procédé à la modification du type de préavis {$typepreavis->libelle}." ;
            Activity::saveActivity($module,$action);

            session()->flash('type', 'alert-success');
            session()->flash('message', "Type de préavis modifié avec succès.");
            return redirect()->route('typepreavis.index');
        }else{
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Une erreur s'est produite, veuillez rééssayer svp.");
            return back();
        }
    }

    public function editStatePreavis($id) {
        $id = htmlspecialchars($id);
        $typepreavis = Typepreavis::where('id',$id)->first();
        if(!$typepreavis) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Type de préavis introuvable");
            return back();
        }
        $typepreavis->status = $typepreavis->status == 1 ? 0 : 1;
        $typepreavis->save();

        //For activity
        $module = 'Type congé';
        $action = " a procédé à la modification du statut du Type de préavis {$typepreavis->libelle}." ;
        Activity::saveActivity($module,$action);
        session()->flash('type', 'alert-success');
        session()->flash('message', "Statut du type de préavis modifié avec succès");
        return back();
    }

    public function destroyPreavis(Request $request){
        if($typepreavis = Typepreavis::find($request->id)){
            $typepreavis->delete();

            //For activity
            $module = 'Type de préavis';
            $action = " a procédé à la suppression du Type de préavis {$typepreavis->libelle}." ;
            Activity::saveActivity($module,$action);

            session()->flash('type', 'is-success');
            session()->flash('message', 'Le Type de préavis a bien été supprimé');
            return redirect()->route('typepreavis.index');
        }else{
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Aucun Type de préavis n\'a été trouvé.');
            return redirect()->route('typepreavis.index');
        }
    }
}
