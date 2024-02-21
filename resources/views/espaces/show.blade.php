@extends('template')
@push('css')
    <style>
        label{
            font-weight: bold;
        }
    </style>
@endpush
@section('content')
    <div class="page-content-inner">
        <div class="profile-wrapper">
            <!--Breadcrumb-->
        @include('layouts.breadcrumb')
        <!--Edit Profile-->
            <div class="account-wrapper">
                <div class="columns">
                    <!--Navigation-->
                    @include('espaces.menugauche')
                    <!--Form-->
                    <div class="column is-9">
                    @include('layouts.flashmessage')
                        <div class="account-box is-form is-footerless">
                            <div class="form-head">
                                <div class="form-head-inner">
                                    <div class="left">
                                        <h3>{{$section_title}}</h3>
                                        <p><i class="lnil lnil-warning"></i> Cette section est réservée pour les détails d'un espace utilisateur.</p>
                                    </div>
                                    <div class="right">
                                        <div class="buttons">
                                            @include('parts.precedent')
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-body">
                                <!--Fieldset-->
                                <div class="fieldset" style="max-width: none !important;">
                                    <div class="columns is-multiline">
                                        <!--Field-->
                                        <div class="column is-3">
                                            <label for="identifiant">Nom de l'espace</label>
                                            <div class="field">
                                                <div class="control has-icon">
                                                    <p><b>{{$espace->nom}}</b></p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Field-->
                                        <div class="column is-3">
                                            <label for="type">Total utilisateurs </label>
                                            <div class="field">
                                                <div class="control has-icon">
                                                    <p><b>{{$espace->users->count()}}</b></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-3">
                                            <label for="nom">Crée le</label>
                                            <div class="field">
                                                <div class="control has-icon">
                                                    <p><b>{{date('d/m/Y à H:i:s',strtotime($espace->created_at))}} par {{ucfirst($espace->created_by)}}</b></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-3">
                                            <label for="nom">Espace par defaut</label>
                                            <div class="field">
                                                <div class="control has-icon">
                                                    <p><b>{{($espace->defaut == 1) ? 'Oui':'Non'}}</b></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="columns">
                    <div class="column is-12">
                        <div class="page-content-inner all-projects">
                            <div class="columns">
                                <div class="column is-12">
                                    <div class="account-box is-form is-footerless">
                                        <div class="form-head">
                                            <div class="form-head-inner">
                                                <div class="left">
                                                    <h3>Liste des utilisateurs</h3>
                                                    <p><i class="lnil lnil-warning"></i> Cette section est réservée pour afficher la liste des utilisateurs affectés a cet espace.</p>
                                                </div>                                            
                                            </div>
                                        </div>
                                        <div class="form-body">
                                    
                                            <div class="s-card demo-table column.is-half">
                                                <table  id="example" class="" style="width:100%">
													<thead>
														<tr class="table100-head">
															<th>Nom</th>
															<th>Contact</th>
															<th>Fonction</th>
															<th>Statut</th>
															<th>Crée le</th>
															<th class="column6">Actions</th>
														</tr>
													</thead>
													<tbody>
														@foreach($espace->users as $u)
															<tr>

																<td>{{ucfirst($u->name)}} {{ucfirst($u->prenoms)}}</td>
																<td>{{$u->email}}
																	<br>
																	{{$u->telephone}}
																</td>
																<td>{{$u->fonction}}</td>
																<td>
																	@if($u->statut ==1)
																		<span class="tag is-success">Actif</span>
																	@else
																		<span class="tag is-warning">Inactif</span>

																	@endif
																</td>
																<td>{{date('d/m/Y à H:i:s',strtotime($u->created_at))}} par {{ucfirst($u->created_by)}}</td>
																<td class="column6 text-center">
																	<div class="dropdown">
																		<a class="btn btn-sm btn-icon-only text-dark action" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																			<i class="fas fa-ellipsis-v"></i>
																		</a>
																		<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow dropdown-content">
																			<a class="dropdown-item" href="{{route('users.edit',$u->id)}}"><i class="lnil lnil-pencil"></i> Modifier</a>
																			@if($u->statut ==1)
																				<a class="dropdown-item" href="{{route('users.editstate',$u->id)}}" onclick="return confirm('Voulez-vous Desactiver cet utilisateur ?')"><i class="lnil lnil-close"></i> Désactiver</a>
																			@else
																				<a class="dropdown-item" href="{{route('users.editstate',$u->id)}}" onclick="return confirm('Voulez-vous Activer cet utilisateur ?')"><i class="lnil lnil-checkmark"></i> Désactiver</a>
																			@endif
																			<hr class="dropdown-divider">
																			<a class="dropdown-item" href="{{route('users.delete',$u->id)}}" onclick="return confirm('Voulez-vous Supprimer cet utilisateur ?')" class="dropdown-item is-media"><i class="lnil lnil-trash-can-alt"></i> Supprimer</a>
																		</div>
																	</div>
																</td>
															</tr>
														@endforeach
													</tbody>
												</table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>      
                        </div>      
                    </div>
				</div>
            </div>
@endsection