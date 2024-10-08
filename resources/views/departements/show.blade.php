@extends('template')

@push('css')
    <style>
        label{
            font-weight: 600
        }
    </style>
@endpush
@section('content')
    <div class="page-content-inner">
        <div class="profile-wrapper">
            <!--Breadcrumb-->
        @include('layouts.breadcrumb')
        <!--Edit Profile-->
            <div class="account-wrapper">
                <div class="columns">
                    <div class="column is-3">
                        @include('departements.menugauche')
                    </div>
                    <div class="column is-9">
                        @include('layouts.flashmessage')
                        <div class="account-box is-form">
                            <div class="form-head">
                                <div class="form-head-inner">
                                    <div class="left">
                                        <h3>{{$section_title}}</h3>
                                        <p><i class="lnil lnil-warning"></i> Cette section est réservée pour afficher les détails d'un département.</p>
                                    </div>
                                    <div class="right">
                                        <div class="buttons">
                                            @include('parts.precedent')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="column is-12">
                                <div class="demo-card">
                                    <div class="demo-title">
                                        <h3 class="title is-thin is-5">{{ ucfirst($departement->libelle) }}</h3>
                                    </div>
                                    <div class="card-inner">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Total service : </label> {{$totalService ?? 0}}
                                            </div>
                                            <div class="col-md-4">
                                                <label>Total employés : </label> {{ $totalEmploye ?? 0 }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="demo-card">
                                    <div class="demo-title">
                                        <h3 class="title is-thin is-5">Liste des services ( {{ $totalService ?? 0 }} ) </h3>
                                    </div>
                                    <div class="card-inner">
                                        <table  id="example" class="" style="width:100%">
                                            <thead>
                                            <tr class="table100-head">
                                                <th>Libéllé</th>
                                                <th>Statut</th>
                                                <th>Création</th>
                                                <th class="column6">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($services as $service)
                                                <tr>
                                                    <td>{{ ucfirst($service->libelle) }}</td>
                                                    <td>
                                                        @if($service->status ==1)
                                                            <span class="tag is-success">Actif</span>
                                                        @else
                                                            <span class="tag is-warning">Inactif</span>

                                                        @endif
                                                    </td>
                                                    <td>{{date('d/m/Y à H:i:s',strtotime($service->created_at))}} par {{ucfirst($service->created_by)}}</td>
                                                    <td class="column6 text-center">
                                                        <div>
                                                            <div class="dropdown is-spaced is-dots is-right dropdown-trigger is-pushed-mobile">
                                                                <div class="is-trigger" aria-haspopup="true" >
                                                                    <i data-feather="more-vertical"></i>
                                                                </div>
                                                                <div class="dropdown-menu" role="menu">
                                                                    <div class="dropdown-content">
                                                                        <a class="dropdown-item is-media" href="{{route('services.edit', $service->id)}}">
                                                                            <div class="icon">
                                                                                <i class="lnil lnil-pencil"></i>
                                                                            </div>
                                                                            <div class="meta">
                                                                                <span>Modifier</span>
                                                                            </div>
                                                                        </a>
                                                                        @if ($service->status === 0)
                                                                            <a class="dropdown-item is-media" href="{{ route('services.editState', ["id" => $service->id]) }}" onclick="return confirm('Êtes-vous sûre de vouloir activer ce service ?')">
                                                                                <div class="icon">
                                                                                    <i class="lnil lnil-reload"></i>
                                                                                </div>
                                                                                <div class="meta">
                                                                                    <span>Activer</span>
                                                                                </div>
                                                                            </a>
                                                                        @else
                                                                            <a class="dropdown-item is-media" href="{{ route('services.editState', ["id" => $service->id]) }}" onclick="return confirm('Êtes-vous sûre de vouloir désactiver ce service ?')">
                                                                                <div class="icon">
                                                                                    <i class="lnil lnil-reload"></i>
                                                                                </div>
                                                                                <div class="meta">
                                                                                    <span>Désactiver</span>
                                                                                </div>
                                                                            </a>
                                                                        @endif
                                                                        <a href="{{route('services.delete', $service->id)}}" onclick="return confirm('Voulez-vous Supprimer ce service ?')" class="dropdown-item is-media">
                                                                            <div class="icon">
                                                                                <i class="lnil lnil-trash-can-alt"></i>
                                                                            </div>
                                                                            <div class="meta">
                                                                                <span>Supprimer</span>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="demo-card">
                                    <div class="demo-title">
                                        <h3 class="title is-thin is-5">Liste des employés ( {{ $totalEmploye }} ) </h3>
                                    </div>
                                    <div class="card-inner card2">
                                        <table  id="example2" class="" style="width:100%">
                                            <thead>
                                            <tr class="table100-head">
                                                <th style="width: 5% !important;">#</th>
                                                <th>Matricule</th>
                                                <th>Nom & Prénom(s)</th>
                                                <th>Agence</th>
                                                <th>Département</th>
                                                <th>Service / Fonction</th>
                                                <th>Date de début</th>
                                                <th>Ancienneté</th>
                                                <th class="column6">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($employes as $employe)
                                                <tr>
                                                    <td class="text-center" style="width: 5% !important;">
                                                        <a href="{{ route('employes.presence.recap', $employe->id) }}" title="Graphique de présence de l'employé {{ucfirst($employe->firstname).' '.ucfirst($employe->lastname)}}" class=""><i class="lnil lnil-graph-alt-4"></i></a>
                                                    </td>
                                                    <td>{{ !empty($employe->matricule) ? $employe->matricule : 'Aucun' }}</td>
                                                    <td>{{ucfirst($employe->firstname).' '.ucfirst($employe->lastname)}}</td>
                                                    <td>{{ucfirst($employe->agence->libelle ?? 'Aucune')}}</td>
                                                    <td>{{ucfirst($employe->departement->libelle ?? 'Aucun')}}</td>
                                                    <td>{{ucfirst($employe->service->libelle ?? 'Aucun')}} / {{ ucfirst($employe->poste) }}</td>
                                                    <td>{{ !empty($employe->debut) ? date('d-m-Y', strtotime($employe->debut)) : 'Aucune date' }}</td>
                                                    <td>{{$employe->anciennete}} %</td>
                                                    <td class="column6 text-center">
                                                        <div>
                                                            <div class="dropdown is-spaced is-dots is-right dropdown-trigger is-pushed-mobile">
                                                                <div class="is-trigger" aria-haspopup="true" >
                                                                    <i data-feather="more-vertical"></i>
                                                                </div>
                                                                <div class="dropdown-menu" role="menu">
                                                                    <div class="dropdown-content">
                                                                        <a class="dropdown-item is-media" href="{{route('employes.edit', $employe->id)}}">
                                                                            <div class="icon">
                                                                                <i class="lnil lnil-pencil"></i>
                                                                            </div>
                                                                            <div class="meta">
                                                                                <span>Modifier</span>
                                                                            </div>
                                                                        </a>
                                                                        <a href="{{route('employes.delete', $employe->id)}}" onclick="return confirm('Voulez-vous Supprimer cet employé ?')" class="dropdown-item is-media">
                                                                            <div class="icon">
                                                                                <i class="lnil lnil-trash-can-alt"></i>
                                                                            </div>
                                                                            <div class="meta">
                                                                                <span>Supprimer</span>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @include('paginations.default', ['paginator' => $employes ])
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
                            var table2 = $('#example2').DataTable( {
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

                            table2.buttons().container()
                                .appendTo( $('div.column.is-half', table2.table().container()).eq(0) );
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
