<?php
namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Employe;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Departement;
use App\Models\Service;
use App\Models\Typeconge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Http\helper;
use PDF;

class PermissionController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
        View::share( 'menu', 'Permissions' );
        View::share( 'sousmenu', 'permission' );
        View::share('employes', Employe::all());
        View::share('departements', Departement::where('status', 1)->get());
        View::share('services', Service::where('status', 1)->get());
        View::share('typeconges', Typeconge::where('status', 1)->get());
    }

    public function index(){
        $data['title'] = "Liste des permissions - ";
        $data['section_title'] = "Liste des permissions";
        $data['permissions'] = Permission::orderBy('created_at', 'desc')->paginate(100);

        //For activity
        $module = 'Permission';
        $action = " a consulté la liste des permissions." ;
        Activity::saveActivity($module,$action);

        return view('permissions.index', $data);
    }

    public function created(){
        $data['title'] = "Ajouter une permission - ";
        $data['section_title'] = "Ajouter une permission";

        return view('permissions.create', $data);
    }

    public function store(Request $request){
        $messages = [
            'employe.required' => "L'employé est obligatoire ",
            'debut.required' => 'La date de début est obligatoire',
            'fin.required' => 'La date de fin est obligatoire',
            'motif.required' => 'Le motif est obligatoire',

        ];

        $request->validate([
           'employe' => 'required|integer',
//           'typeconge' => 'required|integer',
           'motif' => 'required',
           'description' => 'nullable',
           'debut' => 'required|date',
           'fin' => 'required|date',

        ],$messages);

        if(!$employe = Employe::find($request->employe)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Employé introuvable');
            return back();
        }

        if ($request->hasFile('file')){
            $imageUrl = storeImage($request->file);
        }


        $permission =new Permission();
        $permission->employe_id= $employe->id;
        $permission->debut= htmlspecialchars($request->debut);
        $permission->fin= htmlspecialchars($request->fin);
        $permission->motif=htmlspecialchars($request->motif);
        $permission->description=htmlspecialchars($request->description);
        $permission->file = $imageUrl ?? null;
        $permission->status = 0;
        $permission->created_by = Auth::user()->name.' '.Auth::user()->prenoms;
        $permission->accord1=htmlspecialchars($request->accord1);
        $permission->accord2=htmlspecialchars($request->accord2);
        $permission->accord_drh=htmlspecialchars($request->accord_drh);
        $permission->type_conge=htmlspecialchars($request->type_conge);
        $permission->accord_dfc=htmlspecialchars($request->accord_dfc);
        $permission->save();

        //For activity
        $module = 'Permission';
        $action = " a procédé à la création d'une permission de l'employé {$employe->firstname} {$employe->lastname}.";
        Activity::saveActivity($module,$action);

        session()->flash('type', 'is-success');
        session()->flash('message', 'Permission enregistrée avec succès');
        return redirect()->route('permissions.index');
    }

    public function show(Request $request){
        if (!$data['permission'] = Permission::find($request->id)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Permission introuvable');
            return back();
        }

        $data['title'] = "Détails d'une permission - ";
        $data['section_title'] = "Détails d'une permission";

        return view('permissions.show', $data);
    }

    public function edit(Request $request){
        if (!$data['permission'] = Permission::find($request->id)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Permission introuvable');
            return back();
        }

        $data['title'] = "Modifier une permission - ";
        $data['section_title'] = "Modifier une permission";

        return view('permissions.edit', $data);
    }

    public function update(Request $request){
        $request->validate([
            'permission' => 'required|integer',
            'employe' => 'required|integer',
            'motif' => 'required',
            'description' => 'nullable',
            'debut' => 'required|date',
            'fin' => 'required|date',
        ]);

        if(!$permission = Permission::find($request->permission)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Permission introuvable');
            return back();
        }

        if(!$employe = Employe::find($request->employe)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Employé introuvable');
            return back();
        }

        if ($request->hasFile('file')){
            $imageUrl = storeImage($request->file);
        }

        $permission->employe_id=$employe->id;
        $permission->debut=htmlspecialchars($request->debut);
        $permission->fin=htmlspecialchars($request->fin);
        $permission->motif=htmlspecialchars($request->motif);
        $permission->description=htmlspecialchars($request->description);
        $permission->file=$imageUrl ?? null;
        $permission->status=0;
        $permission->accord1=htmlspecialchars($request->accord1);
        $permission->accord2=htmlspecialchars($request->accord2);
        $permission->accord_drh=htmlspecialchars($request->accord_drh);
        $permission->type_conge=htmlspecialchars($request->type_conge);
        $permission->accord_dfc=htmlspecialchars($request->accord_dfc);
        $permission->save();

        //For activity
        $module = 'Permission';
        $action = " a procédé à la modification d'une permission de l'employé {$employe->firstname} {$employe->lastname}.";
        Activity::saveActivity($module,$action);

        session()->flash('type', 'is-success');
        session()->flash('message', 'Permission modifiée avec succès');
        return redirect()->route('permissions.index');
    }

    public function destroy(Request $request){
        if (Permission::find($request->id)->delete()){
            session()->flash('type', 'is-success');
            session()->flash('message', 'Permission supprimée avec succès.');
            return back();
        }else{
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Une erreur s\'est produite, veuillez rééssayer svp.');
            return back();
        }
    }

    public function changeStatus(Request $request){
        $type = htmlspecialchars($request->type);
        $id = htmlspecialchars($request->id);
        
        if (!$permission = Permission::find($id)){
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Une erreur s\'est produite, la permission est introuvable.');
            return back();
        }
        
        if ($type === "decline"){
            $statusUpdate = 2;
            $msg = "La permission a bien été refusée";
        }elseif ($type === "validate"){
            $statusUpdate = 2;
            $msg = "La permission a bien été validée";
        }else{
            abort(404);
        }

        if ($permission->update(['status' => $statusUpdate])){
            session()->flash('type', 'is-success');
            session()->flash('message', $msg);
            return back();
        }else{
            session()->flash('type', 'is-danger');
            session()->flash('message', 'Une erreur s\'est produite, veuillez rééssayer svp.');
            return back();
        }
    }

    public function showPdf(Request $request)
    {

        $permission=Permission::findOrFail($request->id);
        $emplye=Employe::findOrFail($permission->employe_id);
//        dd($emplye);
        $direction=Departement::find($emplye->departement_id);
        if(!$direction) {
            $direction=null;
        }else{
            $direction=$direction->libelle;
        }
        $date1=strtotime($permission->debut);
        $date2=strtotime($permission->fin);
        $temps=$this->dateDiff($date1,$date2);
       

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('permissions.show',['permission' => $permission,'employe'=>$emplye,'direction'=>$direction,'temps'=>$temps]);
          $name = "detail_permission.pdf";
        return $pdf->stream($name);
    }

    //Search permission
    public function search(Request $request){
        $permission = Permission::query();

        $request->employe ? $permission->where('employe_id', $request->employe) : '';
        $request->departement ? $permission->whereHas('employe', function ($q) use($request){
            $q->where('departement_id', $request->departement);
        }) : '';
        $request->service ? $permission->whereHas('employe', function ($q) use($request){
            $q->where('service_id', $request->service);
        }) : '';

        $request->motif ? $permission->where('motif', 'LIKE', '%'.$request->motif.'%') : '';

        $request->debut ? $permission->where('debut', '>=', $request->debut) : '';
        $request->fin ? $permission->where('debut', '<=', $request->debut) : '';



        //Exportation en pdf
        if ($request->export){
            $data['permissions'] = $permission->orderByDesc('created_at')->get();
            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                ->loadView('permissions.pdf', $data);
            $name = "permissions.pdf";
            return $pdf->stream($name);
        }

        $data['permissions'] = $permission->orderByDesc('created_at')->paginate(100)->withQueryString();
        $data['title'] = "Liste des permissions trouvées - ";
        $data['section_title'] = "Liste des permissions trouvées";

        //For activity
        $module = 'Permission';
        $action = " a éffectué une recherche de permissions." ;
        Activity::saveActivity($module,$action);

        return view('permissions.index', $data);
    }

    function dateDiff($date1, $date2){

        $diff = abs($date1 - $date2); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
        $retour = array();

        $tmp = $diff;
//        dd($diff);
        $retour['second'] = $tmp % 60;

        $tmp = floor( ($tmp - $retour['second']) /60 );
        $retour['minute'] = $tmp % 60;

        $tmp = floor( ($tmp - $retour['minute'])/60 );
        $retour['hour'] = round(($date2- $date1) / 3600);

        $tmp = floor( ($tmp - $retour['hour'])  /24 );
        $retour['day'] = round(($date2- $date1) / 86400);


        return $retour;
    }
}