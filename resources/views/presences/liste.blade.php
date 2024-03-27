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
                                        <p><i class="lnil lnil-warning"></i> Cette section est réservée pour afficher la liste des présences</p>
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
                                            <span style="font-size: 14px; font-weight: 600">Total : {{ count($presences) }}</span>
                                        </div>

                                    </div>
                                    <div class="table100">
                                        <table  id="example" class="" style="width:100%">
                                            <thead>
                                            <tr class="table100-head">
                                                <th>Date</th>
                                                <th>Employe</th>
                                                <th>Actions</th>
                                                <th>Temps</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($presences as $presence)
                                                <tr>
                                                    @php
                                                        $model = (new App\Models\Presence)->make(get_object_vars($presence));
                                                        $employeInfo = $model->getEmploye($presence->employe_id);

                                                        $fisrtPointage = $model->getInfo($presence->id)['fisrtPointage'];
                                                        $lastPointage = $model->getInfo($presence->id)['lastPointage'];

                                                        if(isset($fisrtPointage) && isset($lastPointage)){
                                                            $timeFirst = \Carbon\Carbon::parse($fisrtPointage->authTime);
                                                            $timeDes = \Carbon\Carbon::parse($setting->fin_matin);
                                                            $timeDiffFirst = $timeFirst->diffInHours($timeDes);
                                                            //$dureesFirst = \Carbon\CarbonInterval::minutes($timeDiffFirst);

                                                            $timeLast = \Carbon\Carbon::parse($lastPointage->authTime);
                                                            $timeDesLast = \Carbon\Carbon::parse($setting->debut_soir);
                                                            $timeDiffLast = $timeDesLast->diffInHours($timeLast);
                                                            //dd($timeDiffLast);
                                                            //$dureesLast = \Carbon\CarbonInterval::minutes($timeDiffLast);
                                                            $duree = $timeDiffFirst + $timeDiffLast;
                                                        }else{
                                                            $duree = 0;
                                                        }
                                                    @endphp

                                                    <td>{{date('d/m/Y', strtotime($presence->authDate))}}</td>
                                                    <td>{{ ucfirst($employeInfo->firstname ?? '').''.ucfirst($employeInfo->lastname ?? '') }}</td>
                                                    <td>
                                                        @if(isset($fisrtPointage))
                                                            Arrivée : {{ date('H:i:s', strtotime($fisrtPointage->authTime)) }}
                                                            <br>
                                                        @endif
                                                        @if(isset($lastPointage))
                                                            Départ : {{ date('H:i:s', strtotime($lastPointage->authTime)) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $duree }} heure(s)
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Navigation-->
                </div>
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
