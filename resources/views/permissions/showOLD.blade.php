@extends('template')
@push('css')
    <style>
        .profile-wrapper .profile-body .profile-card .profile-card-section .section-title h4 {
            font-family: "Montserrat", sans-serif;
            font-weight: 600;
            font-size: .8rem;
            text-transform: uppercase;
            color: #283252;
            margin-right: 6px;
        }

        .profile-wrapper .profile-body .profile-card .profile-card-section .section-content .description {
            font-size: .95rem;
        }

        .meta {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            margin: 8px 0;
        }

        .meta .dark-inverted {
            font-family: "Montserrat",sans-serif;
            font-weight: 600;
            color: #283252;
            font-size: .85rem;
            margin-right: 5px
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
                        @include('permissions.menugauche')
                    </div>
                    <div class="column is-9">
                        @include('layouts.flashmessage')
                        <div class="account-box is-form">
                            <div class="form-head">
                                <div class="form-head-inner">
                                    <div class="left">
                                        <h3>{{$section_title}}</h3>
                                        <p><i class="lnil lnil-warning"></i> Cette section est réservée pour afficher les détails d'une permission.</p>
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
                                    <div class="columns">
                                        <div class="column is-6">
                                            <div class="profile-card">
                                                <div class="profile-card-section">
                                                    <div class="section-title d-flex">
                                                        <h4>Détails</h4>
                                                    </div>
                                                    <div class="section-content">
                                                        <div class="meta">
                                                            <span class="dark-inverted">Employé : </span>
                                                            {{ ucfirst($permission->employe->firstname ?? '').' '.ucfirst($permission->employe->lastname ?? '') }}
                                                        </div>
                                                        <div class="meta">
                                                            <span class="dark-inverted">Statut : </span>
                                                            @if($permission->status ==1)
                                                                <span class="tag is-success">Approuvée</span>
                                                            @elseif ($permission->status == 2)
                                                                <span class="tag is-danger">Réfusée</span>
                                                            @else
                                                                <span class="tag is-warning">En attente</span>
                                                            @endif
                                                        </div>
                                                        <div class="meta">
                                                            <span class="dark-inverted">Date de soumission : </span>
                                                            {{date('d/m/Y à H:i:s',strtotime($permission->created_at))}}
                                                        </div>
                                                        <div class="meta">
                                                            <span class="dark-inverted">Date de debut : </span>
                                                            {{date('d/m/Y à H:i:s',strtotime($permission->debut))}}
                                                        </div>
                                                        <div class="meta">
                                                            <span class="dark-inverted">Date de fin : </span>
                                                            {{date('d/m/Y à H:i:s',strtotime($permission->fin))}}
                                                        </div>
                                                        <div class="meta">
                                                            <span class="dark-inverted">Motif : </span>
                                                            {{ ucfirst($permission->motif) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <div class="profile-card">
                                                <div class="profile-card-section">
                                                    <div class="section-title d-flex">
                                                        <h4>Description</h4>
                                                    </div>
                                                    <div class="section-content">
                                                        <p class="description">
                                                            {!! html_entity_decode($permission->description) !!}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
