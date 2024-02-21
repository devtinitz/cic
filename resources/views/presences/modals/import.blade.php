<div id="importPointage" class="modal h-modal is-big">
    <div class="modal-background h-modal-close"></div>
    <div class="modal-content">
        <form class="modal-form" id="" method="post" action="{{ route('presences.import')}}" enctype="multipart/form-data">
            @csrf
            <div class="modal-card">
                <header class="modal-card-head">
                    <h3>Importation du pointage</h3>
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
                                        <label for="type">Fichier <span class="text-danger"></span></label>
                                        <div class="field">
                                            <div class="control">
                                                <input type="file" id="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"  class="input" name="file" placeholder="" required>
                                                <span class="text-muted">Extensions acceptées : <span class="text-danger">.csv, .xlsx, .xls</span></span>
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
                <button id="save-button" type="submit" class="button h-button is-primary is-raised" style="background-color: {{$setting->companycolor}}; color : #fff !important;">Importer</button>
            </div>
        </form>
    </div>
</div>