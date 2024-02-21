@extends('install.layout')
@section('content')
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-folder-close"></i>
                Connexion à la base de données en ligne
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
            @if(session()->has('message'))
                <div class="row">
                    <div class="alert alert-error">
                        <ul class="alert {{session()->get('type')}}">
                            {{session()->get('message')}}
                        </ul>
                    </div>
                </div>
            @endif
            <form action="#" method="post">
                @csrf
                <div class="panel-group" style="margin-bottom : 0px !important;">
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Base de données<span class="red">*</span></label></div>
                                <div class="col-md-10"><input type="text" readonly name="connection" value="{{ old('connection', 'mysql') }}" class="form-control" placeholder="Connexion"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Hôte <span class="red">*</span></label></div>
                                <div class="col-md-10"><input type="text" name="host" value="{{ old('host', 'localhost') }}" class="form-control" placeholder="Hôte"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Port <span class="red">*</span></label></div>
                                <div class="col-md-10"><input type="text" name="port" value="{{ old('port', '3306') }}" class="form-control" placeholder="Port"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Base de données <span class="red">*</span></label></div>
                                <div class="col-md-10"><input type="text" name="database" value="{{ old('database') }}" class="form-control" placeholder="Base de données"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Nom d'utilisateur <span class="red">*</span></label></div>
                                <div class="col-md-10"><input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="Nom d&#39;utilisateur de la base de données"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Mot de passe</label></div>
                                <div class="col-md-10"><input type="text" name="password" value="{{ old('password') }}" class="form-control" placeholder="Mot de passe de la base de données"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 text-center partial" style="margin-bottom : 0px !important; display : none">
                                @include('install.partial')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-primary connexion_test" type="submit">
                            Test de connexion à la base de données
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-success validate_step" type="submit">
                            Passer à l'étape suivante
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function(){
            $('.validate_step').click(function () {
                $('form').attr('action', '{{ route('install.database.submit') }}');
                $('.partial').css('display','block');
            });
            $('.connexion_test').click(function () {
                $('form').attr('action', '{{ route('install.database.testconnexion') }}');
                $('.partial').css('display','block');
            });
        });
    </script>
@endpush
