<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Fonction;
use App\Models\Agence;
use App\Models\Horaires;
use App\Models\Departements;

use App\Models\Adminactivity;

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

class FonctionController extends Controller
{
    public function __construct()
	{
        $this->middleware('auth');
        View::share( 'section_title', 'Module Congés' );
		View::share( 'menu', 'Fonctions' );
        View::share( 'allFonctions', Fonction::all() );
        
        View::share( 'nbFonctions', Fonction::count());
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //        
		$data['title'] = "Digipoint - Liste des Fonctions";
        User::logs("Affichage de la page : Liste des Fonctions");
        return view('fonctions.index', $data);
    }
    
    public function byStatut(Request $request)
    {
        
        $data['section_title'] = 'Digipoint - Liste des Fonctions';

        $statut = htmlspecialchars($request->statut);
        if($statut == 1){
           $data['parametre'] = "à valider";
        }else{
            $data['parametre'] = "validés";
        }
        
        $data['allFonctions'] = Fonction::where('statut', $statut )
            ->orderBy('id','desc')
            ->get();

        User::logs("Affichage de la liste des Fonctions par statut");

        return view('fonctions.index', $data);
    }
    
    public function byParam($param)
    {
        $param = htmlspecialchars($param);
        $data['menu'] = "contenu";
        //Envoi du sous-Menu
        $data['submenu'] = "article";
        $data['notification'] = User::notifnonlus();
        $data['submenusub'] = "listearticle";
        $data['section_title'] = 'Liste de tous les articles postés '.$param;
        $data['categories'] = Category:: all();
        $data['nbarticles'] = Fonction:: count();
        $data['nbarticlesPublie'] = Fonction::where('status',1)->count();
        $data['nbarticlesNonPublie'] = Fonction::where('status',0)->count();
        $data['nbcateg'] = Category:: count();
        $today = Carbon::today();
        if($param =="today")
        {
            $data['articles'] = Fonction::orderBy('id','DESC')->whereDate('created_at','=',$today )->paginate(20);
			$data['parametre'] = "postés aujourd'hui";
		}elseif($param =="hier")
        {
            $data['parametre'] = "postés hier";
			$ilyaun = date('Y-m-d H:i:s', strtotime($today . ' -1 day'));
            $data['articles'] = Fonction::whereDate('created_at','=' , $ilyaun )->paginate(20);

        }elseif($param =="cettesemaine")
        {
			$data['parametre'] = "postés cette semaine";
			$debutdate = date('Y-m-d H:i:s', strtotime($today . ' -6 day'));
            $enddate = date('Y-m-d H:i:s', strtotime($today));
            $data['articles'] = Fonction::whereDate('created_at','>=',$debutdate )->whereDate('created_at','<=',$enddate )->paginate(20);
        }elseif($param == "cemois")
        {
            $data['parametre'] = "postés ce mois";

			$debutmois = date('Y-m-01', strtotime($today));
            $endmois = date('Y-m-t', strtotime($today));
            $data['articles'] = Fonction::whereDate('created_at','>=',$debutmois )->whereDate('created_at','<=',$endmois )->paginate(20);
        }
        else
        {
            $data['articles'] = Fonction::orderBy('id','DESC')->paginate(20);
        }

        User::logs("Affichage de la page : Liste des Fonctions");
        return view('fonctions.index', $data);
    }
    
