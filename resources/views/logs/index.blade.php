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

                        <div class="account-box is-navigation">

                            <div class="account-menu">



                                <a class="button h-button is-primary is-outlined h-modal-trigger" data-modal="modalSearch">Recherche avancée</a>



                            </div>

                        </div>

                    </div>

                    <!--Form-->

                    <div class="column is-9">

                        @include('layouts.flashmessage')
                        <div class="account-box is-form">
                            <div class="form-head">
                                <div class="form-head-inner">
                                    <div class="left">
                                        <h3>{{$section_title}}</h3>
                                        <p><i class="lnil lnil-warning"></i> Cette section est réservée pour afficher la liste des actions effectuées par les utilisateurs.</p>
                                    </div>
                                    <div class="right">
                                        <div class="buttons">
                                            @include('parts.precedent')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns">
                    <div class="column is-12">
                        <div class="account-box is-form is-footerless">
                            <div class="form-body">
                                <div class="s-card demo-table column.is-half">
									<div class="table100">
										<table  id="example" class="" style="width:100%">
											<thead>
											<tr class="table100-head">
												<th>Date</th>

												<th>Module </th>

												<th>Action menée</th>

											</tr>

											</thead>

											<tbody>

												@foreach($logs as $l)

													<tr>

														<td>{{date('d/m/Y à H:i:s',strtotime($l->created_at))}} </td>

														<td>{{ucfirst($l->module)}}</td>

														<td>{{ucfirst($l->user->name)}} {{ucfirst($l->user->prenoms)}} {{ucfirst($l->action)}}</td>

													</tr>

												@endforeach

											</tbody>

										</table>

									</div>

                                </div>



                                @include('paginations.default', ['paginator' => $logs ])

                            </div>

                        </div>

                </div>

            </div>



            @include('logs.modalsearch')



@endsection



@push('js')

    <script>

        $(document).ready(function() {

            $('.select-user').select2();

        });



        $(document).ready(function() {

            var table = $('#example').DataTable( {

                lengthChange: false,

                paginate : false,

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





@endpush

