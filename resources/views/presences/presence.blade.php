@extends('template')
@section('content')
    <div class="page-content-inner">
        <div class="profile-wrapper">
            <!--Breadcrumb-->
        @include('layouts.breadcrumb')
        <!--Edit Profile-->
            <div class="account-wrapper">
                <div class="columns">
                    <div class="column is-3">
                        @include('presences.menugauche')
                    </div>
                    <div class="column is-9">
                        @include('layouts.flashmessage')
                        <div class="account-box is-form">
                            <div class="form-head">
                                <div class="form-head-inner">
                                    <div class="left">
                                        <h3>{{$section_title}}</h3>
                                        <p><i class="lnil lnil-warning"></i> Cette section est réservée pour afficher la liste des pointages.</p>
                                    </div>
                                    <div class="right">
                                        <div class="buttons">
                                            @include('parts.precedent')
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-body">
                                <div class="s-card demo-table column.is-half">
                                    <div class="form-fieldset p-0 mb-3 row">
                                        <div class="col-md-12">
                                            <span style="font-size: 14px; font-weight: 600">Total : {{ $presences->total() }}</span>
                                            <div class="buttons mt-4">
                                                <a class="button h-button is-elevated text-white h-modal-trigger" data-modal="searchPresence" style="background-color: {{$setting->companycolor}} !important;" href="#">
                                                  <span class="icon">
                                                      <i class="lnil lnil-users"></i>
                                                  </span>
                                                    <span>Rechercher de pointages</span>
                                                </a>
                                            
                                            </div>
                                        </div>

                                    </div>
                                    <div class="table100">
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
                                    </div>
                                </div>
                                @include('paginations.default', ['paginator' => $presences ])
                            </div>
                        </div>
                    </div>
                    <!--Navigation-->
                </div>

                @include('presences.modals.search')
                @endsection

                @push('js')
                    <script>
                        $(document).ready(function() {
                            $('.select-motif').select2();
                            $('.select-agent').select2();
                            $('.select-dossier').select2();
                        });

                        $(document).ready(function() {
                            var table = $('#example').DataTable( {
                                lengthChange: false,
                                paginate : false,
                                order : false,
                                buttons: [ 'copy', 'excel', 'pdf', ],
                                language: {
                                    "sEmptyTable":     "Aucune donnée disponible dans le tableau",
                                    "sInfo":           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                                    "sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
                                    "sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
                                    "sInfoPostFix":    "",
                                    "sInfoThousands":  ",",
                                    "sLengthMenu":     "Afficher _MENU_ éléments",
                                    "sLoadingRecords": "Chargement...",
                                    "sProcessing":     "Traitement...",
                                    "sSearch":         "Rechercher :",
                                    "sZeroRecords":    "Aucun élément correspondant trouvé",
                                    "oPaginate": {
                                        "sFirst":    "Premier",
                                        "sLast":     "Dernier",
                                        "sNext":     "Suivant",
                                        "sPrevious": "Précédent"
                                    },
                                    "oAria": {
                                        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                                        "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
                                    },
                                    "select": {
                                        "rows": {
                                            "_": "%d lignes sélectionnées",
                                            "0": "Aucune ligne sélectionnée",
                                            "1": "1 ligne sélectionnée"
                                        }
                                    }
                                },
                            } );

                            // Insert at the top left of the table
                            table.buttons().container()
                                .appendTo( $('div.column.is-half', table.table().container()).eq(0) );
                        } );
                    </script>

                    <script>
                        $("#selectAll").click(function() {
                            $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
                        });

                        $("input[type=checkbox]").click(function() {
                            if (!$(this).prop("checked")) {
                                $("#selectAll").prop("checked", false);
                            }
                        });
                    </script>
    @endpush
