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
                        <form method="post" action="{{route('users.password.store')}}">
                            @csrf
                            @include('layouts.flashmessage')
                            <div class="account-box is-form is-footerless">
                                <div class="form-head">
                                    <div class="form-head-inner">
                                        <div class="left">
                                            <h3>{{$section_title}}</h3>
                                            <p>Cette section est réservée pour la modification de mot de passe</p>
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
                                    <div class="">
                                        <div class="columns is-multiline">
                                            <!--Field-->
                                            <div class="column is-6">
                                                <label for="datedebut">Mot de passe *</label>
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
                                                <label for="datedebut">Confirmez le Mot de passe *</label>
                                                <div class="field">
                                                    <div class="control has-icon">
                                                        <input type="text" class="input password" id="password" name="password_confirmation" placeholder="">
                                                        <div class="form-icon">
                                                            <i data-feather="map-pin"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
											<a class="btn btn-default ml-2" onclick="generatePassword()"><i class="fa fa-cogs"></i>Générer un mot de passe</a>											
											
                                        </div>
                                    </div>
									


                                    <div class="fieldset">
                                        <div class="columns is-multiline">
                                            <!--Field-->
                                            <div class="buttons">                                                
                                                <button id="save-button" type="submit" class="button h-button is-primary is-raised" style="background-color: {{$setting->companycolor}}; color : #fff !important;">Enregistrer</button>
                                            </div>
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
               var i = Math.floor(Math.random() * chars.length);
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