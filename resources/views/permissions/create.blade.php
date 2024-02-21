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
                                        <p><i class="lnil lnil-warning"></i> Cette section est réservée pour la creation d'une permission.</p>
                                    </div>
                                    <div class="right">
                                        <div class="buttons">
                                            @include('parts.precedent')
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-body">
                                <form action="{{route('permissions.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="columns is-multiline">
                                        <div class="column is-12">
                                            <h4>Demandeur</h4>
                                        </div>
                                        <div class="column is-12">
                                            <label for="type">Employé <span class="requis">*</span></label>
                                            <div class="field">
                                                <div class="control">
                                                    <select class=" form-control p-2 select-agent" name="employe" style="width:100%; heigth:38px !important; border: 1px solid #ccc !important;">
                                                        <option value="">Sélectionnez un employé</option>
                                                        @foreach($employes as $employe)
                                                            <option value="{{$employe->id}}" {{old('employe') == $employe->id ? 'selected' : ''}}>{{ ucfirst($employe->firstname.' '.$employe->lastname) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="nbenfant">Date de debut <span class="requis">*</span></label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="datetime-local" class="input" name="debut" placeholder="" value="{{old('debut')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="identifiant">Date de retour <span class="requis">*</span></label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="datetime-local" class="input" name="fin" placeholder="" value="{{old('fin')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="identifiant">Motif <span class="requis">*</span></label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="text" class="input" name="motif" placeholder="" value="{{old('motif')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="file">Pièce jointe</label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="file" id="file" class="input" name="file">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-12">
                                            <hr>
                                            <h4>Avis hiérarchique</h4>
                                        </div>
                                        <div class="column is-6">
                                            <label for="">Accord du Supérieur Hiérarchique N+1</label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="radio" id="oui_accord1" checked name="accord1" value="1">
                                                    <label class="radio" for="oui_accord1">
                                                        Oui
                                                    </label>
                                                    <input type="radio" id="non_accord1" name="accord1" value="0">
                                                    <label class="radio" for="non_accord1">
                                                        Non
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="">Accord du Supérieur Hiérarchique N+2</label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="radio" id="oui_accord2" checked name="accord2" value="1">
                                                    <label class="radio" for="oui_accord2">
                                                        Oui
                                                    </label>
                                                    <input type="radio" id="non_accord2" name="accord2" value="0">
                                                    <label class="radio" for="non_accord2">
                                                        Non
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-12">
                                            <hr>
                                            <h4>Avis du Directeur des ressources humaines</h4>
                                        </div>
                                        <div class="column is-6">
                                            <label for="">Accord du DRH</label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="radio" id="oui_accord" checked name="accord_drh" value="1">
                                                    <label class="radio" for="oui_accord">
                                                        Oui
                                                    </label>
                                                    <input type="radio" id="non_accord" name="accord_drh" value="0">
                                                    <label class="radio" for="non_accord">
                                                        Non
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="">Absence à valoir sur</label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="radio" id="conge" checked name="type_conge" value="conge">
                                                    <label class="radio" for="conge">
                                                        Congés
                                                    </label>
                                                    <input type="radio" id="salaire" name="type_conge" value="salaire">
                                                    <label class="radio" for="salaire">
                                                        Salaire
                                                    </label>
                                                    <input type="radio" id="aucun" name="type_conge" value="aucun">
                                                    <label class="radio" for="aucun">
                                                        Aucun
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-12">
                                            <hr>
                                            <h4>Décision Direction Générale</h4>
                                        </div>
                                        <div class="column is-6">
                                            <label for="">Accord du DFC/DRH/DG</label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="radio" id="accord_dfc" checked name="accord_dfc" value="1">
                                                    <label class="radio" for="accord_dfc">
                                                        Oui
                                                    </label>
                                                    <input type="radio" id="non_accord_dfc" name="type" value="0">
                                                    <label class="radio" for="non_accord_dfc">
                                                        Non
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-12">
                                            <hr>
                                        </div>
                                        <div class="column is-12">
                                            <label for="">Description</label>
                                            <div class="field">
                                                <div class="control">
                                                    <textarea class="textarea" name="description" rows="4" placeholder="Ecrivez une description de la permission...">{{ old('description') }}</textarea>
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
