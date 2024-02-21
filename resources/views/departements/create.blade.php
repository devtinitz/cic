<div id="addDepartement" class="modal h-modal is-big">
    <div class="modal-background h-modal-close"></div>
    <div class="modal-content">
        <form class="modal-form" method="POST" action="{{ route('departements.store') }}" target="">
            @csrf
            <div class="modal-card">
                <header class="modal-card-head">
                    <h3>Ajouter un département</h3>
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
                                    <div class="column is-12">
                                        <label for="identifiant">Libéllé</label>
                                        <div class="field">
                                            <div class="control">
                                                <input type="text" id="identifiant" class="input" name="libelle" placeholder="Libéllé du département" value="">
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
