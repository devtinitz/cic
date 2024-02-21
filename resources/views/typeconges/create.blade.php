<div id="addTypeConge" class="modal h-modal is-big">
    <div class="modal-background h-modal-close"></div>
    <div class="modal-content">
        <form class="modal-form" method="POST" action="{{ route('typeconges.store') }}" target="">
            @csrf
            <div class="modal-card">
                <header class="modal-card-head">
                    <h3>Ajouter un type de congé</h3>
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
                                        <label for="identifiant">Libéllé</label>
                                        <div class="field">
                                            <div class="control">
                                                <input type="text" id="identifiant" class="input" name="libelle" placeholder="Libéllé du type de congé" value="">
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
