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
                        @include('permissions.menugauche')
                    </div>
                    <div class="column is-9">
                        @include('layouts.flashmessage')
                        <div class="account-box is-form">
                            <div class="form-head">
                                <div class="form-head-inner">
                                    <div class="left">
                                        <h3>{{$section_title}}</h3>
                                        <p><i class="lnil lnil-warning"></i> Cette section est réservée pour afficher la liste des permissions.</p>
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
                                            <div class="buttons">
                                                <a class="button h-button is-elevated text-white h-modal-trigger" data-modal="searchPermission" style="background-color: {{$setting->companycolor}} !important;" href="#">
                                                  <span class="icon">
                                                      <i class="lnil lnil-users"></i>
                                                  </span>
                                                    <span>Rechercher une permission</span>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="table100">
                                        <table  id="example" class="" style="width:100%">
                                            <thead>
                                            <tr class="table100-head">
                                                <th>Employé</th>
                                                <th>Département</th>
                                                <th>Service</th>
                                                <th>Motif</th>
                                                <th>Période</th>
                                                <th>Date création</th>
                                                <th class="column6">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($permissions as $permission)
                                                <tr>
                                                    <td>{{ ucfirst($permission->employe->firstname ?? '').' '.ucfirst($permission->employe->lastname ?? '') }}</td>
                                                    <td>{{ ucfirst($permission->employe->departement->libelle ?? 'Aucun') }}</td>
                                                    <td>{{ ucfirst($permission->employe->service->libelle ?? 'Aucun') }}</td>
                                                    <td>{{ ucfirst($permission->motif) }}</td>
                                                    <td>
                                                    Du : {{date('d/m/Y à H:i:s',strtotime($permission->debut))}} <br>
                                                    Au : {{date('d/m/Y à H:i:s',strtotime($permission->fin))}}
                                                    </td>
                                                    <td>{{date('d/m/Y à H:i:s', strtotime($permission->created_at))}}</td>
                                                    <td class="column6 text-center">
                                                        <div>
                                                            <div class="dropdown is-spaced is-dots is-right dropdown-trigger is-pushed-mobile">
                                                                <div class="is-trigger" aria-haspopup="true" >
                                                                    <i data-feather="more-vertical"></i>
                                                                </div>
                                                                <div class="dropdown-menu" role="menu">
                                                                    <div class="dropdown-content">
                                                                        <a class="dropdown-item is-media" target="_blank" href="{{ route('permissions.show', $permission->id) }}">
                                                                            <div class="icon">
                                                                                <i class="lnil lnil-eye"></i>
                                                                            </div>
                                                                            <div class="meta">
                                                                                <span>Détails</span>
                                                                            </div>
                                                                        </a>
{{--                                                                        @if ($permission->status == 0)--}}
{{--                                                                            <a class="dropdown-item is-media" href="{{ route('permissions.change.status', ["id" => $permission->id, 'type' => 'validate']) }}" onclick="return confirm('Êtes-vous sûre de vouloir valider cette permission ?')">--}}
{{--                                                                                <div class="icon">--}}
{{--                                                                                    <i class="lnil lnil-checkmark"></i>--}}
{{--                                                                                </div>--}}
{{--                                                                                <div class="meta">--}}
{{--                                                                                    <span>Valider</span>--}}
{{--                                                                                </div>--}}
{{--                                                                            </a>--}}
{{--                                                                            <a class="dropdown-item is-media" href="{{ route('permissions.change.status', ["id" => $permission->id, 'type' => 'decline']) }}" onclick="return confirm('Êtes-vous sûre de vouloir réfuser cette permission ?')">--}}
{{--                                                                                <div class="icon">--}}
{{--                                                                                    <i class="lnil lnil-cross-circle"></i>--}}
{{--                                                                                </div>--}}
{{--                                                                                <div class="meta">--}}
{{--                                                                                    <span>Réfuser</span>--}}
{{--                                                                                </div>--}}
{{--                                                                            </a>--}}
{{--                                                                        @endif--}}
                                                                        <a class="dropdown-item is-media" href="{{ route('permissions.edit', $permission->id) }}">
                                                                            <div class="icon">
                                                                                <i class="lnil lnil-pencil"></i>
                                                                            </div>
                                                                            <div class="meta">
                                                                                <span>Modifier</span>
                                                                            </div>
                                                                        </a>
                                                                        <a href="{{ route('permissions.delete', $permission->id) }}" onclick="return confirm('Êtes-vous sûre de vouloir supprimer cette permission ?')" class="dropdown-item is-media">
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
                                @include('paginations.default', ['paginator' => $permissions ])
                            </div>
                        </div>
                    </div>
                    <!--Navigation-->
                </div>

                @include('permissions.modals.search')
                
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
