@extends('install.layout')
@push('css')
    <style>
        img{
            width: 250px;
            border: 1px solid #ddd;
            border-radius: 50%;
            margin-bottom: 10px
        }
    </style>
@endpush
@section('content')
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-folder-close"></i>
                Configuration des paramétrages généraux de l'application
            </h3>
        </div>
        <div class="panel-body">
            @if($errors->any())
                <div class="row">
                    <div class="alert alert-error">
                        <ul class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <form action="{{ route('install.configuration.submit') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="panel-group" style="margin-bottom : 0px">
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div>
                                    <center>
                                        <img src="{{ asset('/img/logo-default.jpg') }}" alt="Logo de la compagnie">
                                    </center>
                                </div>
                                <div class="col-md-2"><label>Logo </label></div>
                                <div class="col-md-10">
                                    <input type="file" name="companylogo" value="{{ old('companylogo') }}" class="form-control" accept="image">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Dénomination <span class="red">*</span></label></div>
                                <div class="col-md-10"><input type="text" name="companyname" value="{{ old('companyname') }}" class="form-control" placeholder="Dénomination de l'entreprise"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Contact <span class="red">*</span></label></div>
                                <div class="col-md-10"><input type="text" name="companycontact" value="{{ old('companycontact') }}" class="form-control" placeholder="Contact de l'entreprise"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Email <span class="red">*</span></label></div>
                                <div class="col-md-10"><input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email de l'entreprise"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Siège social <span class="red">*</span></label></div>
                                <div class="col-md-10"><input type="text" name="localisation" value="{{ old('localisation') }}" class="form-control" placeholder="Adresse de l'entreprise"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Couleur principale</label></div>
                                <div class="col-md-10"><input type="color" name="companycolor" value="{{ old('companycolor', '#0c1979') }}" class="form-control" placeholder="Mot de passe de la base de données"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Facebook</label></div>
                                <div class="col-md-10"><input type="url" name="facebook" value="" class="form-control" placeholder="Facebook de l'entreprise"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Twitter</label></div>
                                <div class="col-md-10"><input type="url" name="twitter" value="" class="form-control" placeholder="Twitter de l'entreprise"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Linkedin</label></div>
                                <div class="col-md-10"><input type="url" name="linkedin" value="" class="form-control" placeholder="Linkedin de l'entreprise"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 text-center partial" style="margin-bottom : 0px !important;  display : none">
                                @include('install.partial')
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success" type="submit">
                    Enregistrer
                </button>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function(){
            $('form').submit(function () {
                $('.partial').css('display','block');
            });
        });
    </script>
@endpush
