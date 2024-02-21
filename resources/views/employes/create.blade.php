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
                        @include('employes.menugauche')
                    </div>
                    <div class="column is-9">
                        @include('layouts.flashmessage')
                        <div class="account-box is-form">
                            <div class="form-head">
                                <div class="form-head-inner">
                                    <div class="left">
                                        <h3>{{$section_title}}</h3>
                                        <p><i class="lnil lnil-warning"></i> Cette section est réservée pour la creation d'un employé.</p>
                                    </div>
                                    <div class="right">
                                        <div class="buttons">
                                            @include('parts.precedent')
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-body">
                                <form action="{{route('employes.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="columns is-multiline">
                                        <div class="column is-12 has-text-centered">
                                            <div class="field">
                                                <div class="control">
                                                    <input type="radio" id="monsieur" checked name="civilite" value="Monsieur">
                                                    <label class="radio" for="monsieur">
                                                        Monsieur
                                                    </label>
                                                    <input type="radio" id="madame" name="civilite" value="Madame">
                                                    <label class="radio" for="madame">
                                                        Madame
                                                    </label>
                                                    <input type="radio" id="mademoiselle" name="civilite" value="Mademoiselle">
                                                    <label class="radio" for="mademoiselle">
                                                        Mademoiselle
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-4">
                                            <label for="identifiant">Nom <span class="requis">*</span></label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="text" id="identifiant" class="input" name="nom" placeholder="Nom de l'employé" value="{{old('nom')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-4">
                                            <label for="num">Prénom(s) <span class="requis">*</span></label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="text" id="num" class="input" name="prenoms" placeholder="Prénom(s) de l'employé" value="{{old('prenoms')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-4">
                                            <label for="code_controbuale">Email </label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="email" id="code_contribuable" class="input" name="email" placeholder="Email" value="{{old('email')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="type">Agence</label>
                                            <div class="field">
                                                <div class="control">
                                                    <select class=" form-control p-2 select-agent" name="agence" style="width:100%; heigth:38px !important; border: 1px solid #ccc !important;">
                                                        <option value="">Sélectionnez une agence</option>
                                                        @foreach($agences as $agence)
                                                            <option value="{{$agence->id}}" {{old('agence') == $agence->id ? 'selected' : ''}}>{{ ucfirst($agence->libelle) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="type">Département</label>
                                            <div class="field">
                                                <div class="control">
                                                    <select class=" form-control p-2 select-agent select-departement" name="departement" style="width:100%; heigth:38px !important; border: 1px solid #ccc !important;">
                                                        <option value="">Sélectionnez un département</option>
                                                        @foreach($departements as $departement)
                                                            <option value="{{$departement->id}}" {{old('departement') == $departement->id ? 'selected' : ''}}>{{ ucfirst($departement->libelle) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="type">Service</label>
                                            <div class="field">
                                                <div class="control">
                                                    <select class=" form-control p-2 select-agent select-service" name="service" style="width:100%; heigth:38px !important; border: 1px solid #ccc !important;">
                                                        <option value="">Sélectionnez un service</option>
                                                        @foreach($services as $service)
                                                            <option value="{{$service->id}}" {{old('service') == $service->id ? 'selected' : ''}}>{{ ucfirst($service->libelle) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="nom">Contact</label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="text" id="nom" class="input" name="contact" placeholder="Contact" value="{{old('contact')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="fax">Adresse</label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="text" id="fax" class="input" name="adresse" placeholder="Adresse" value="{{old('adresse')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="fax">Photo</label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="file" id="photo" class="input" name="photo">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="num">Fonction <span class="requis">*</span></label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="text" id="num" class="input" name="poste" placeholder="Poste de l'employé" value="{{old('poste')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="type">Situation matrimoniale <span class="requis">*</span></label>
                                            <div class="field">
                                                <div class="control">
                                                    <select class=" form-control p-2" name="s_matrimoniale" style="width:100%; heigth:38px !important; border: 1px solid #ccc !important;">
                                                        <option value="Marié" {{old('s_matrimonial') == "Marié" ? 'selected' : ''}}>Marié</option>
                                                        <option value="Célibataire" {{old('s_matrimonial') == "Célibataire" ? 'selected' : ''}}>Célibataire</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="nbenfant">Nombre d'enfant <span class="requis">*</span></label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="number" id="nbenfant" class="input" name="nbenfant" placeholder="Nombre d'enfant" value="{{old('nbenfant', 0)}}" min="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="identifiant">Matricule <span class="requis">*</span></label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="text" id="identifiant" class="input" name="matricule" placeholder="Matricule de l'employé" value="{{old('matricule', $matricule??'')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="piecerecto">Pièce recto</label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="file" id="piecerecto" class="input" name="piecerecto">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="pieceverso">Pièce verso</label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="file" id="pieceverso" class="input" name="pieceverso">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="cnps">Date de debut</label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="date" id="date" class="input" name="debut" placeholder="" value="{{old('debut', date('Y-m-d'))}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="cnps">N°CNPS</label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="text" id="cnps" class="input" name="cnps" placeholder="CNPS" value="{{old('cnps')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="type">Type de contrat <span class="requis">*</span></label>
                                            <div class="field">
                                                <div class="control">
                                                    <select class=" form-control p-2" name="type_contrat" style="width:100%; heigth:38px !important; border: 1px solid #ccc !important;">
                                                        <option value="CDD" {{old('type_contrat') == "CDD" ? 'selected' : ''}}>CDD</option>
                                                        <option value="CDI" {{old('type_contrat') == "CDI" ? 'selected' : ''}}>CDI</option>
                                                        <option value="Contractuel" {{old('type_contrat') == "Contractuel" ? 'selected' : ''}}>Contractuel</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-6">
                                            <label for="salaire">Salaire de base</label>
                                            <div class="field">
                                                <div class="control">
                                                    <input type="number" id="salaire" class="input" name="salaire" placeholder="Salaire" value="{{old('salaire', 0)}}" min="0">
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
