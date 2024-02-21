@extends('install.layout')
@section('content')
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-folder-close"></i>
                Compte administrateur
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
            <form action="{{ route('install.account.submit') }}" method="post">
                @csrf
                <div class="panel-group" style="margin-bottom : 0px">
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Login <span class="red">*</span></label></div>
                                <div class="col-md-10"><input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="Login"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Nom <span class="red">*</span></label></div>
                                <div class="col-md-10"><input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Nom"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Prénom(s) <span class="red">*</span></label></div>
                                <div class="col-md-10"><input type="text" name="prenoms" value="{{ old('prenoms') }}" class="form-control" placeholder="Prénom(s)"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Email <span class="red">*</span></label></div>
                                <div class="col-md-10"><input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Pays <span class="red">*</span></label></div>
                                <div class="col-md-10">
                                    <select id="" name="pays" class="form-control pays" required>
                                        @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ $country->id == old('pays') }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Ville <span class="red">*</span></label></div>
                                <div class="col-md-10"><input type="text" name="ville" value="{{ old('ville') }}" class="form-control" placeholder="Ville"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Adresse <span class="red">*</span></label></div>
                                <div class="col-md-10"><input type="text" name="adresse" value="{{ old('adresse') }}" class="form-control" placeholder="Adresse"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Fonction <span class="red">*</span></label></div>
                                <div class="col-md-10"><input type="text" name="fonction" value="{{ old('fonction') }}" class="form-control" placeholder="Fonction"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Mot de passe <span class="red">*</span></label></div>
                                <div class="col-md-10"><input type="password" name="password" value="" class="form-control" placeholder="Mot de passe"></div>
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
                    Valider la configuration
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
