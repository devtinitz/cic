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

                    <!--Form-->
                    <div class="column is-12">
                        <form action="{{route('settings.updatesettings')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="account-box is-form is-footerless">
                                <div class="form-head">
                                    <div class="form-head-inner">
                                        <div class="left">
                                            <h3>{{$section_title}}</h3>
                                            <p>Cette section est réservée pour la configuration des paramètres généraux du système</p>
                                        </div>
                                        <div class="right">
                                            <div class="buttons">
                                                <a href="#" class="button h-button is-light is-dark-outlined">
                                              <span class="icon">
                                                  <i class="lnir lnir-arrow-left rem-100"></i>
                                              </span>
                                                    <span>Précédent</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-body">
                                    <div class="fieldset" style="max-width: 700px ">
                                        <div class="s-card demo-table">
                                            @include('layouts.flashmessage')
                                            <div class="column is-12">
                                                <div class="field">
                                                    <div class="control has-icon">
                                                        <center><img src="{{ $setting->companylogo }}" alt="Logo de la compagnie" style="width:250px;"/></center><br/>
                                                        <b><label>Logo</label></b>
                                                        <input name="logo" type="file" class="input"  />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="column is-12">
                                                <div class="field">
                                                    <div class="control has-icon">
                                                        <b><label>Dénomination</label></b>
                                                        <input name="companyname" type="text" class="input" placeholder="Nom de la compagnie" value="{!! html_entity_decode($setting->companyname) !!}" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="column is-12">
                                                <div class="field">
                                                    <div class="control has-icon">
                                                        <b><label>Téléphone</label></b>
                                                        <input name="companycontact" type="text" class="input" placeholder="Téléphone de la compagnie" value="{{ $setting->companycontact }}" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="column is-12">
                                                <div class="field">
                                                    <div class="control has-icon">
                                                        <b><label>Email</label></b>
                                                        <input name="email" type="text" class="input" placeholder="Email" value="{{ $setting->email }}" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="column is-12">
                                                <div class="field">
                                                    <div class="control has-icon">
                                                        <b><label>Siège social</label></b>
                                                        <input name="localisation" type="text" class="input" placeholder="Localisation" value="{{ $setting->localisation }}" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="column is-12">
                                                <div class="field">
                                                    <div class="control has-icon">
                                                        <b><label>Couleur principale</label></b>
                                                        <input name="companycolor" type="color" class="input" placeholder="Couleur principale" value="{{ $setting->companycolor }}" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="column is-12">
                                                <div class="field">
                                                    <div class="control has-icon">
                                                        <b><label>Facebook</label></b>
                                                        <input name="facebook" type="text" class="input" placeholder="Facebook" value="{{ $setting->facebook }}" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="column is-12">
                                                <div class="field">
                                                    <div class="control has-icon">
                                                        <b><label>Twitter</label></b>
                                                        <input name="twitter" type="text" class="input" placeholder="Twitter" value="{{ $setting->twitter }}" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="column is-12">
                                                <div class="field">
                                                    <div class="control has-icon">
                                                        <b><label>Linkedin</label></b>
                                                        <input name="linkedin" type="text" class="input" placeholder="Likedin" value="{{ $setting->linkedin }}" />
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-12">
                                            <h3 class="text-center">Horaires</h3>
                                            <div class="row">
                                                <div class="column is-12">
                                                    <b>Heures de travail (Matin & soir)</b>
                                                </div>

                                                <div class="column is-6">
                                                    <div class="field">
                                                        <div class="control has-icon">
                                                            <b><label>De</label></b>
                                                            <input name="debut_matin" type="time" class="input" placeholder="" value="{{ $setting->debut_matin }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column is-6">
                                                    <div class="field">
                                                        <div class="control has-icon">
                                                            <b><label>A</label></b>
                                                            <input name="fin_matin" type="time" class="input" placeholder="" value="{{ $setting->fin_matin }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column is-6">
                                                    <div class="field">
                                                        <div class="control has-icon">
                                                            <b><label>De</label></b>
                                                            <input name="debut_soir" type="time" class="input" placeholder="" value="{{ $setting->debut_soir }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column is-6">
                                                    <div class="field">
                                                        <div class="control has-icon">
                                                            <b><label>A</label></b>
                                                            <input name="fin_soir" type="time" class="input" placeholder="" value="{{ $setting->fin_soir }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column is-12">
                                                    <b>Heures de pause</b>
                                                </div>
                                                <div class="column is-6">
                                                    <div class="field">
                                                        <div class="control has-icon">
                                                            <b><label>De</label></b>
                                                            <input name="debut_pause" type="time" class="input" placeholder="" value="{{ $setting->debut_pause }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column is-6">
                                                    <div class="field">
                                                        <div class="control has-icon">
                                                            <b><label>A</label></b>
                                                            <input name="fin_pause" type="time" class="input" placeholder="" value="{{ $setting->fin_pause }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="fieldset">
                                        <div class="">
                                            <!--Field-->
                                            <div class="buttons" style="display: block; text-align: center">
                                                <a href="{{ redirect()->back()->getTargetUrl() }}" class="button h-button is-light is-dark-outlined">
                                                          <span class="icon">
                                                              <i class="lnir lnir-arrow-left rem-100"></i>
                                                          </span>
                                                    <span>Précédent</span>
                                                </a>
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
