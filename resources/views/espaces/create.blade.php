@extends('template')

@section('content')

    <div class="page-content-inner">

        <div class="profile-wrapper">

            <!--Breadcrumb-->

            @include('layouts.breadcrumb')

            <!--Edit Profile-->

            <div class="account-wrapper">

                <div class="columns">

                    <!--Navigation-->

                    <div class="column is-3">



						@include('espaces.menugauche')



                    </div>

                    <!--Form-->

                    <div class="column is-9">

					@include('layouts.flashmessage')

                        <div class="account-box is-form is-footerless">

                            <div class="form-head">

                                <div class="form-head-inner">

                                    <div class="left">

                                        <h3>{{$section_title}}</h3>

                                        <p><i class="lnil lnil-warning"></i> Cette section est réservée pour afficher la liste des users utilisateurs.</p>

                                    </div>

                                    <div class="right">

                                        <div class="buttons">

                                            @include('parts.precedent')

                                        </div>

                                    </div>

                                </div>

                            </div>
						<div class="card-grid card-grid-v1 p-5">
						<form method="post" action="{{route('espaces.store')}}">
						@csrf
                          <!--Card Grid v1-->
							<div class="columns is-multiline">

								<div class="column is-6">

									<div class="field">

										<label class="label">Libellé de l'espace utilisateur</label>

										<div class="control">

											<input class="input" type="text" name="nom" placeholder="Nom de l'espace utilisateur" required>

										</div>

									</div>

								</div>



								<div class="column is-6">

									<div class="field is-grouped demo-select">

										<div class="control">

										<label class="label">Definir comme espace par defaut</label>

											<label class="form-switch is-success">

												<input value="1" type="checkbox" name="defaut" type="checkbox" class="is-switch">

												<i></i>

											</label>

										</div>

									</div>

								</div>



                              <!--Grid item-->



								<div class="column is-4">

									<div class="card-grid-item">
                                      <div class="card-grid-item-body">

                                          <div class="left">

                                              <div class="meta">

                                                  <span class="dark-inverted" data-filter-match>Module Espace Utilisateur</span>

                                                  <span data-filter-match>Gestion des Espaces utilisateurs</span>

                                              </div>

                                          </div>

                                          <div class="field is-grouped demo-select">

                                              <div class="control">

                                                  <label class="form-switch is-success">

                                                      <input value="1" type="checkbox"   name="module_espace" type="checkbox" class="is-switch">

                                                      <i></i>

                                                  </label>

                                              </div>

                                          </div>
                                      </div>


										<div class="card-grid-item-footer">

                                          <div class="">

												<ul class="list-group list-group-flash">

													<h5 class="card-subtitle mt-2 mb-2 text-muted"></h5>

													<li class="list-group-item border-0">

														<div class=" columns">

															<div class="column is-12" style="display:inline-block;">Listing :</div>

															<div class="column is-12" style="display:inline-block;">

																<input value="1" type="checkbox"   name="module_espace_lst"><span class="slider"></span>

															</div>

														</div>

													</li>

													<li class="list-group-item border-0">

														<div class="columns">

															<div class="column is-12" style="display:inline-block;">Création :</div>

															<div class="column is-12" style="display:inline-block;">

																<input type="checkbox" value="1"  name="module_espace_crte"><span class="slider"></span>

															</div>

														</div>

													</li>



													<li class="list-group-item border-0">

														<div class="columns">

															<div class="column is-12" style="display:inline-block;">Modification :</div>

															<div class="column is-12" style="display:inline-block;">

																<input type="checkbox" value="1"  name="module_espace_edt"><span class="slider"></span>

															</div>

														</div>

													</li>



													<li class="list-group-item border-0">

														<div class="columns">

															<div class="column is-12" style="display:inline-block;">Suppression :</div>

															<div class="column is-12" style="display:inline-block;">

																<input type="checkbox" value="1"  name="module_espace_dlt"><span class="slider"></span>

															</div>

														</div>

													</li>

												</ul>

											</div>

										</div>

									</div>

								</div>

								<div class="column is-4">

									<div class="card-grid-item">
                                      <div class="card-grid-item-body">

                                          <div class="left">

                                              <div class="meta">

                                                  <span class="dark-inverted" data-filter-match>Module Utilisateur</span>

                                                  <span data-filter-match>Gestion des utilisateurs</span>

                                              </div>

                                          </div>

                                          <div class="field is-grouped demo-select">

                                              <div class="control">

                                                  <label class="form-switch is-success">

                                                      <input value="1" type="checkbox"   name="module_user" type="checkbox" class="is-switch">

                                                      <i></i>

                                                  </label>

                                              </div>

                                          </div>



                                      </div>

										<div class="card-grid-item-footer">

                                          <div class="">

												<ul class="list-group list-group-flash">

													<h5 class="card-subtitle mt-2 mb-2 text-muted"></h5>

													<li class="list-group-item border-0">

														<div class=" columns">

															<div class="column is-12" style="display:inline-block;">Listing :</div>

															<div class="column is-12" style="display:inline-block;">

																<input value="1" type="checkbox"   name="module_user_lst"><span class="slider"></span>

															</div>

														</div>

													</li>



													<li class="list-group-item border-0">

														<div class="columns">

															<div class="column is-12" style="display:inline-block;">Création :</div>

															<div class="column is-12" style="display:inline-block;">

																<input type="checkbox" value="1"  name="module_user_crte"><span class="slider"></span>

															</div>

														</div>

													</li>



													<li class="list-group-item border-0">

														<div class="columns">

															<div class="column is-12" style="display:inline-block;">Modification :</div>

															<div class="column is-12" style="display:inline-block;">

																<input type="checkbox" value="1"  name="module_user_edt"><span class="slider"></span>

															</div>

														</div>

													</li>



													<li class="list-group-item border-0">

														<div class="columns">

															<div class="column is-12" style="display:inline-block;">Suppression :</div>

															<div class="column is-12" style="display:inline-block;">

																<input type="checkbox" value="1"  name="module_user_dlt"><span class="slider"></span>

															</div>

														</div>

													</li>

												</ul>

											</div>

										</div>

									</div>

								</div>

								<div class="column is-4">

									<div class="card-grid-item">
										<div class="card-grid-item-body">

											<div class="left">

												<div class="meta">

													<span class="dark-inverted" data-filter-match>Module Département</span>

													<span data-filter-match>Gestion des département</span>

												</div>

											</div>

											<div class="field is-grouped demo-select">

												<div class="control">

													<label class="form-switch is-success">

														<input value="1" type="checkbox"   name="module_departement" type="checkbox" class="is-switch">

														<i></i>

													</label>

												</div>

											</div>



										</div>

										<div class="card-grid-item-footer">

											<div class="">

												<ul class="list-group list-group-flash">

													<h5 class="card-subtitle mt-2 mb-2 text-muted"></h5>

													<li class="list-group-item border-0">

														<div class=" columns">

															<div class="column is-12" style="display:inline-block;">Listing :</div>

															<div class="column is-12" style="display:inline-block;">

																<input value="1" type="checkbox"   name="module_departement_lst"><span class="slider"></span>

															</div>

														</div>

													</li>



													<li class="list-group-item border-0">

														<div class="columns">

															<div class="column is-12" style="display:inline-block;">Création :</div>

															<div class="column is-12" style="display:inline-block;">

																<input type="checkbox" value="1"  name="module_departement_crte"><span class="slider"></span>

															</div>

														</div>

													</li>



													<li class="list-group-item border-0">

														<div class="columns">

															<div class="column is-12" style="display:inline-block;">Modification :</div>

															<div class="column is-12" style="display:inline-block;">

																<input type="checkbox" value="1"  name="module_departement_edt"><span class="slider"></span>

															</div>

														</div>

													</li>



													<li class="list-group-item border-0">

														<div class="columns">

															<div class="column is-12" style="display:inline-block;">Suppression :</div>

															<div class="column is-12" style="display:inline-block;">

																<input type="checkbox" value="1"  name="module_departement_dlt"><span class="slider"></span>

															</div>

														</div>

													</li>

												</ul>

											</div>

										</div>

									</div>

								</div>

								<div class="column is-4">

									<div class="card-grid-item">
										<div class="card-grid-item-body">

											<div class="left">

												<div class="meta">

													<span class="dark-inverted" data-filter-match>Module Employé</span>

													<span data-filter-match>Gestion des employés</span>

												</div>

											</div>

											<div class="field is-grouped demo-select">

												<div class="control">

													<label class="form-switch is-success">

														<input value="1" type="checkbox"   name="module_employe" type="checkbox" class="is-switch">

														<i></i>

													</label>

												</div>

											</div>



										</div>

										<div class="card-grid-item-footer">

											<div class="">

												<ul class="list-group list-group-flash">

													<h5 class="card-subtitle mt-2 mb-2 text-muted"></h5>

													<li class="list-group-item border-0">

														<div class=" columns">

															<div class="column is-12" style="display:inline-block;">Listing :</div>

															<div class="column is-12" style="display:inline-block;">

																<input value="1" type="checkbox"   name="module_employe_lst"><span class="slider"></span>

															</div>

														</div>

													</li>



													<li class="list-group-item border-0">

														<div class="columns">

															<div class="column is-12" style="display:inline-block;">Création :</div>

															<div class="column is-12" style="display:inline-block;">

																<input type="checkbox" value="1"  name="module_employe_crte"><span class="slider"></span>

															</div>

														</div>

													</li>



													<li class="list-group-item border-0">

														<div class="columns">

															<div class="column is-12" style="display:inline-block;">Modification :</div>

															<div class="column is-12" style="display:inline-block;">

																<input type="checkbox" value="1"  name="module_employe_edt"><span class="slider"></span>

															</div>

														</div>

													</li>



													<li class="list-group-item border-0">

														<div class="columns">

															<div class="column is-12" style="display:inline-block;">Suppression :</div>

															<div class="column is-12" style="display:inline-block;">

																<input type="checkbox" value="1"  name="module_employe_dlt"><span class="slider"></span>

															</div>

														</div>

													</li>

												</ul>

											</div>

										</div>

									</div>

								</div>

								<div class="column is-4">

									<div class="card-grid-item">
										<div class="card-grid-item-body">

											<div class="left">

												<div class="meta">

													<span class="dark-inverted" data-filter-match>Module Permission</span>

													<span data-filter-match>Gestion des permissions</span>

												</div>

											</div>

											<div class="field is-grouped demo-select">

												<div class="control">

													<label class="form-switch is-success">

														<input value="1" type="checkbox"   name="module_permission" type="checkbox" class="is-switch">

														<i></i>

													</label>

												</div>

											</div>



										</div>

										<div class="card-grid-item-footer">

											<div class="">

												<ul class="list-group list-group-flash">

													<h5 class="card-subtitle mt-2 mb-2 text-muted"></h5>

													<li class="list-group-item border-0">

														<div class=" columns">

															<div class="column is-12" style="display:inline-block;">Listing :</div>

															<div class="column is-12" style="display:inline-block;">

																<input value="1" type="checkbox"   name="module_permission_lst"><span class="slider"></span>

															</div>

														</div>

													</li>



													<li class="list-group-item border-0">

														<div class="columns">

															<div class="column is-12" style="display:inline-block;">Création :</div>

															<div class="column is-12" style="display:inline-block;">

																<input type="checkbox" value="1"  name="module_permission_crte"><span class="slider"></span>

															</div>

														</div>

													</li>



													<li class="list-group-item border-0">

														<div class="columns">

															<div class="column is-12" style="display:inline-block;">Modification :</div>

															<div class="column is-12" style="display:inline-block;">

																<input type="checkbox" value="1"  name="module_permission_edt"><span class="slider"></span>

															</div>

														</div>

													</li>



													<li class="list-group-item border-0">

														<div class="columns">

															<div class="column is-12" style="display:inline-block;">Suppression :</div>

															<div class="column is-12" style="display:inline-block;">

																<input type="checkbox" value="1"  name="module_permission_dlt"><span class="slider"></span>

															</div>

														</div>

													</li>

												</ul>

											</div>

										</div>

									</div>

								</div>

								<div class="column is-4">

									<div class="card-grid-item">
										<div class="card-grid-item-body">

											<div class="left">

												<div class="meta">

													<span class="dark-inverted" data-filter-match>Module Présence</span>

													<span data-filter-match>Gestion des présences</span>

												</div>

											</div>

											<div class="field is-grouped demo-select">

												<div class="control">

													<label class="form-switch is-success">

														<input value="1" type="checkbox"   name="module_presence" type="checkbox" class="is-switch">

														<i></i>

													</label>

												</div>

											</div>



										</div>

										<div class="card-grid-item-footer">

											<div class="">

												<ul class="list-group list-group-flash">

													<h5 class="card-subtitle mt-2 mb-2 text-muted"></h5>

													<li class="list-group-item border-0">

														<div class=" columns">

															<div class="column is-12" style="display:inline-block;">Listing :</div>

															<div class="column is-12" style="display:inline-block;">

																<input value="1" type="checkbox"   name="module_presence_lst"><span class="slider"></span>

															</div>

														</div>

													</li>



													<li class="list-group-item border-0">

														<div class="columns">

															<div class="column is-12" style="display:inline-block;">Création :</div>

															<div class="column is-12" style="display:inline-block;">

																<input type="checkbox" value="1"  name="module_presence_crte"><span class="slider"></span>

															</div>

														</div>

													</li>



													<li class="list-group-item border-0">

														<div class="columns">

															<div class="column is-12" style="display:inline-block;">Modification :</div>

															<div class="column is-12" style="display:inline-block;">

																<input type="checkbox" value="1"  name="module_presence_edt"><span class="slider"></span>

															</div>

														</div>

													</li>



													<li class="list-group-item border-0">

														<div class="columns">

															<div class="column is-12" style="display:inline-block;">Suppression :</div>

															<div class="column is-12" style="display:inline-block;">

																<input type="checkbox" value="1"  name="module_presence_dlt"><span class="slider"></span>

															</div>

														</div>

													</li>

												</ul>

											</div>

										</div>

									</div>

								</div>

								<div class="column is-4">

									<div class="card-grid-item">
										<div class="card-grid-item-body">

											<div class="left">

												<div class="meta">

													<span class="dark-inverted" data-filter-match>Module Configuration</span>

													<span data-filter-match>Configuration de l'application</span>

												</div>

											</div>

											<div class="field is-grouped demo-select">

												<div class="control">

													<label class="form-switch is-success">

														<input value="1" type="checkbox"   name="module_setting" type="checkbox" class="is-switch">

														<i></i>

													</label>

												</div>

											</div>



										</div>

										<div class="card-grid-item-footer">

											<div class="">

												<ul class="list-group list-group-flash">

													<h5 class="card-subtitle mt-2 mb-2 text-muted"></h5>

													<li class="list-group-item border-0">

														<div class="columns">

															<div class="column is-12" style="display:inline-block;">Modification :</div>

															<div class="column is-12" style="display:inline-block;">

																<input type="checkbox" value="1"  name="module_setting_edt"><span class="slider"></span>

															</div>

														</div>

													</li>

												</ul>

											</div>

										</div>

									</div>

								</div>

							</div>
							<div class="columns">
								<div class="column is-12">
									<div class="text-center">
                                        <button id="save-button" class="button h-button is-primary is-raised w-50" type="submit" style="background-color: {{$setting->companycolor}}; color : #fff !important;">
                                            <span class="icon">
                                              <i class="lnil lnil-save"></i>
                                            </span>
                                            <span>Enregistrer</span>
                                        </button>
									</div>
								</div>
							</div>
						</form>
					  </div>
						</div>
                    </div>
                </div>
            </div>

@endsection