    //Fonctionnalité de validation d'un Fonction
    //Une fois que le compte est créer et que lutilisateur a configuré son siéges ainsi
    //que sa premiere agence Nous devons valider le compte 
    //Puis nous lui envoyons un mail pour confirmer que le compte est approuvé
    public function valider(Request $request)
    {
        //
        $id=htmlspecialchars($request->id);
        
        $Fonction = Fonction::where(['id'=>$id,'statutvalidation'=>0])->first();
        
        if(!$Fonction) {
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Congés introuvable');
            return back();
        }
        
        $Fonction->statutvalidation = 1;
        $Fonction->validated_at = Carbon::now();
        $Fonction->validate_by = Auth::user()->nom.' '.Auth::user()->prenoms;
        $Fonction->save();
        User::logs("Activation du Congés ayant pour id : ".$Fonction->id);
        
        $user= User::where('Fonction_id',$Fonction->id)->first();
        $data['userName'] = $user->nom .' '.$user->prenoms ;
        $data['email'] = $user->email;
        $data['FonctionLibelle'] =  $Fonction->libelle;

        //envoi de mail de notification a l'utilisateur numéro 1
        @Mail::send('emails.validations.Fonction', $data, function($message) use($data) {
            $message->from('validation-services@digipoint.com','Digipoint')
                ->to($data['email'])
                ->cc('loicakatcha12@gmail.com','nicaisekoffi40@gmail.com')
                ->subject('Votre compte a été appouvé');
        });
        
        session()->flash('type', 'alert-success');
        session()->flash('message', 'Congés activé avec succès');
        return redirect()->route('Fonctions.index');
    }
    
    public function edit($id)
    {
		$id = htmlspecialchars($id);		
        $data['client'] = User::where('id',$id)->first();
        if(!$data['client']){
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Erreur de modification veuillez réessayer');
            User::logs("Echec de Modification d'information de client");
            return back();
        }
        $data['section_title'] = "Pointage - Modification d'un client";
        User::logs("Tentative de Modification d'information du client: " .$data['client']->nom.' '.$data['client']->prenoms);
        return view('fonctions.edit', $data);
    }
    
    public function update(Request $request)
    {
        $id = htmlspecialchars($request->client_id);        
        $validate = Validator::make($request->all(), [
           'nom' => 'required',
           'prenoms' => 'required',
           //'email' => 'required',
           'telephone' => 'required',
           'adresse'  => 'required',
           'role' => 'required',
           "Fonction_id" => "required",     
        ]);
        if($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }

        $client['nom'] = htmlspecialchars($request->nom);
        $client['prenoms'] = htmlspecialchars($request->prenoms);
        $client['telephone'] = htmlspecialchars($request->telephone);
        $client['adresse'] = htmlspecialchars($request->adresse);
        //$client['email'] = htmlspecialchars($request->email);
        $client['Fonction_id'] = htmlspecialchars($request->Fonction_id);
        $client['role'] = htmlspecialchars($request->role);
         //dd($client);

        if(User::find($id)->update($client)){
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Client modifié avec succès');
            User::logs("Modification d'information de client effectuée avec succès");
            return redirect()->route('Fonctions.index');
        }else{
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Erreur de modification veuillez réessayer');
            User::logs("Echec de Modification d'information dun client");
            return back();
        }
    }
    
    public function show(Request $request)
    {	
		$id=htmlspecialchars($request->id);
        $Fonction=Fonction::where('id',$id)->first();
        $data['Fonction'] = $Fonction;
        
		if(!$data['Fonction']){
			session()->flash('type', 'alert-success');
            session()->flash('message', 'Congés introuvable');
			return back();
		}
        
        $client = new Client();
        $urlHoraire = env('API_URL').'/api/Fonctions/horaires/Fonction/'.$Fonction->id;
        $url = env('API_URL').'/api/Fonctions/horaires/Fonction/'.$Fonction->id;

        //Autorisation dans le header
        $headers['Authorization'] = "Bearer ".session('access_token');
        $headers['Accept'] = "application/json";
        try {
            $response = $client->get($urlHoraire, [
                'form_params' => [],
                'headers' => $headers
            ]);
            $res = $response->getBody()->getContents();
            $result = json_decode($res,true);
            $data["horaires"] = $result["data"];

        } catch (BadResponseException $e) {
            $responsese=response()->json(['status' => $e->getCode(), 'message' => $e->getMessage()]);
            dd($responsese);
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Une erreur s'est produite lors de l'enregistrement, veuillez réessayer SVP ! ");
            return back();
        }
        //dd($data["horaires"][0]['debut']);
        
        $data['agences'] = Agence::where('Fonction_id',$Fonction->id)->get();
        $data['departements'] = Departements::where('Fonction_id',$Fonction->id)->with('services')->get();
        //dd($data['departements']);
        
		$data['title'] = "Digipoint - Profile du Congés : ".$data['Fonction']->libelle;
		$data['section_title'] = "Profile du Congés : ".$data['Fonction']->libelle;
        User::logs("Affichage des infos du Fonctions: " .$data['Fonction']->libelle);
        return view('fonctions.show', $data);
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
            "Fonction_id" => "required",
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }  

       
        
