<div id="importEmploye" class="modal h-modal is-big">
    <div class="modal-background h-modal-close"></div>
    <div class="modal-content">
        <form class="modal-form" method="post" action="{{ route('employes.import') }}" target=""  enctype="multipart/form-data">
            <div class="modal-card">
                {{ csrf_field() }}
                <header class="modal-card-head">
                    <h3>Importer des employés</h3>
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
                                        <label for="identifiant">Fichier</label>
                                        <div class="field">
                                            <div class="control">
                                                <input type="file" id="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"  class="input" name="file" placeholder="" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-6">
                                        <label for="identifiant">Pour télécharger le model du fichier</label>
                                        <div class="field">
                                            <div class="control">

                                                <a href="{{url('public/employe/fichier_model.xlsx')}}" target="_blank">Clique ICI</a>

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
