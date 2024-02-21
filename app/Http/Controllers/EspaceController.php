<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Setting;
use App\Models\Espace;
use App\Models\Activity;

class EspaceController extends Controller{

    public function __construct(){
        $this->middleware('auth');
		View::share( 'menu', 'espace' );
        View::share( 'menuProfile', 'Espace utilisateur' );
        View::share( 'section_title', 'Espace utilisateur' );
        View::share( 'setting', Setting::first());
        View::share( 'espaces', Espace::all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){

        $data['title'] = 'Liste des espace utilisateurs';
        //For activity
        $module = 'Espace utilisateurs';
        $action = " a consulté la liste des espaces utilisateurs." ;
        Activity::saveActivity($module,$action);

        return view('espaces.index', $data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(){

        $data['title'] = "Création d'un espace utilistaeur";
        //For activity
        $module = 'Espace utilisateurs';
        $action = " a affiché la page de création d'un espace utilisateurs." ;
        Activity::saveActivity($module,$action);
        return view('espaces.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string',
        ]);

        if($validator->fails()) {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Erreur dans le formulaire');
            return back()->withErrors($validator->errors())->withInput($request->input());
        }

        if( $request->defaut !== null && $request->defaut == 1 ){

           //Mise a jour des autres espaces en les mettant a 0 comme indice d'espace par defaut si il
           //y en avait un qui etait deja defini comme par defaut
            $oldDefautEspace=Espace::where('defaut',1)->get();

           foreach($oldDefautEspace as $singleDefault){
              $singleDefault->defaut =0;
              $singleDefault->save();
           }

        }



        $espace = Espace::create([

            'nom' => htmlspecialchars($request->nom),
            'defaut' => ( $request->defaut !== null && $request->defaut == 1 ) ? 1:0,
            'module_espace' => isset($request->module_espace) ? 1:0,
            'module_espace_dlt' => isset($request->module_espace_dlt),
            'module_espace_lst' => isset($request->module_espace_lst),
            'module_espace_edt' => isset($request->module_espace_edt),
            'module_espace_crte' => isset($request->module_espace_crte),

            'module_user' => isset($request->module_user) ? 1:0,
            'module_user_lst' => isset($request->module_user_lst),
            'module_user_crte' => isset($request->module_user_crte),
            'module_user_edt' => isset($request->module_user_edt),
            'module_user_dlt' => isset($request->module_user_dlt),

            'module_departement' => isset($request->module_departement) ? 1:0,
            'module_departement_lst' => isset($request->module_departement_lst),
            'module_departement_crte' => isset($request->module_departement_crte),
            'module_departement_edt' => isset($request->module_departement_edt),
            'module_departement_dlt' => isset($request->module_departement_dlt),

            'module_employe' => isset($request->module_employe) ? 1:0,
            'module_employe_lst' => isset($request->module_employe_lst),
            'module_employe_crte' => isset($request->module_employe_crte),
            'module_employe_edt' => isset($request->module_employe_edt),
            'module_employe_dlt' => isset($request->module_employe_dlt),

            'module_presence' => isset($request->module_presence) ? 1:0,
            'module_presence_lst' => isset($request->module_presence_lst),
            'module_presence_crte' => isset($request->module_presence_crte),
            'module_presence_edt' => isset($request->module_presence_edt),
            'module_presence_dlt' => isset($request->module_presence_dlt),

            'module_permission' => isset($request->module_permission) ? 1:0,
            'module_permission_lst' => isset($request->module_permission_lst),
            'module_permission_crte' => isset($request->module_permission_crte),
            'module_permission_edt' => isset($request->module_permission_edt),
            'module_permission_dlt' => isset($request->module_permission_dlt),

            'module_setting' => isset($request->module_setting) ? 1:0,
            'module_setting_edt' => isset($request->module_setting_edt) ? 1:0,

            'created_by' => Auth::user()->name,

        ]);



        //For activity
            $module = 'Espace utilisateurs';
            $action = " a procédé à la création de l'espace utilisateur intitulé: ". $espace->nom."." ;
            Activity::saveActivity($module,$action);

        session()->flash('type', 'is-success');
        session()->flash('message', 'Espace utilisateur créé avec succès!');
        return redirect()->route('espaces.index');

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id){

        $data['espace'] = Espace::where('id', $id)->with('users')->first();
        if(empty($data['espace'])) {
            session()->flash('type','is-danger');
            session()->flash('message','Erreur Espace utilisateur introuvable');
            return back();
        }

        $data['title'] = "Détail de l'espace utilisateur : ".$data['espace']->nom;
        $data['section_title'] = "Espace utilisateur";
        //For activity
        $module = 'Espace utilisateurs';
        $action = " a consulté le détails de l'espace utilisateur intitulé : ".$data['espace']->nom."." ;
        Activity::saveActivity($module,$action);
        return view('espaces.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */

    public function edit($id){
        $data['espace'] = Espace::where('id',$id)->first();
        if(empty($data['espace'])){
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Espace introuvable');
            return back();
        }

		$data['subtitle'] = "Modification d'espace utilisateur";
        $data['menu'] = "espaces";
		$data['section_title'] = "Modifier un espace utilisateurs";
		$data['page_title'] = "Modification de l'espace utilisateur: ".$data['espace']->nom;
		$data['title'] = "Modification de l'espace utilisateur: ".$data['espace']->nom;

        //For activity
            $module = 'Espace utilisateurs';
            $action = " a affiché la page de modification de l'espace utilisateur intitulé: ". $data['espace']->nom."." ;
            Activity::saveActivity($module,$action);
        return view('espaces.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(Request $request){
        $espace = Espace::where('id',$request->espace)->first();

        if(!$espace){
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Espace introuvable');
            return back();
        }

        if( $request->defaut !== null && $request->defaut == 1 ){

           //Mise a jour des autres espaces en les mettant a 0 comme indice d'espace par defaut si il
           //y en avait un qui etait deja defini comme par defaut

           $oldDefautEspace=Espace::where('defaut',1)->get();

            foreach($oldDefautEspace as $singleDefault){
                $singleDefault->defaut =0;
                $singleDefault->save();
            }
        }

        $espace->update([

            'nom' => htmlspecialchars($request->nom),
            'defaut' => ( $request->defaut !== null && $request->defaut == 1 ) ? 1:0,


            'module_espace' => isset($request->module_espace) ? 1:0,
            'module_espace_dlt' => isset($request->module_espace_dlt),
            'module_espace_lst' => isset($request->module_espace_lst),
            'module_espace_edt' => isset($request->module_espace_edt),
            'module_espace_crte' => isset($request->module_espace_crte),

            'module_user' => isset($request->module_user) ? 1:0,
            'module_user_lst' => isset($request->module_user_lst),
            'module_user_crte' => isset($request->module_user_crte),
            'module_user_edt' => isset($request->module_user_edt),
            'module_user_dlt' => isset($request->module_user_dlt),

            'module_departement' => isset($request->module_departement) ? 1:0,
            'module_departement_lst' => isset($request->module_departement_lst),
            'module_departement_crte' => isset($request->module_departement_crte),
            'module_departement_edt' => isset($request->module_departement_edt),
            'module_departement_dlt' => isset($request->module_departement_dlt),

            'module_employe' => isset($request->module_employe) ? 1:0,
            'module_employe_lst' => isset($request->module_employe_lst),
            'module_employe_crte' => isset($request->module_employe_crte),
            'module_employe_edt' => isset($request->module_employe_edt),
            'module_employe_dlt' => isset($request->module_employe_dlt),

            'module_presence' => isset($request->module_presence) ? 1:0,
            'module_presence_lst' => isset($request->module_presence_lst),
            'module_presence_crte' => isset($request->module_presence_crte),
            'module_presence_edt' => isset($request->module_presence_edt),
            'module_presence_dlt' => isset($request->module_presence_dlt),

            'module_permission' => isset($request->module_permission) ? 1:0,
            'module_permission_lst' => isset($request->module_permission_lst),
            'module_permission_crte' => isset($request->module_permission_crte),
            'module_permission_edt' => isset($request->module_permission_edt),
            'module_permission_dlt' => isset($request->module_permission_dlt),

            'module_setting' => isset($request->module_setting) ? 1:0,
            'module_setting_edt' => isset($request->module_setting_edt) ? 1:0,
        ]);

        //For activity
            $module = 'Espace utilisateurs';
            $action = " a procédé à la modification de l'espace utilisateur intitulé: ". $espace->nom."." ;
            Activity::saveActivity($module,$action);

        session()->flash('type', 'is-success');
        session()->flash('message', "L'Espace utilisateur a été modifié avec succès!");
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */

    public function parDefaut($id){
        $data['espace'] = Espace::where('id',$id)->first();

        if(empty($data['espace'])){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Espace introuvable');
            return back();
        }

        //Mise a jour des autres espaces en les mettant a 0 comme indice d'espace par defaut si il
        $oldDefautEspace=Espace::where('defaut',1)->get();

        foreach($oldDefautEspace as $singleDefault){
            $singleDefault->defaut =0;
            $singleDefault->save();
        }

        $data['espace']->defaut=1;

		if ($data['espace']->save()){
            //For activity
            $module = 'Espace utilisateurs';
            $action = " a indiqué l'espace utilisateur : ".$data['espace']->nom." comme etant le nouvel espace utilisateur par defaut.";
            Activity::saveActivity($module,$action);
            session()->flash('type', 'alert-success');
            session()->flash('message', "L'espace utilisateur indiqué comme espace par defaut avec succès!");
            return back();
        }else{
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Erreur veuillez ressayer plus tard');
            return back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */

    public function destroy($id){
        $data['espace'] = Espace::where('id',$id)->first();

        if(empty($data['espace'])){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Espace introuvable');
            return back();
        }

        //Récupération de l'espace utilisateur defini comme par defaut
        //Sil n'en existe pas on back
        $newEspace=Espace::where('defaut',1)->where('id','!=',$data['espace']->id)->first();
        if(!$newEspace){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Veuillez définir un autre espace par defaut avant de procéder à la suppression.');
            return redirect()->route('espaces.index');
        }

        //Récupération des utilisateurs de cet espace la
        //Et effactation a l'espace par defaut
        $users = User::where('espace_id',$data['espace']->id)->get();
        foreach($users as $u){
            $u->espace_id = $newEspace->id;
            $u->save();
        }

		if ($data['espace']->delete()){
            //For activity
            $module = 'Espace utilisateurs';
            $action = " a procédé a la suppression de l'espace utilisateur intitulé: ". $data['espace']->nom.". Tous les utilisateurs appartenant à cet espace ont été affecté à l'espace utilisateur par defaut intitulé: ".$newEspace->nom."." ;
            Activity::saveActivity($module,$action);
            session()->flash('type', 'alert-success');
            session()->flash('message', "L'espace utilisateur a été supprimé avec succès!");
            return back();
        }else{
            session()->flash('type', 'alert-success');
            session()->flash('message', 'Erreur lors de la suppression de cet espace utilisateur');
            return back();
        }
    }
}

