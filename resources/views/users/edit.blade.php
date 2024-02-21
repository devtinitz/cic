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

                        @include('users.menugauche')

                    </div>



                    <!--Form-->

                    <div class="column is-9">

                        <form method="post" action="{{route('users.update')}}">



                            @csrf



                            @include('layouts.flashmessage')

                            <div class="account-box is-form is-footerless">

                                <div class="form-head">

                                    <div class="form-head-inner">

                                        <div class="left">

                                            <h3>{{$section_title}}</h3>

                                            <p>Cette section est réservée pour la modification des informations d'un utilisateur</p>

                                        </div>

                                        <div class="right">

                                            <div class="buttons">

                                                <div class="buttons">

                                                    @include('parts.precedent')

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="form-body">

                                    <!--Fieldset-->

                                    <div class="">

                                        <div class="columns is-multiline">



											<div class="column is-6">

                                                <label for="espace">Espace utilisateur <span class="red">*</span></label>

                                                <div class="field">

                                                    <div class="control">

                                                        <select class=" form-control p-2" name="espace" id="espace" style="width:100%; heigth:38px !important; border: 1px solid #ccc !important;">

                                                            @foreach($espaces as $e)

                                                                <option value="{{$e->id}}" {{$olduser->espace_id == $e->id ?'selected':''}}>{{ucfirst($e->nom)}}</option>

                                                            @endforeach

                                                        </select>

                                                    </div>

                                                </div>

                                            </div>



											<div class="column is-6">

												<label for="nom">Login <span class="red">*</span></label>

												<div class="field">

													<div class="control has-icon">

														<input type="hidden" id="id" class="input" name="id" value="{{$olduser->id}}">

														<input type="text" id="login" class="input" name="username" value="{{$olduser->username}}">

														<div class="form-icon">

															<i data-feather="user"></i>

														</div>

													</div>

												</div>

											</div>


                                            <div class="column is-6">

                                                <label for="nom">Nom <span class="red">*</span></label>

                                                <div class="field">

                                                    <div class="control has-icon">

                                                        <input type="text" id="nom" class="input" name="nom" value="{{$olduser->name}}">

                                                        <div class="form-icon">

                                                            <i data-feather="user"></i>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>



                                            <div class="column is-6">

                                                <label for="prenoms">Prénom(s) <span class="red">*</span></label>

                                                <div class="field">

                                                    <div class="control has-icon">

                                                        <input type="text" id="prenoms" name="prenoms" class="input" value="{{$olduser->prenoms}}">

                                                         <div class="form-icon">

															<i data-feather="user"></i>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="column is-6">

                                                <label for="email">Email <span class="red">*</span></label>

                                                <div class="field">

                                                    <div class="control has-icon">

                                                        <input type="email" id="email" name="email" class="input" value="{{$olduser->email}} ">

                                                        <div class="form-icon">

                                                            <i data-feather="user"></i>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="column is-6">

                                                <label for="contact">Contact <span class="red">*</span></label>

                                                <div class="field">

                                                    <div class="control has-icon">

                                                        <input type="tel" id="contact" name="telephone" class="input" value="{{$olduser->telephone}}">

                                                        <div class="form-icon">

                                                            <i data-feather="user"></i>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>







                                            <div class="column is-6">

                                                <label for="pays">Pays <span class="red">*</span></label>

                                                <div class="field">

                                                    <div class="control">

                                                        <select class="select-pays" name="pays">

                                                            <option>Selectionnez le pays</option>

                                                            @foreach($countries as $country)

                                                                <option value="{{$country->id}}" {{$olduser->country_id == $country->id ?'selected':''}}>{{ucfirst($country->name)}}</option>

                                                            @endforeach

                                                        </select>

                                                    </div>

                                                </div>

                                            </div>



                                            <div class="column is-6">

                                                <label for="ville">Ville <span class="red">*</span></label>

                                                <div class="field">

                                                    <div class="control has-icon">

                                                        <input type="text" class="input" name="ville" id="ville" value="{{$olduser->ville}}">

                                                        <div class="form-icon">

                                                            <i data-feather="map-pin"></i>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="column is-6">

                                                <label for="adresse">Adresse <span class="red">*</span></label>

                                                <div class="field">

                                                    <div class="control has-icon">

                                                        <input type="text" class="input" id="adresse" name="adresse" value="{{$olduser->adresse}}">

                                                        <div class="form-icon">

                                                            <i data-feather="map-pin"></i>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>



											<div class="column is-6">

                                                <label for="fonction">Fonction <span class="red">*</span></label>

                                                <div class="field">

                                                    <div class="control has-icon">

                                                        <input type="text" class="input" id="fonction" name="fonction" value="{!! html_entity_decode($olduser->fonction)!!}">

                                                        <div class="form-icon">

                                                            <i data-feather="map-pin"></i>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>



											<div class="column is-6">

                                                <label for="datedebut">Date debut <span class="red">*</span></label>

                                                <div class="field">

                                                    <div class="control has-icon">

                                                        <input type="date" class="input" id="datedebut" name="datedebut" value="{{$olduser->datedebut}}">

                                                        <div class="form-icon">

                                                            <i data-feather="map-pin"></i>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>



                                            <div class="column is-6">

                                                <label for="pays">Role <span class="red">*</span></label>

                                                <div class="field">

                                                    <div class="control">

                                                        <select class="select-pays" name="role" style="width:100%;">

                                                            <option value="admin" {{$olduser->role == 'admin' ?'selected':''}}>Administrateur</option>

                                                            <option value="superviseur" {{$olduser->role == 'superviseur' ?'selected':''}}>Superviseur</option>

                                                            <option value="user" {{$olduser->role == 'user' ?'selected':''}}>Utilisateur</option>

                                                        </select>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>


                                        <div class="columns is-multiline">

                                            <!--Field-->
                                            <div class="column is-6">

                                                <label for="datedebut">Mot de passe <span class="red">*</span> <a class="btn-sm btn btn-warning ml-2" onclick="generatePassword()"><i class="fas fa-cogs"></i> Générer un mot de passe</a></label>

                                                <div class="field">

                                                    <div class="control has-icon">

                                                        <input type="text" class="input password" id="password" name="password" placeholder="">

                                                        <div class="form-icon">

                                                            <i data-feather="map-pin"></i>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>



											<div class="column is-6">

                                                <label for="datedebut">Confirmez le Mot de passe <span class="red">*</span></label>

                                                <div class="field">

                                                    <div class="control has-icon">

                                                        <input type="text" class="input password" id="password" name="password_confirmation" placeholder="">

                                                        <div class="form-icon">

                                                            <i data-feather="map-pin"></i>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>



                                    </div>



                                    <div class="row mt-5">
                                        <div class="col-md-12 text-center">
                                            @include('parts.precedent')
                                            <button id="save-button" type="submit" class="button h-button is-primary is-raised" style="background-color: {{$setting->companycolor}}; color : #fff !important;">
                                                <span class="icon">
                                                      <i class="lnir lnir-save rem-100"></i>
                                                  </span>
                                                <span>
                                                    Enregistrer
                                                </span>
                                            </button>
                                        </div>
                                    </div>



                                </div>

                            </div>

                        </form>



                    </div>



                </div>

            </div>

@endsection

@push('scripts')

    <script>



       function randomPassword(length) {

           var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOP1234567890";

           var pass = "";

           for (var x = 0; x < length; x++) {

               var i = Math.floor(Math.random() <span class="red">*</span> chars.length);

               pass += chars.charAt(i);

           }

           return pass;

       }



       window.generatePassword = function() {

           $('.password').val(randomPassword(6));

           $('#passwordchp').text(randomPassword(6));



       }

   </script>





@endpush
