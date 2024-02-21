<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\Siege;
use App\Models\Adminactivity;
use App\Models\Agence;
use App\Models\Horaires;
use App\Models\Country;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;


class HoraireController extends Controller
{
    public function __construct()
	{
        $this->middleware('auth');
        View::share( 'section_title', 'Module Horaires' );
		View::share( 'menu', 'horaire' );
		
        View::share( 'allHoraires', Horaires::all() );
        View::share( 'allSieges', Siege::all() );
		View::share( 'allAgences', Horaires::all() );        
        View::share( 'nbAgences', Horaires::count());
        View::share( 'pays', Country::all());
		
		View::share( 'nbAgences', Horaires::count());
        
        //View::share( 'activeHoraires', Horaires::where('status',1)->count());
        //View::share( 'inactiveHoraires', Horaires::where('status',0)->count() );
    }
    
    
    public function index()
    {
        $data["title"] = "Digipoint - Liste des horaires";
        $data["module"] = "Agence";

        $client = new Client();
        $url = env('API_URL').'/api/sieges/horaires/all';

        //Autorisation dans le header
        $headers['Authorization'] = "Bearer ".session('access_token');
        $headers['Accept'] = "application/json";
        try {
            $response = $client->get($url, [
                'form_params' => [],
                'headers' => $headers
            ]);
            $res = $response->getBody()->getContents();
            $result = json_decode($res,true);
			
            $data["horaires"] = $result["data"];
            User::logs("Affichage de la page : Liste des horaires");
			
            return  view('horaires.index',$data);

        } catch (BadResponseException $e) {
            $responsese=response()->json(['status' => $e->getCode(), 'message' => $e->getMessage()]);
            
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Une erreur s'est produite, veuillez réessayer SVP ! ");
            return back();
        }
    }
    
	
	
	
	public function store(Request $request)
    {		
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            "jours" => "required",
            "fin" => "required",
            "debut" => "required",
            "siege_id" => "required",
        ]);
        
        if($validator->fails()){
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Erreur dans le formulaire');
            return back()->withErrors($validator->errors())->withInput($request->input());
        }
        
        $siege_id = htmlspecialchars($request->siege_id);
        
        $siege= Siege::where('id',$siege_id)->first();
        
        if(!$siege){
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Siège introuvable');
            return back(); 
        }
        
        $horaire = new Horaires;
        //save element
        for($i=0; $i<count($request->jours); $i++){
            $horaire->create(
                [
                    'jours'=> htmlspecialchars($request->jours[$i]),
                    'debut'=>htmlspecialchars($request->debut[$i]),
                    'fin'=>htmlspecialchars($request->fin[$i]),
                    'siege_id'=>$siege->id,
                    'created_by'=> Auth::user()->nom.' '.Auth::user()->prenoms,
                ]
            );
        }

        session()->flash('type', 'alert-success');
        session()->flash('message', 'Horaire enregistré avec succes');
        return back();
    }
    
    
    public function edit($id)
    {
		$id = htmlspecialchars($id);
        $data['horaire'] = Horaires::where('id',$id)->first();
		if(!$data['horaire']){
			session()->flash('type', 'alert-success');
            session()->flash('message', 'Agenre introuvable');
			return back();
		}
		$data['section_title'] = "Digipoint - modifier une horaire";
        User::logs("Affichage des infos de l'horaire : " .$data['horaire']->libelle);
        return view('horaires.edit', $data);        
    }
    
    public function update(Request $request)
    {
        $id = htmlspecialchars($request->id); 
        $validate = Validator::make($request->all(), [
           'libelle' => 'required',
           'contact' => 'required',
           'localisation' => 'required',
           'adresse'  => 'required',
           'status' => 'required',
           "country_id" => "required|integer",     
           //"siege_id" => "required",     
        ]);
        if($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }
        $client = new Client();
        $url = env('API_URL').'/api/horaires/update/'.$request->id;
        
        //Autorisation dans le header
        $headers['Authorization'] = "Bearer ".session('access_token');
        $headers['Accept'] = "application/json";
        try {
            $response = $client->patch($url, [
                'form_params' => $request->all(),
                'headers' => $headers
            ]);
            if ($response->getStatusCode() == 200){
                session()->flash('type', 'alert-success');
                session()->flash('message', "Agence modifiée avec succès !");
                return  redirect()->route('horaires.index');
            }

        } catch (BadResponseException $e) {
            $respResult=response()->json(['status' => $e->getCode(), 'message' => $e->getMessage()]);
            dd($respResult);
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Une erreur s'est produite lors de l'enregistrement, veuillez réessayer SVP ! ");
            return back();
        }
        
    }
    
    public function show(Request $request)
    {	
		
        $data['horaire'] = Horaires::where('id',$id)->first();
		if(!$data['horaire']){
			session()->flash('type', 'alert-success');
            session()->flash('message', 'Utilisateur supprimé avec succès');
			return back();
		}
		$data['section_title'] = "Digipoint - Profile d'un horaire";
        User::logs("Affichage du tableau de bord de l'horaire: " .$data['horaire']->libelle);
        return view('horaires.show', $data);
    }
    
    
       

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    /**
     *
     * update user state
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function editState($id) {
        $id = htmlspecialchars($id);
        $horaire = Horaires::where('id',$id)->first();
        if(!$horaire) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Agence introuvable");
            return back();  
        }
        $horaire->status = $horaire->status == 1 ? 0 : 1;
        $horaire->save();
        session()->flash('type', 'alert-success');
        session()->flash('message', "Statut de l'horaire modifié avec succès");
        User::logs("Modification du statut de l'horaire : ".$horaire->libelle);
        return back();
    }
    
    
    //Recherche avancée sur les sieges 
    //ceux qui on crée leur compte via linscription et 
    //ceux qui on été rajouté par les administrateur de siege
    //Pour manager lapplication web
    public function search(Request $request)
    {
        
        $data['section_title'] = 'Digipoint - Liste des horaires';

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

        return view('horaires.index', $data);
    }
}
