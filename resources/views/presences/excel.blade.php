<table  id="example" class="" style="width:100%">
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
        <tr style="{{ (empty($presence->checkIn) || empty($presence->checkOut)) ? 'background:#ff00008c;color:#fff' : '' }}">
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