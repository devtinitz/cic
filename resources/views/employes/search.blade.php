<div id="searchEmploye" class="modal h-modal is-big">
    <div class="modal-background h-modal-close"></div>
    <div class="modal-content">
        <form class="modal-form" method="get" action="{{ route('employes.search') }}" target="">
            <div class="modal-card">
                <header class="modal-card-head">
                    <h3>Rechercher un employé</h3>
                    <button class="h-modal-close ml-auto" aria-label="close">
                        <i data-feather="x"></i>
                    </button>
                </header>
                <div class="modal-card-body">
                    <div class="inner-content">
                        <div class="form-body">
                            <div class="form-fieldset">
                                <div class="columns is-multiline">
                                    <div class="column is-12">
                                        <h4 class="text-center">Informations sur l'employé</h4>
                                    </div>
                                    <div class="column is-6">
                                        <label for="identifiant">Matricule</label>
                                        <div class="field">
                                            <div class="control">
                                                <input type="text" id="identifiant" class="input" name="matricule" placeholder="Matricule de l'employé" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-6">
                                        <label for="identifiant">Nom</label>
                                        <div class="field">
                                            <div class="control">
                                                <input type="text" id="identifiant" class="input" name="nom" placeholder="Nom de l'employé" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-6">
                                        <label for="num">Prénom(s)</label>
                                        <div class="field">
                                            <div class="control">
                                                <input type="text" id="num" class="input" name="prenoms" placeholder="Prénom(s) de l'employé" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-6">
                                        <label for="type">Direction</label>
                                        <div class="field">
                                            <div class="control">
                                                <select class=" form-control p-2" name="departement" style="width:100%; heigth:38px !important; border: 1px solid #ccc !important;">
                                                    <option value="">Tous</option>
                                                    @foreach($departements as $departement)
                                                    <option value="{{ $departement->id }}">{{ ucfirst($departement->libelle) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-6">
                                        <label for="type">Service</label>
                                        <div class="field">
                                            <div class="control">
                                                <select class=" form-control p-2" name="service" style="width:100%; heigth:38px !important; border: 1px solid #ccc !important;">
                                                    <option value="">Tous</option>
                                                    @foreach($services as $service)
                                                        <option value="{{$service->id}}">{{ ucfirst($service->libelle) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-6">
                                        <label for="num">Poste</label>
                                        <div class="field">
                                            <div class="control">
                                                <input type="text" id="num" class="input" name="poste" placeholder="Poste de l'employé" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-6">
                                        <label for="type">Situation matrimoniale</label>
                                        <div class="field">
                                            <div class="control">
                                                <select class=" form-control p-2" name="s_matrimoniale" style="width:100%; heigth:38px !important; border: 1px solid #ccc !important;">
                                                    <option value="all">Tous</option>
                                                    <option value="Marié">Marié</option>
                                                    <option value="Célibataire">Célibataire</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-6">
                                        <label for="type">Type de contrat</label>
                                        <div class="field">
                                            <div class="control">
                                                <select class=" form-control p-2" name="type_contrat" style="width:100%; heigth:38px !important; border: 1px solid #ccc !important;">
                                                    <option value="all">Tous</option>
                                                    <option value="CDD">CDD</option>
                                                    <option value="CDI">CDI</option>
                                                    <option value="Contractuel">Contractuel</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-card-foot is-end">
                <button id="save-button" type="submit" class="button h-button is-primary is-raised" style="background-color: {{$setting->companycolor}}; color : #fff !important;">Valider</button>
            </div>
        </form>
    </div>
</div>
