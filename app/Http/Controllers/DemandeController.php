<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Demande;
use App\Administrateur;

class DemandeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new Demande.
     *
     * @return \Illuminate\Http\Response
     */
    public function addDemande ()
    {
        $data['page_title'] = "Tinitz - Faire une demande";
        $data['page_description'] = "Tinitz est une startup spécialisée dans la Technologie Intelligente. Nous offrons différents services dont la domotique, le Tracking de véhicule, le céblage réseaux, la conception d'application Mobile et Web, la gestion de réseaux sociaux, la production de vidéo corporative, la gestion de campagne publicitaire et bien plus. Nous vous accompagnons dans vos besoins d'innovation.";
        $data['menu'] = "demande";

        return view('demandes.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createDemande(Request $request)
    {
        $now = Carbon::now();
        $demandesDuMois = DB::table("demandes")
            ->whereRaw('admin_id = ? AND YEAR(datedebut) = ? AND MONTH(datedebut) = ? AND statut = ?',
                [auth()->user()->id, $now->year, $now->month, 'acceptee'])
            ->count();
        if($demandesDuMois >= 2)
        {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Vous ne pouvez effectuer plus de 2 demandes d'absence\congé dans le mois");
            return back()->withInput($request->input());
        }

        $validator = Validator::make($request->all(), [
            "type" => "required",
            'attachments' => 'nullable',//mimes:pdf,jpeg,bmp,png
            "motifdemande" => "required",
            "datedebut" => "required|date|after:yesterday",
            "datefin" => "required|date|after:datedebut",
        ]);
        if($validator->fails())
        {
            session()->flash('type', 'alert-danger');
            session()->flash('message', 'Erreur dans le formulaire');
        }

        $demande = Demande::create([
            'type' => htmlspecialchars($request->type),
            'motifdemande' => htmlspecialchars($request->motif),
            'datedebut' => htmlspecialchars($request->datedebut),
            'datefin' => htmlspecialchars($request->datefin),
            "admin_id" => auth()->user()->id,
        ]);

        if($request->hasfile('attachments'))
        {
            $extension = pathinfo($request->file('attachments')->getClientOriginalName(), PATHINFO_EXTENSION);
            $newName = 'demande' . '-' . auth()->user()->id . '-' . Carbon::now()->timestamp . ".".$extension;
            $upload_path = 'docs/';
            if($request->file('attachments')->move($upload_path, $newName))
            {
                $demande->update([
                    'attachments' => $newName,
                ]);
            }
        }
        $msg['demande'] = $demande;
        $msg['user'] = auth()->user()->nom  . ' ' .auth()->user()->prenoms ;
        $msg['admin'] = Administrateur::where('role','admin')->pluck('email');
        $msg['type'] = htmlspecialchars($request->type);
        $msg['motif'] = htmlspecialchars($request->motif);
        $msg['datedebut'] = htmlspecialchars($request->datedebut);
        $msg['datefin'] = htmlspecialchars($request->datefin);

        foreach(  $msg['admin'] as $msg['admins']) {

            @Mail::send('emails.demande', $msg, function ($message) use ($msg) {
                $message->from('service@tinitz.com', 'Demande d\'absence')->to($msg['admins'])->subject("Demande d'absence");
            });
        }
        session()->flash('type', 'alert-success');
        session()->flash('message', "Demande d'absence soumise avec succés!");

        return back();

    }

    public function listeDemande(Request $request)
    {
        $data['page_title'] = "Tinitz - Lises des absences";
        $data['page_description'] = "Tinitz est une startup spécialisée dans la Technologie Intelligente. Nous offrons différents services dont la domotique, le Tracking de véhicule, le céblage réseaux, la conception d'application Mobile et Web, la gestion de réseaux sociaux, la production de vidéo corporative, la gestion de campagne publicitaire et bien plus. Nous vous accompagnons dans vos besoins d'innovation.";
        $data['menu'] = "demande";

        $employe = htmlspecialchars($request->employe);
        $type = htmlspecialchars($request->type);
        $statut = htmlspecialchars($request->statut);
        $dateMin = htmlspecialchars($request->datedebut);
        $dateMax = htmlspecialchars($request->datefin);

        $data['employe'] = $employe;
        $data['type'] = $type;
        $data['statut'] = $statut;
        $data['datedebut'] = $dateMin;
        $data['datefin'] = $dateMax;

        $data['types'] = ['absence', 'conge'];
        $data['admins'] = Administrateur::all()->sortBy('prenoms', 0);
        $data['statuts'] = ['acceptee', 'refusee', 'enattente'];

        if($employe && $type && $statut && $dateMin && $dateMax && Auth::user()->role == "admin")
        {
            //phase 1

            if($employe == 'tous' && $type == 'tous' && $statut == 'tous')
            {
                //$data['demandes'] = Demande::whereDate('datedebut', '>=', $dateMin)->whereDate('datefin', '<=', $dateMax)
                $data['demandes'] = Demande::orderBy('id','DESC')->paginate(50);
            }
            elseif($employe != 'tous' && $type == 'tous' && $statut == 'tous')
            {
                $data['demandes'] = Demande::where(['admin_id' => $employe])
                    //->whereDate('datedebut', '>=', $dateMin)->whereDate('datefin', '<=', $dateMax)->orderBy('id','DESC')
                    ->paginate(50);
            }
            elseif($employe == 'tous' && $type != 'tous' && $statut == 'tous')
            {
                $data['demandes'] = Demande::where(['type' => $type])
                    //->whereDate('datedebut', '>=', $dateMin)->whereDate('datefin', '<=', $dateMax)->orderBy('id','DESC')
                    ->paginate(50);
            }
            elseif($employe == 'tous' && $type == 'tous' && $statut != 'tous')
            {
                $data['demandes'] = Demande::where(['statut' => $statut])
                    //->whereDate('datedebut', '>=', $dateMin)->whereDate('datefin', '<=', $dateMax)
                    ->orderBy('id','DESC')->paginate(50);
            }

            //phase 2

            elseif($employe != 'tous' && $type != 'tous' && $statut == 'tous')
            {
                $data['demandes'] = Demande::where(['admin_id' => $employe, 'type' => $type])
                    //->whereDate('datedebut', '>=', $dateMin)->whereDate('datefin', '<=', $dateMax)
                    ->orderBy('id','DESC')->paginate(50);
            }
            elseif($employe != 'tous' && $type == 'tous' && $statut != 'tous')
            {
                $data['demandes'] = Demande::where(['admin_id' => $employe, 'statut' => $statut])
                    //->whereDate('datedebut', '>=', $dateMin)->whereDate('datefin', '<=', $dateMax)
                    ->orderBy('id','DESC')->paginate(50);
            }
            elseif($employe == 'tous' && $type != 'tous' && $statut != 'tous')
            {
                $data['demandes'] = Demande::where(['type' => $type, 'statut' => $statut])
                    //->whereDate('datedebut', '>=', $dateMin)->whereDate('datefin', '<=', $dateMax)
                    ->orderBy('id','DESC')->paginate(50);
            }
            elseif($employe != 'tous' && $type != 'tous' && $statut != 'tous')
            {
                $data['demandes'] = Demande::where(['admin_id' => $employe, 'type' => $type, 'statut' => $statut])
                    //->whereDate('datedebut', '>=', $dateMin)->whereDate('datefin', '<=', $dateMax)
                    ->orderBy('id','DESC')->paginate(50);
            }
        }
        elseif(Auth::user()->role == "admin")
        {
            $data["demandes"] = Demande::with('demandeur')->orderBy('id','DESC')->paginate(50);
        }
        else
        {
            $data["demandes"] = Demande::orderBy('id','DESC')->where([ 'admin_id' => Auth::user()->id ])->paginate(50);
        }

        return view('demandes.liste', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function viewDemande ($id)
    {

        $data['page_title'] = "Tinitz - Voir Demande";
        $data['page_description'] = "Tinitz est une startup spécialisée dans la Technologie Intelligente. Nous offrons différents services dont la domotique, le Tracking de véhicule, le céblage réseaux, la conception d'application Mobile et Web, la gestion de réseaux sociaux, la production de vidéo corporative, la gestion de campagne publicitaire et bien plus. Nous vous accompagnons dans vos besoins d'innovation.";
        $data['menu'] = "demande";
        $demande = Demande::where('id', $id)->first();
        $data['demande'] = $demande;

        $now = Carbon::now();
        $data['demandesDuMois'] = DB::table("demandes")
            ->whereRaw('admin_id = ? AND YEAR(datedebut) = ? AND MONTH(datedebut) = ? AND statut = ?',
                [\auth()->user()->id, $now->year, $now->month, 'acceptee'])
            ->count();

        return view('demandes.voir', $data);

    }

    public function accepterDemande($id, Request $request)
    {
        $demande = Demande::findOrFail($id);
        $demande->update([
            'statut' => 'acceptee',
            'motifdecision' => htmlspecialchars($request->motifdecision),
            'answered_by' => auth()->user()->id,
        ]);

        $msg['demandeur']=$demande->demandeur->email;
        $msg['sender'] = $demande;

        @Mail::send('emails.demandeaccepte', $msg, function ($message) use ($msg) {
            $message->from('service@tinitz.com', 'Demande d\'absence')->to( $msg['demandeur'])->subject("Demande d'absence accepté");
        });

        session()->flash('type', 'alert-success');
        session()->flash('message', "Demande accpetée avec succés!");

        return back();
    }

    public function refuserDemande($id, Request $request)
    {
        $demande = Demande::findOrFail($id);
        $demande->update([
            'statut' => 'refusee',
            'motifdecision' => htmlspecialchars($request->motifdecision),
            'answered_by' => auth()->user()->id,
        ]);

        $msg['demandeur']=$demande->demandeur->email;
        $msg['sender'] = $demande;

        @Mail::send('emails.demanderefuser', $msg, function ($message) use ($msg) {
            $message->from('service@tinitz.com', 'Demande d\'absence')->to( $msg['demandeur'])->subject("Demande d'absence réfusé");
        });

        session()->flash('type', 'alert-danger');
        session()->flash('message', "Demande d'absence refusée avec succés!");

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editDemande ($id)
    {
        $data['page_title'] = "Tinitz - Modifier Demande";
        $data['page_description'] = "Tinitz est une startup spécialisée dans la Technologie Intelligente. Nous offrons différents services dont la domotique, le Tracking de véhicule, le câblage réseaux, la conception d'application Mobile et Web, la gestion de réseaux sociaux, la production de vidéo corporative, la gestion de campagne publicitaire et bien plus. Nous vous accompagnons dans vos besoins d'innovation.";
        $data['menu'] = "demande";
        $demande = Demande::where('id', $id)->first();
        if($demande->statut == 'acceptee')
        {
            session()->flash('type', 'alert-danger');
            session()->flash('message', "Vous ne pouvez plus modifier cette demande.");

            return back();
        }
        $data['demande'] = $demande;

        return view('demandes.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDemande(Request $request)
    {
        $this->validate(request(),[
            "demande_id" => "required",
            "type" => "required",
            'attachments' => 'nullable',//mimes:pdf,jpeg,bmp,png
            "motifdemande" => "required",
            "datedebut" => "required|date|after:yesterday",
            "datefin" => "required|date|after:datedebut",
        ]);

        $demande = Demande::where('id', htmlspecialchars($request->demande_id))->firstOrFail();
        $demande->update([
            'type' => htmlspecialchars($request->type),
            'motifdemande' => htmlspecialchars($request->motifdemande),
            'datedebut' => htmlspecialchars($request->datedebut),
            'datefin' => htmlspecialchars($request->datefin),
        ]);

        if($request->hasfile('attachments'))
        {
            $extension = pathinfo($request->file('attachments')->getClientOriginalName(), PATHINFO_EXTENSION);
            $newName = 'demande' . '-' . auth()->user()->id . '-' . Carbon::now()->timestamp . ".".$extension;
            $upload_path = 'docs/';
            if($request->file('attachments')->move($upload_path, $newName))
            {
                //suppression de l'ancien fichier
                if(!empty($demande->attachments))
                {
                    Storage::disk('local')->delete('docs/'.$demande->attachments);
                }
                $demande->update([
                    'attachments' => $newName,
                ]);
            }
        }

        session()->flash('type', 'alert-success');
        session()->flash('message', 'Demande mise à jour avec succés!');

        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteDemande ($id)
    {
        Demande::destroy($id);

        return redirect('/demandes/liste');
    }


}
