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
                        @include('sieges.menugauche')
                    </div>
                    <div class="column is-9">
                        @include('layouts.flashmessage')
                        <div class="account-box is-form">
                            <div class="form-head">
                                <div class="form-head-inner">
                                    <div class="left">
                                        <h3>{{$section_title}}</h3>
                                        <p><i class="lnil lnil-warning"></i> Cette section est réservée pour la creation d'une agence.</p>
                                    </div>
                                    <div class="right">
                                        <div class="buttons">
                                            @include('parts.precedent')
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-body">
                                <form action="{{route('agences.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="columns is-multiline">
                                        <div class="column is-6">
                                            <label for="nbenfant">Libéllé <span class="requis">*</span></label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="text" class="input" name="libelle" placeholder="" value="{{old('libelle')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="type">Siège <span class="requis">*</span></label>
                                            <div class="field">
                                                <div class="control">
                                                    <select class=" form-control p-2 select-agent" name="siege" style="width:100%; heigth:38px !important; border: 1px solid #ccc !important;">
                                                        <option value="">Sélectionnez un siège</option>
                                                        @foreach($sieges as $siege)
                                                            <option value="{{$siege->id}}" {{old('siege') == $siege->id ? 'selected' : ''}}>{{ ucfirst($siege->libelle) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="type">Pays <span class="requis">*</span></label>
                                            <div class="field">
                                                <div class="control">
                                                    <select class=" form-control p-2 select-agent" name="country" style="width:100%; heigth:38px !important; border: 1px solid #ccc !important;">
                                                        <option value="">Sélectionnez un pays</option>
                                                        @foreach($countries as $country)
                                                            <option value="{{$country->id}}" {{old('country') == $country->id ? 'selected' : ''}}>{{ ucfirst($country->name) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="identifiant">Contact <span class="requis">*</span></label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="phone" class="input" name="contact" placeholder="" value="{{old('contact')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="identifiant">Adresse <span class="requis">*</span></label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="text" class="input" name="adresse" placeholder="" value="{{old('adresse')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="identifiant">Localisation</label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="text" class="input" name="localisation" placeholder="" value="{{old('localisation')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fieldset">
                                        <div class="columns is-multiline">
                                            <!--Field-->
                                            <div class="buttons">
                                                @include('parts.precedent')
                                                <button id="save-button" type="submit" class="button h-button is-primary is-raised" style="background-color: {{$setting->companycolor}}; color : #fff !important;">Valider</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
