<div id="searchPermission" class="modal h-modal is-big">
    <div class="modal-background h-modal-close"></div>
    <div class="modal-content">
        <form class="modal-form" id="search_form" method="get" action="{{ route('permissions.search') }}" target="">
            <div class="modal-card">
                <header class="modal-card-head">
                    <h3>Rechercher une permission</h3>
                    <button class="h-modal-close ml-auto" aria-label="close">
                        <i data-feather="x"></i>
                    </button>
                </header>
                <div class="modal-card-body">
                    <div class="inner-content">
                        <div class="form-body">
                            <div class="form-fieldset">
                                <div class="columns is-multiline">
                                    <div class="column is-6">
                                        <label for="type">Employé</label>
                                        <div class="field">
                                            <div class="control">
                                                <select class=" form-control p-2 select-agent" name="employe" style="width:100%; heigth:38px !important; border: 1px solid #ccc !important;">
                                                    <option value="">Tous</option>
                                                    @foreach($employes as $employe)
                                                        <option value="{{$employe->id}}" {{old('employe') == $employe->id ? 'selected' : ''}}>{{ ucfirst($employe->firstname.' '.$employe->lastname) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-6">
                                        <label for="type">Département</label>
                                        <div class="field">
                                            <div class="control">
                                                <select class=" form-control p-2 select-agent" name="departement" style="width:100%; heigth:38px !important; border: 1px solid #ccc !important;">
                                                    <option value="">Tous</option>
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
                                                <select class=" form-control p-2 select-agent" name="service" style="width:100%; heigth:38px !important; border: 1px solid #ccc !important;">
                                                    <option value="">Tous</option>
                                                    @foreach($services as $service)
                                                        <option value="{{$service->id}}" {{old('service') == $service->id ? 'selected' : ''}}>{{ ucfirst($service->libelle) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-6">
                                        <label for="identifiant">Motif</label>
                                        <div class="field">
                                            <div class="control">
                                                <input type="text" class="input" name="motif" placeholder="" value="{{old('motif')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h4 class="text-center mt-3 mb-2">Période</h4>
                                    </div>
                                    <div class="column is-6">
                                        <label for="nbenfant">Date de debut</label>
                                        <div class="field">
                                            <div class="control">
                                                <input type="datetime-local" class="input" name="debut" placeholder="" value="{{old('debut')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-6">
                                        <label for="identifiant">Date de retour</label>
                                        <div class="field">
                                            <div class="control">
                                                <input type="datetime-local" class="input" name="fin" placeholder="" value="{{old('fin')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-6">
                                        <div class="field">
                                            <label>Exporter en pdf</label>
                                            <div class="control has-icon">
                                                <div class="switch-bloc no-padding-all">
                                                    <label class="form-switch is-primary">
                                                        <input type="checkbox" id="checked" name="export" class="is-switch">
                                                        <i></i>
                                                    </label>
                                                </div>
                                                {{--<input type="email" id="code_contribuable" class="input" name="email" placeholder="Email" value="{{old('email')}}">--}}
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

@push('scripts')
    <script>
        $(document).ready(function(e) {
            $('input[type="checkbox"]').click(function(){
                if($(this).prop("checked") == true){
                    $('#search_form').attr('target', '_blank');
                }else if($(this).prop("checked") == false){
                    $('#search_form').attr('target', '');
                }
            });
        });
    </script>
@endpush
