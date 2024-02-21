@extends('template')
@section('content')
    <div class="page-content-inner">
        <div class="profile-wrapper">
            <!--Breadcrumb-->
            @include('layouts.breadcrumb')
            <!--Edit Profile-->
            <div class="account-wrapper">
                <div class="columns">
                    <!--Navigation-->
                    <div class="column is-3">

						@include('espaces.menugauche')

                    </div>
                    <!--Form-->
                    <div class="column is-9">
                     @include('layouts.flashmessage')
                        <div class="account-box is-form is-footerless">
                            <div class="form-head">
                                <div class="form-head-inner">
                                    <div class="left">
                                        <h3>{{$section_title}}</h3>
                                        <p><i class="lnil lnil-warning"></i> Cette section est réservée pour afficher la liste des espaces utilisateurs.</p>
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
                                    <div class="table100">
                                        <table  id="example" class="" style="width:100%">
                                            <thead>
                                            <tr class="table100-head">
                                                <th>Nom</th>
                                                <th>Nb Utilisateurs</th>
                                                <th>Espace par défaut</th>
                                                <th>Crée le</th>
                                                <th class="column6">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($espaces as $esp)
                                                <tr>

                                                    <td>{{ucfirst($esp->nom)}}</td>
                                                    <td>{{$esp->users->count()}}</td>
                                                    <td>
                                                        @if($esp->defaut ==1)
                                                            <span class="tag is-success">Oui</span>
                                                        @else
                                                            <span class="tag is-warning">Non</span>

                                                        @endif
                                                    </td>
                                                    <td>{{date('d/m/Y à H:i:s',strtotime($esp->created_at))}} par {{ucfirst($esp->created_by)}}</td>
                                                    <td class="column6 text-center">
                                                        <div class="dropdown">
                                                            <a class="btn btn-sm btn-icon-only text-dark action" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow dropdown-content">
                                                                <a class="dropdown-item" href="{{route('espaces.show',$esp->id)}}"><i class="lnil lnil-eye"></i> Afficher</a>
                                                                <a class="dropdown-item" href="{{route('espaces.edit',$esp->id)}}"><i class="lnil lnil-pencil"></i> Modifier</a>
                                                                <a class="dropdown-item" href="{{route('espaces.parDefaut',$esp->id)}}" onclick="return confirm('voulez - vous définir cet espace comme espace par defaut?')"><i class="lnil lnil-check"></i> Définir comme defaut</a>
                                                                <hr class="dropdown-divider">
                                                                <a class="dropdown-item" href="{{route('espaces.delete',$esp->id)}}" onclick="return confirm('voulez - vous supprimer l\'enregistrement ? ceci peut engendrer des erreurs dans le systeme.')" class="dropdown-item is-media"><i class="lnil lnil-trash-can-alt"></i> Supprimer</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="paging-first-datatable" class="pagination datatable-pagination">
                                    <div class="datatable-info">
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable( {
                lengthChange: false,
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
                buttons: [ 'copy', 'excel', 'pdf' ],

            } );

            // Insert at the top left of the table
            table.buttons().container()
                .appendTo( $('div.column.is-half', table.table().container()).eq(0) );
        } );
    </script>
@endpush
