<?php
namespace App\Http\Controllers;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

use App\Models\User;
use App\Models\Setting;
use App\Models\Espace;
use App\Models\Country;
use App\Models\Activity;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

	public function __construct(){
        $this->middleware('auth');
		View::share( 'menu', 'users' );
		View::share( 'espaces', Espace::all());
        View::share( 'menuProfile', 'Utilisateur' );
        View::share( 'section_title', 'Gestion des utilisateurs' );
        View::share( 'setting', Setting::first());
		View::share( 'nbUsers', User::count());
		View::share( 'countries', Country::all());
		View::share( 'civ', Country::where('id',106)->first());
		//Checkconnexion::updateOrCreateData();
    }




	public function index(){

		$data['title'] = "Liste des utilisateurs - ";
		$data['users'] = User::orderBy("id","DESC")->paginate(20);

		//For activity
		$module = 'Utilisateur';
		$action = " a consulté la liste des utilisateurs." ;
		Activity::saveActivity($module,$action);

		return view('users.index',$data);

    }

	public function create(){
		$data['title'] = " Ajouter un utilisateur - ";

		//For activity
		$module = 'Utilisateur';
		$action = " a affiché la page de création d'un utilisateur." ;
		Activity::saveActivity($module,$action);

		return view('users.create',$data);
    }

	public function store(Request $request){

		//dd($request->all());
		$this->validate(request(),[
			  "nom" => "required",
			  "username" => "required|unique:users",
			  "avatar" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
			  "prenoms" => "required",
			  "email" => "required|email|max:255|unique:users",
			  "adresse" => "required",
			  "fonction" => "required",
			  "telephone" => "required",
			  "pays" => "nullable",
			  "ville" => "required",
			  //"datedebut" => "required|date",
			  //"statut" => "required|integer",
			  "espace" => "required|integer",
			  "password" => "required",
			  "role" => "required",
		]);

		$usr = new User;
		$usr->username = htmlspecialchars($request->username);
		$usr->name = htmlspecialchars($request->nom);
		$usr->prenoms = htmlspecialchars($request->prenoms);
		$usr->email = htmlspecialchars($request->email);
		$usr->telephone = htmlspecialchars($request->telephone);
		$usr->fonction = htmlspecialchars($request->fonction);
		//$usr->datedebut = htmlspecialchars($request->datedebut);
		$usr->country_id = 1;
		$usr->ville = htmlspecialchars($request->ville);
		$usr->adresse = htmlspecialchars($request->adresse);

		if(file_exists($request->file('avatars'))){
            $extension = pathinfo($request->file('avatars')->getClientOriginalName(), PATHINFO_EXTENSION);
            $newName = Carbon::now()->timestamp.'.'.$extension;
            $upload_path = 'img/avatars/';
            if($request->file('avatars')->move($upload_path, $newName)){
                $data['avatar']  = "https://".$_SERVER['SERVER_NAME'].'/img/avatars/'.$newName;
				$usr->avatar = $data['avatar'];
            }
        }

		$usr->statut = 1;
		$usr->role = htmlspecialchars($request->role);
		$usr->espace_id = htmlspecialchars($request->espace);
		$usr->created_by = Auth::user()->name;

		$password = htmlspecialchars($request->password);
		$usr->password = Hash::make($password);

		$user['username'] = htmlspecialchars($request->username);
		$user['nom'] = htmlspecialchars($request->nom);
		$user['prenoms'] = htmlspecialchars($request->prenoms);
		$user['email'] =   htmlspecialchars($request->email);
		$user['pass'] = $password;

		if($usr->save()){

			//For activity
			$module = 'Utilisateur';
			$action = " a procédé à la création de l'utilisateur: ".$usr->username." ".$usr->name." ".$usr->prenoms." ." ;
			Activity::saveActivity($module,$action);
/*
			@Mail::send('emails.welcome',$user, function($message) use($user) {
				$message->from('ne-pas-repondre@tinitz.cloud','')->to($user['email'])->subject('Vos accès de connexion');
			});*/

			session()->flash('type', 'is-success');
			session()->flash('message', 'Utilisateur crée avec succès');
			return redirect()->route('users.index');
		}else{
			session()->flash('type', 'is-danger');
			session()->flash('message', 'Une erreur s\'est produite à la création, veuillez réessayer');
			return back();
		}
	}




	public function edit(Request $request){


		$data['olduser'] = User::where(['id' => htmlspecialchars($request->id)])->first();
		if(empty($data['olduser'])){
			session()->flash('type', 'is-danger');
            session()->flash('message', 'Utilisateur introuvable');
			return back();
		}
		$data['title'] = "Modifier un utilisateur - ";

		//For activity
			$module = 'Utilisateur';
			$action = " a affiché la page de modification de l'utilisateur: ".$data['olduser']->username." ".$data['olduser']->name." ".$data['olduser']->prenoms." ." ;
			Activity::saveActivity($module,$action);

		return view('users.edit',$data);
	}

	public function update(Request $request){

		$this->validate(request(),[
		      "id" => "required|integer",
			  "nom" => "required",
			  //"username" => "nullable|unique:users",
			  "avatar" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
			  "prenoms" => "required",
			  //"email" => "nullable|email|max:255|unique:users",
			  "adresse" => "required",
			  "fonction" => "required",
			  "telephone" => "required",
			  //"datedebut" => "required|date",
			  //"statut" => "required|integer",
			  "espace" => "required|integer",
			  "role" => "required",
			  'password' => 'nullable|same:password_confirmation|min:6',
		]);


		$id = htmlspecialchars($request->id);
		$user=User::where([ 'id' => $id ])->first();

		if(!$user){
			session()->flash('type', 'is-danger');
            session()->flash('message', 'Utilisateur introuvable');
			return back();
		}

		$data["name"] = htmlspecialchars($request->nom);
		$data["prenoms"] = htmlspecialchars($request->prenoms);
		$data["fonction"] = htmlspecialchars($request->fonction);
		$data["country_id"] = htmlspecialchars($request->pays);
		$data["ville"] = htmlspecialchars($request->ville);
		$data["telephone"] = htmlspecialchars($request->telephone);
		$data["fonction"] = htmlspecialchars($request->fonction);
		$data["adresse"] = htmlspecialchars($request->adresse);
		$data["role"] = htmlspecialchars($request->role);
		//$data["datedebut"] = htmlspecialchars($request->datedebut);
		$data["espace_id"] = htmlspecialchars($request->espace);

		if($request->password){
			$data["password"] = Hash::make($request->password);
		}

        /*
		if(file_exists($request->file('avatars'))){
            $extension = pathinfo($request->file('avatars')->getClientOriginalName(), PATHINFO_EXTENSION);
            $newName = Carbon::now()->timestamp.'.'.$extension;
            $upload_path = 'img/avatars/';
            if($request->file('avatars')->move($upload_path, $newName)){
                $data['avatar']  = "https://".$_SERVER['SERVER_NAME'].'/img/avatars/'.$newName;
            }
        }
		*/


		if($user->update($data)){

			//For activity
			$module = 'Utilisateur';
			$action = " a procédé à la modification de l'utilisateur: ".$user->username." ".$user->name." ".$user->prenoms." ." ;
			Activity::saveActivity($module,$action);

			session()->flash('type', 'is-success');
			session()->flash('message', 'Utilisateur modifié avec succès');
			return redirect()->route('users.index');
		}else{
			session()->flash('type', 'is-danger');
			session()->flash('message', 'Erreur lors de la modification');
			return back();
		}

	}


	public function editstate(Request $request){
        $id = htmlspecialchars($request->id);
		$user = User::where(['id' => $id])->first();

        if(!$user){
			session()->flash('type', 'is-danger');
            session()->flash('message', 'Utilisateur introuvable');
			return back();
        }else{
			if($user->statut==1){
                $user->statut =0;
                $user->save();

				//For activity
				$module = 'Utilisateur';
				$action = " a procédé à la désactivation  de l'utilisateur: ".$user->username." ".$user->name." ".$user->prenoms." ." ;
				Activity::saveActivity($module,$action);

                session()->flash('type', 'is-success');
                session()->flash('message', 'Compte utilisateur désactivé avec succès');
                return redirect()->route('users.index');
            }else{
                $user->statut =1;
                $user->save();

				//For activity
				$module = 'Utilisateur';
				$action = " a procédé à l'activation de l'utilisateur: ".$user->username." ".$user->name." ".$user->prenoms." ." ;
				Activity::saveActivity($module,$action);

                session()->flash('type', 'is-success');
                session()->flash('message', 'Compte utilisateur activé avec succès');
                return redirect()->route('users.index');
            }
		}

    }

	public function destroy(Request $request){
        //
        $id = htmlspecialchars($request->id);
        $user = User::where(['id' => $id])->first();

        if(!$user){

			session()->flash('type', 'is-danger');
			session()->flash('message', "Utilisateur introuvable");
			return back();
		}else{
			$user->delete();

			//For activity
			$module = 'Utilisateur';
			$action = " a procédé à la suppression de l'utilisateur: ".$user->username." ".$user->name." ".$user->prenoms." ." ;
			Activity::saveActivity($module,$action);

            session()->flash('type', 'is-success');
			session()->flash('message', 'Utilisateur supprimé avec succès');
			return back();
		}
    }

	public function show(Request $request){

		$data['user'] = User::where(['id' => $request->id ])->with('pays')->first();
		if(!$data['user']){
			session()->flash('type', 'is-danger');
            session()->flash('message', 'Utilisateur introuvable');
			return back();
        }

		$data['title'] = "Profil utilisateur - ";
		$data['logs'] = Activity::where(['user_id' => $data['user']->id ])->paginate(250);

			//For activity
			$module = 'Utilisateur';
			$action = " a consulté le profil de l'utilisateur: ".$data['user']->username." ".$data['user']->name." ".$data['user']->prenoms." ." ;
			Activity::saveActivity($module,$action);
		return view('users.show',$data);
	}

	public function monprofil(Request $request){

		$data['olduser'] = User::where(['id' => Auth::user()->id])->first();
		if(!$data['olduser']){
			session()->flash('type', 'is-danger');
            session()->flash('message', 'Utilisateur introuvable');
			return back();
        }
		$data['title'] = "Mon profil - ";
		$data['menu'] = "profile";
		//For activity
			$module = 'Utilisateur';
			$action = " a consulté son profil utilisateur." ;
			Activity::saveActivity($module,$action);
		return view('users.profile',$data);
	}

	public function updateProfile(Request $request){

		$this->validate(request(),[
			  "nom" => "required",
			  "username" => "nullable",
			  "avatar" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
			  "prenoms" => "required",
			  "adresse" => "required",
			  "fonction" => "required",
			  "pays" => "required",
			  "ville" => "required",
			  "telephone" => "required",
		]);

		if (User::where('id', '!=', Auth::id())->where(['username' => $request->username])->first()) {
			session()->flash('type', 'is-danger');
			session()->flash('message', 'Le login est déjà utilisé, veuillez renseigner un autre svp.');
			return back();
		}

		$data["username"] = htmlspecialchars($request->username);
		$data["name"] = htmlspecialchars($request->nom);
		$data["prenoms"] = htmlspecialchars($request->prenoms);
		$data["fonction"] = htmlspecialchars($request->fonction);
		$data["country_id"] = htmlspecialchars($request->pays);
		$data["ville"] = htmlspecialchars($request->ville);
		$data["telephone"] = htmlspecialchars($request->telephone);
		$data["adresse"] = htmlspecialchars($request->adresse);
        if(file_exists($request->file('avatars'))){
            $extension = pathinfo($request->file('avatars')->getClientOriginalName(), PATHINFO_EXTENSION);
            $newName = Carbon::now()->timestamp.'.'.$extension;
            $upload_path = 'img/avatars/';
            if($request->file('avatars')->move($upload_path, $newName)){
                $data['avatar']  = "https://".$_SERVER['SERVER_NAME'].'/img/avatars/'.$newName;
            }
        }

		if(User::where([ 'id' => Auth::user()->id ])->update($data)){

			//For activity
			$module = 'Utilisateur';
			$action = " a procédé à la mise a jour de son profil utilisateur." ;
			Activity::saveActivity($module,$action);

			session()->flash('type', 'is-success');
			session()->flash('message', 'Modification effectuées avec succès');

			return back();
		}else{
			session()->flash('type', 'is-danger');
			session()->flash('message', 'Erreur lors de la modification');
			return back();
		}

	}


	public function monpassword(Request $request){
		$data['title'] = "Mon mot de passe - ";
		$data['page_description'] = " - Modifier mon mot de passe";
		$data['menu'] = "profile";
		return view('users.password',$data);
	}

	public function updatePassword(Request $request){

		$this->validate(request(),[
			'password' => 'required|confirmed|min:6',
			'password_confirmation' => 'required|min:6|same:password',
		]);

		$data['password'] = htmlspecialchars(Hash::make($request->password));

		if(User::where([ 'id' => Auth::user()->id ])->update($data)){
			session()->flash('type', 'is-success');
			session()->flash('message', 'Modification effectuées avec succès');
			Auth::logout();
			return redirect()->route('login');
		}else{
			session()->flash('type', 'is-danger');
			session()->flash('message', 'Erreur lors de la modification');
			return back();
		}

	}

}
