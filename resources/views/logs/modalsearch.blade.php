<div id="modalSearch" class="modal h-modal is-medium">
    <div class="modal-background h-modal-close"></div>
	<div class="modal-content">
		<form class="modal-form"  method="get" action="{{route('logs.search')}}">
			<div class="modal-card">
				<header class="modal-card-head">
					<h3>Recherche avancée</h3>
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
										<label for="type">Utilisateur *</label>
										<div class="field">
											<div class="control">
												<select class="select-user form-control p-2" name="user" style="width:100%; heigth:38px !important; border: 1px solid #ccc !important;">
													<option value="all">Tous</option>
													@foreach($users as $u)
														<option value="{{$u->id}}">{{ ucfirst($u->name) }}  {{ ucfirst($u->prenoms) }}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
									<div class="column is-6">                                            
										<div class="field">
											<label>Module</label>
											<div class="control">
												<input type="text" class="input" id="module" name="module" placeholder="Exemple:transaction">
												
											</div>
										</div>
									</div>
									
									<div class="column is-6">                                            
										<div class="field">
											<label>Action</label>
											<div class="control">
												<input type="text" class="input" id="action" name="action" placeholder="Exemple:enregistrement de transaction">
											</div>
										</div>
									</div>
									
									<div class="column is-6">                                            
										<div class="field">
											<label>Début</label>
											<div class="control has-icon">
												<input type="date" class="input" id="from" name="from" value="{{date('2021-01-01')}}">
												<div class="form-icon">
													<i data-feather="calendar"></i>
												</div>
											</div>
										</div>
									</div>
								
									<div class="column is-6">
										<div class="field">
											<label>Fin</label>
											<div class="control has-icon">
												<input type="date" class="input" id="to" name="to" value="{{date('Y-m-d')}}">
												<div class="form-icon">
													<i data-feather="calendar"></i>
												</div>
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