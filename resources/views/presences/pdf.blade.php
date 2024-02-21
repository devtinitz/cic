<!DOCTYPE html>
<html>
<head>
    <style>
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 10px;
            margin-top: 20px;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 10px 5px;
            font-size: 14px;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #676968;
            color: white;
        }

        table{
            margin: 0px;
            padding: 0px;
            font-size: 14px;
        }

        table.header{
            font-size: 15px;
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
        }

        .header h2{
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header-last{
            width: 100%;
            border-collapse: collapse;
        }
        .header-last thead tr{
            background-color: {{ $setting->companycolor }};
            color: #fff;
        }

        .header-last thead tr th{
            padding: 10px;
            font-size: 18px;
        }

        .header-last td{
            padding: 10px;
        }

        img{
            width: 90px;
            height: 90px;
        }
    </style>
</head>
<body>
<table class="header" cellpadding="0" border="1" style="border: 0px !important;margin: 0px">
    <tr>
        <td style="width: 15% !important; border: none !important; class="">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($setting->companylogo))) }}" alt="{{ $setting->companyname }}">
        </td>
        <td style="width: 100% !important; text-align: center">
            <h2 style="text-align: center">LISTE DES PRESENCES</h2>
        </td>
    </tr>
</table>
<div class="logo" style="margin-top: 20px">
    <span style="">Date : {{ date('d/m/Y') }}</span>
    <span style="position: absolute; right: 0"><strong>Total :</strong>{{ $total }}</span>
</div>
<table id="customers" style="width: 100%">
    <thead>
        <tr class="table100-head">
            <td>Date</td>
            <th>Employé</th>
            <th>Direction</th>
            <th>Arrivée</th>
            <th>Départ</th>
            <th>Absence</th>
            <th>Temps de travail</th>
            <th>Heure(s) Sup</th>
        </tr>
        </thead>
        <tbody>
        @foreach($presences as $presence)
            @php
                //On verifie si le pointage est effectué
                if (empty($presence->checkIn) || empty($presence->checkOut)){
                    $statut = 'Absent';
                    $duree = 0;
                    $tempSup = 0;
                }else{
                    // On convertie les heures de début et de fin de pointage en objets Carbon
                    $heureDebutPointage = \Carbon\Carbon::parse($presence->checkIn);
                    $heureFinPointage = \Carbon\Carbon::parse($presence->checkOut);
    
                    //On calcule et formate la duree de presence
                    $duree = $heureDebutPointage->diffInMinutes($heureFinPointage);
    
                    // On convertie les heures de début et de fin de travail en objets Carbon
                    $heureDebut = \Carbon\Carbon::parse($setting->debut_matin);
                    $heureFin = \Carbon\Carbon::parse($setting->fin_soir);
    
                    // On initialise le temps supplémentaire à 0 secondes
                    $tempsSupplementaire = 0;
    
                    // On calcule le temps supplémentaire le matin (avant l'heure de début)
                    if ($heureDebutPointage->lt($heureDebut)) {
                        $tempsSupplementaire += $heureDebutPointage->diffInMinutes($heureDebut);
                    }
    
                    // On calcule le temps supplémentaire le soir (après l'heure de fin)
                    if ($heureFinPointage->gt($heureFin)) {
                        $tempsSupplementaire += $heureFinPointage->diffInMinutes($heureFin);
                    }
    
                    // Formatage du temps supplémentaire
                    $tempSup = $tempsSupplementaire;
                }
            @endphp
            <tr>
                <td>{{ date('d/m/Y', strtotime($presence->date)) }}</td>
                <td>{{ ucfirst($presence->employe->firstname ?? '').' '.ucfirst($presence->employe->lastname ?? '') }}</td>
                <td>{{ ucfirst($presence->departement->libelle ?? '') }}</td>
                <td>
                    {{ $presence->checkIn ?? 'Aucun' }}
                </td>
                <td>{{ $presence->checkOut ?? 'Aucun' }}</td>
                <td>
                    @if (empty($presence->checkIn) && empty($presence->checkOut))
                        Aucun
                    @elseif (empty($presence->checkIn) || empty($presence->checkOut))
                        Oui
                    @else
                        Non
                    @endif
                </td>
                <td>{{ $duree.' min'  }}</td>
                <td>{{ $tempSup.' min' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
