<?php

namespace App\Imports;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\Employe;
use App\Models\Departement;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployerImport implements ToModel,WithValidation,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = Auth::user();
        $departement=Departement::where('libelle',$row['direction'])->first();

//        return  dd($departement);
        if ($departement)
        {
            $depart_id=$departement->id;
        }else
        {
            $departement=new Departement();
            $departement->libelle=$row['direction'];
            $departement->created_by=$user->name.' '.$user->prenoms ;
            $departement->status = 1;
            $departement->save();
            $depart_id=$departement->id;
        }

//        $contact=str_replace(' ', '', $row['contact']);
//        if (strlen($contact)!=10)
//        {
//            $contact='0'.$contact;
//        }
        return new Employe([

            'firstname'=>$row['nom'],
            'lastname'=>$row['prenom'],
            'contact'=>$row['contact'],
            'email'=>$row['email'],
            'civilite'=>isset($row['civilite'])?$row['civilite']:'',
            'created_by'=>$user->email,
            'departement_id'=>$depart_id,
            'poste'=>$row['fonction'],
//            'matricule'=>$row['EMAIL'],
//            'cnps'=>$row['EMAIL'],
//            'matricule'=>$row['EMAIL'],
            //
        ]);
    }


    public function customValidationMessages()
    {
        return [
//            'nom.required' => 'Veuillez renseigner le ou les nom(s) de vos contacts',
//            'compte.required' => 'Le compte est obligatoire',
//            'prenom.required' => 'Le prenom est obligatoire',
//            'contact.numeric' => 'Le contact est obligatoire',
//            'salaire.numeric' => 'Le salaire est obligatoire',
//            'compte.digits_between' => 'Les compte doivent être compris entre 11 et 20 chiffres ',

        ];
    }
    public function rules(): array
    {
        return [
//            'nom' => 'required|string',
//            'prenom' => 'required|string',
//            'compte' => 'required|numeric',
//            'contact' => 'required|numeric',
//            'salaire' => 'required|numeric',
        ];
    }
}
