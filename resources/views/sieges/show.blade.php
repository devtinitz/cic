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
                        @include('sieges.menugauche')
                    </div>
                    <div class="column is-9">
                        @include('layouts.flashmessage')
                        <div class="account-box is-form">
                            <div class="form-head">
                                <div class="form-head-inner">
                                    <div class="left">
                                        <h3>{{$section_title}}</h3>
                                        <p><i class="lnil lnil-warning"></i> Cette section est réservée pour afficher les détails d'un siège.</p>
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
                                        <h3 class="title is-thin is-5">{{ ucfirst($siege->libelle) }}</h3>
                                    </div>
                                    <div class="card-inner">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Total agence : </label> {{ $siege->agences->count() }}
                                            </div>
                                            <div class="col-md-4">
                                                <label>Total département : </label> {{$siege->allDepartements->count()}}
                                            </div>
                                            <div class="col-md-4">
                                                <label>Total employés : </label> {{ $siege->allEmploye->count() }}
                                            </div>
                                            <div class="col-md-4">
                                                <label>Horaires de pointage : </label> {{$siege->allHoraires->count()}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="demo-card">
                                    <div class="demo-title">
                                        <h3 class="title is-thin is-5">Horaires programmées</h3>
                                    </div>
                                    <div class="card-inner">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form action="{{ route('sieges.storeHoraire') }}" method="post">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-2 form-group mb-3" >
                                                            <input type="hidden" name="siege_id" value="{{$siege->id}}">
                                                            <label class="check">
                                                                <input type="checkbox" name="jours[]" {{ !empty(App\Models\Horaire::where(['siege_id' => $siege->id, 'jours' => 1])->first()) ? 'checked' : '' }} id="1" value="1" >
                                                                Lundi
                                                            </label>
                                                        </div>

                                                        <div class="col-md-5 form-group mb-3">
                                                            <input type="time" class="form-control jour1 debut1" value="{{App\Models\Horaire::where(['siege_id' => $siege->id, 'jours' => 1])->first()->debut ?? ''}}" name="debut[]"  >
                                                        </div>

                                                        <div class="col-md-5 form-group mb-3">
                                                            <input type="time" class="form-control jour1 fin1" value="{{App\Models\Horaire::where(['siege_id' => $siege->id, 'jours' => 1])->first()->fin ?? ''}}" name="fin[]" >
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-2 form-group mb-3">
                                                            <label class="check">
                                                                <input type="checkbox" name="jours[]" {{ !empty(App\Models\Horaire::where(['siege_id' => $siege->id, 'jours' => 2])->first()) ? 'checked' : '' }} id="2" value="2">
                                                                Mardi
                                                            </label>
                                                        </div>

                                                        <div class="col-md-5 form-group mb-3">
                                                            <input type="time" class="form-control jour2 debut2" value="{{App\Models\Horaire::where(['siege_id' => $siege->id, 'jours' => 2])->first()->fin ?? ''}}" name="debut[]" >
                                                        </div>

                                                        <div class="col-md-5 form-group mb-3">
                                                            <input type="time" class="form-control jour2 fin2" value="{{App\Models\Horaire::where(['siege_id' => $siege->id, 'jours' => 2])->first()->fin ?? ''}}" name="fin[]" >
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-2 form-group mb-3">
                                                            <label class="check">
                                                                <input type="checkbox" name="jours[]" {{ !empty(App\Models\Horaire::where(['siege_id' => $siege->id, 'jours' => 3])->first()) ? 'checked' : '' }} id="3" value="3">
                                                                Mercredi
                                                            </label>
                                                        </div>

                                                        <div class="col-md-5 form-group mb-3">
                                                            <input type="time" class="form-control jour3 debut3" value="{{App\Models\Horaire::where(['siege_id' => $siege->id, 'jours' => 3])->first()->debut ?? ''}}" name="debut[]" >
                                                        </div>

                                                        <div class="col-md-5 form-group mb-3">
                                                            <input type="time" class="form-control jour3 fin3" value="{{App\Models\Horaire::where(['siege_id' => $siege->id, 'jours' => 3])->first()->fin ?? ''}}" name="fin[]">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-2 form-group mb-3">
                                                            <label class="check">
                                                                <input type="checkbox" name="jours[]" {{ !empty(App\Models\Horaire::where(['siege_id' => $siege->id, 'jours' => 4])->first()) ? 'checked' : '' }} id="4" value="4">
                                                                Jeudi
                                                            </label>
                                                        </div>

                                                        <div class="col-md-5 form-group mb-3">
                                                            <input type="time" class="form-control jour4 debut4" value="{{App\Models\Horaire::where(['siege_id' => $siege->id, 'jours' => 4])->first()->debut ?? ''}}" name="debut[]" >
                                                        </div>

                                                        <div class="col-md-5 form-group mb-3">
                                                            <input type="time" class="form-control jour4 fin4"  value="{{App\Models\Horaire::where(['siege_id' => $siege->id, 'jours' => 4])->first()->fin ?? ''}}" name="fin[]" >
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-md-2 form-group mb-3">
                                                            <label class="check">
                                                                <input type="checkbox" name="jours[]" {{ !empty(App\Models\Horaire::where(['siege_id' => $siege->id, 'jours' => 5])->first()) ? 'checked' : '' }} id="5" value="5">
                                                                Vendredi
                                                            </label>
                                                        </div>

                                                        <div class="col-md-5 form-group mb-3">
                                                            <input type="time" class="form-control jour5 debut5" value="{{App\Models\Horaire::where(['siege_id' => $siege->id, 'jours' => 5])->first()->debut ?? ''}}" name="debut[]" >
                                                        </div>

                                                        <div class="col-md-5 form-group mb-3">
                                                            <input type="time" class="form-control jour5 fin5" value="{{App\Models\Horaire::where(['siege_id' => $siege->id, 'jours' => 5])->first()->fin ?? ''}}" name="fin[]" >
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-2 form-group mb-3">
                                                            <label class="check">
                                                                <input type="checkbox" name="jours[]" {{ !empty(App\Models\Horaire::where(['siege_id' => $siege->id, 'jours' => 6])->first()) ? 'checked' : '' }} id="6" value="6" >
                                                                Samedi
                                                            </label>
                                                        </div>

                                                        <div class="col-md-5 form-group mb-3">
                                                            <input type="time" class="form-control jour6 debut6" value="{{App\Models\Horaire::where(['siege_id' => $siege->id, 'jours' => 6])->first()->debut ?? ''}}" name="debut[]" >
                                                        </div>

                                                        <div class="col-md-5 form-group mb-3">
                                                            <input type="time" class="form-control jour6 fin6" value="{{App\Models\Horaire::where(['siege_id' => $siege->id, 'jours' => 6])->first()->fin ?? ''}}" name="fin[]" >
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4"></div>

                                                        <div class="col-md-4">
                                                            <button type="submit" class="btn btn-primary btn-block" >
                                                                Enregistrer
                                                            </button>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="demo-card">
                                    <div class="demo-title">
                                        <h3 class="title is-thin is-5">Liste des agences ( {{$siege->agences->count()}} ) </h3>
                                    </div>
                                    <div class="card-inner">
                                        <table  id="" class="example" style="width:100%">
                                            <thead>
                                            <tr class="table100-head">
                                                <th>Libéllé</th>
                                                <th>Siège</th>
                                                <th>Nbre employé</th>
                                                <th>Pays</th>
                                                <th>Adresse</th>
                                                <th>Statut</th>
                                                <th>Date création</th>
                                                <th class="column6">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($siege->agences as $agence)
                                                <tr>
                                                    <td>{{ ucfirst($agence->libelle) }}</td>
                                                    <td>{{ ucfirst($agence->siege->libelle ?? '') }}</td>
                                                    <td>{{ ucfirst($agence->allEmployes->count() ?? '') }}</td>
                                                    <td>{{ ucfirst($agence->country->name ?? '') }}</td>
                                                    <td>{{ ucfirst($agence->adresse ?? '') }}</td>
                                                    <td>
                                                        @if($agence->status ==1)
                                                            <span class="tag is-success">Actif</span>
                                                        @else
                                                            <span class="tag is-warning">Inactif</span>
                                                        @endif
                                                    </td>
                                                    <td>Créé le {{ date('d/m/Y', strtotime($agence->created_at)).' par '.ucfirst($agence->created_by) }}</td>
                                                    <td class="column6 text-center">
                                                        <div>
                                                            <div class="dropdown is-spaced is-dots is-right dropdown-trigger is-pushed-mobile">
                                                                <div class="is-trigger" aria-haspopup="true" >
                                                                    <i data-feather="more-vertical"></i>
                                                                </div>
                                                                <div class="dropdown-menu" role="menu">
                                                                    <div class="dropdown-content">
                                                                        <a class="dropdown-item is-media" href="{{ route('agences.show', $agence->id) }}">
                                                                            <div class="icon">
                                                                                <i class="lnil lnil-eye"></i>
                                                                            </div>
                                                                            <div class="meta">
                                                                                <span>Détails</span>
                                                                            </div>
                                                                        </a>
                                                                        <a class="dropdown-item is-media" href="{{ route('agences.edit', $agence->id) }}">
                                                                            <div class="icon">
                                                                                <i class="lnil lnil-pencil"></i>
                                                                            </div>
                                                                            <div class="meta">
                                                                                <span>Modifier</span>
                                                                            </div>
                                                                        </a>
                                                                        @if ($agence->status === 0)
                                                                            <a class="dropdown-item is-media" href="{{ route('agences.editState', ["id" => $agence->id]) }}" onclick="return confirm('Êtes-vous sûre de vouloir activer ce siège ?')">
                                                                                <div class="icon">
                                                                                    <i class="lnil lnil-reload"></i>
                                                                                </div>
                                                                                <div class="meta">
                                                                                    <span>Activer</span>
                                                                                </div>
                                                                            </a>
                                                                        @else
                                                                            <a class="dropdown-item is-media" href="{{ route('agences.editState', ["id" => $agence->id]) }}" onclick="return confirm('Êtes-vous sûre de vouloir désactiver ce siège ?')">
                                                                                <div class="icon">
                                                                                    <i class="lnil lnil-reload"></i>
                                                                                </div>
                                                                                <div class="meta">
                                                                                    <span>Désactiver</span>
                                                                                </div>
                                                                            </a>
                                                                        @endif
                                                                        <a href="{{ route('agences.delete', $agence->id) }}" class="dropdown-item is-media" onclick="return confirm('Êtes-vous sûre de vouloir supprimer ce siège ?')">
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
                                        <h3 class="title is-thin is-5">Liste des départements ( {{$siege->allDepartements->count()}} ) </h3>
                                    </div>
                                    <div class="card-inner">
                                        <table  id="" class="example" style="width:100%">
                                            <thead>
                                            <tr class="table100-head">
                                                <th>#</th>
                                                <th>Libéllé</th>
                                                <th>Statut</th>
                                                <th>Création</th>
                                                <th class="column6">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($siege->allDepartements as $departement)
                                                <tr>
                                                    <td class="text-center" style="width: 5% !important;">
                                                        <a href="{{ route('departements.presence.recap', $departement->id) }}" title="Graphique de présence du département {{ucfirst($departement->libelle)}}" class="">
                                                            <i class="lnil lnil-graph-alt-4"></i>
                                                        </a>
                                                    </td>
                                                    <td>{{ ucfirst($departement->libelle) }}</td>
                                                    <td>
                                                        @if($departement->status ==1)
                                                            <span class="tag is-success">Actif</span>
                                                        @else
                                                            <span class="tag is-warning">Inactif</span>

                                                        @endif
                                                    </td>
                                                    <td>{{date('d/m/Y à H:i:s',strtotime($departement->created_at))}} par {{ucfirst($departement->created_by)}}</td>
                                                    <td class="column6 text-center">
                                                        <div>
                                                            <div class="dropdown is-spaced is-dots is-right dropdown-trigger is-pushed-mobile">
                                                                <div class="is-trigger" aria-haspopup="true" >
                                                                    <i data-feather="more-vertical"></i>
                                                                </div>
                                                                <div class="dropdown-menu" role="menu">
                                                                    <div class="dropdown-content">
                                                                        <a class="dropdown-item is-media" href="{{route('departements.edit', $departement->id)}}">
                                                                            <div class="icon">
                                                                                <i class="lnil lnil-pencil"></i>
                                                                            </div>
                                                                            <div class="meta">
                                                                                <span>Modifier</span>
                                                                            </div>
                                                                        </a>
                                                                        <a href="{{route('departements.delete', $departement->id)}}" onclick="return confirm('Voulez-vous Supprimer ce département ?')" class="dropdown-item is-media">
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
                            var table = $('.example').DataTable( {
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
