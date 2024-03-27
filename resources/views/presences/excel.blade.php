<table  id="example" class="" style="width:100%">
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
        @endphp
         <tr style="{{ $duree === 0 ? 'background:#ff00008c;color:#fff' : '' }}">
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
    </tbody>
</table>