        $Fonction=Fonction::where('id',htmlspecialchars($request->Fonction_id))->first();
        if(!$Fonction){
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Congés introuvable');
            return back(); 
        }         
        //dd($request->all());
        
        $client = new Client();
        $url = env('API_URL').'/api/Fonctions/horaires/store';
        
        // ajout de l'id du Fonction dans la requete
        //$request->request->add(['Fonction_id' => $Fonction->id]);
        //Autorisation dans le header
        $headers['Authorization'] = "Bearer ".session('access_token');
        $headers['Accept'] = "application/json";
        try {
            $response = $client->post($url, [
                'form_params' => $request->all(),
                'headers' => $headers
            ]);
            $data = $response->getBody()->getContents();
            $result = json_decode($data,true);

            session()->flash('type', 'alert-success');
            session()->flash('message', "Horaire Enregistré avec succès !");
            return back();

        } catch (BadResponseException $e) {
            $response=response()->json(['status' => $e->getCode(), 'message' => $e->getMessage()]);
            dd($response);
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Une erreur s'est produite lors de l'enregistrement, veuillez réessayer SVP ! ");
            return back();
        }
    }
    
    
    /*
    public function storeHoraire(Request $request)
    {		
        
        if($validator->fails()){
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Erreur dans le formulaire');
            return back()->withErrors($validator->errors())->withInput($request->input());
        }
        
        $Fonction_id = htmlspecialchars($request->Fonction_id);
        
        $Fonction= Fonction::where('id',$Fonction_id)->first();
        
        if(!$Fonction){
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Congés introuvable');
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
                    'Fonction_id'=>$Fonction->id,
                    'created_by'=> Auth::user()->nom.' '.Auth::user()->prenoms,
                ]
            );
        }

        session()->flash('type', 'alert-success');
        session()->flash('message', 'Horaire enregistré avec succes');
        return back();
    }
    */
    
    
       

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
        $Fonction = Fonction::where('id',$id)->first();
        if(!$Fonction) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Compte Congés introuvable");
            return back();  
        }
        $Fonction->statut = $Fonction->statut == 1 ? 0 : 1;
        $Fonction->save();
        session()->flash('type', 'alert-success');
        session()->flash('message', "Statut de ce compte Congés modifié avec succès");
        User::logs("Modification du statut d'un compte Congés : ".$Fonction->libelle);
        return back();
    }
    
    
    //Recherche avancée sur les Fonctions 
    //ceux qui on crée leur compte via linscription et 
    //ceux qui on été rajouté par les administrateur de Fonction
    //Pour manager lapplication web
    public function search(Request $request)
    {
        
        $data['section_title'] = 'Digipoint - Liste des Fonctions';

        $statut = htmlspecialchars($request->statut);
        $statutComparator = $statut == 'all' ? '!=' : '=';
        
        $validation = htmlspecialchars($request->validation);
        $validationComparator = $validation == 'all' ? '!=' : '=';
        
        $debut = $request->debut != "" ? date('Y-m-d',strtotime( htmlspecialchars($request->debut)))  : "2021-01-01" ;
        $fin = $request->fin != "" ? date('Y-m-d',strtotime(htmlspecialchars($request->fin)))  : date('Y-m-d',strtotime(Carbon::today()));

        //dd($request->all());
        $data['Fonctions'] = Fonction::where('statut', $statutComparator,$statut )
            ->where('statutvalidation', $validationComparator,$validation )
            ->whereBetween('created_at', [$debut, $fin])
            ->orderBy('id','desc')
            ->paginate(100);

        User::logs("Affichage de la page : recherche avancée des Fonctions");

        return view('fonctions.index', $data);
    }
}
