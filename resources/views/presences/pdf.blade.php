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
            <th>Date</td>
            <th>Employé</th>
            <th>Direction</th>
            <th>Arrivée</th>
            <th>Départ</th>
            <th>Temps de travail</th>
            <th>Heure(s) Sup</th>
        </tr>
        </thead>
        <tbody>
        @php
            $presenceChunks = $presences->chunk(500);
        @endphp
        @foreach ($presenceChunks as $presences)
            @foreach($presences as $presence)
            @php
                $temp = 0;
                $duree = 0;
                // On convertie les heures de début et de fin de pointage en objets Carbon
                $heureDebutPointage = \Carbon\Carbon::parse(date('H:i:s', strtotime($presence->first_scan)));
                $heureFinPointage = \Carbon\Carbon::parse(date('H:i:s', strtotime($presence->last_scan)));
                

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
                //dd($duree, $tempSup);
            @endphp
                <tr>
                    <td>{{ date('d/m/Y', strtotime($presence->authDate)) }}</td>
                    <td>{{ ucfirst($presence->personName ?? '') }}</td>
                    <td>{{ ucfirst($presence->deviceName ?? '') }}</td>
                    <td>
                        {{ $presence->first_scan ?? 'Aucun' }}
                    </td>
                    <td>{{ $presence->last_scan ?? 'Aucun' }}</td>
                    <td>{{ $duree.' min'  }}</td>
                    <td>{{ $tempSup.' min' }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

</body>
</html>
