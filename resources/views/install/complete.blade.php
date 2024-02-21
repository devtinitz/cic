@extends('install.layout')
@section('content')
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-exclamation-sign"></i> Installation terminée</h3>
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
            <div class="bs-component">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="badge badge-success">
                            <i class="glyphicon glyphicon-ok"></i>
                        </span>
                        L'installation s'est bien passée. Merci d'avoir choisi Tinitz :).
                    </li>
                </ul>
            </div>
            <a class="btn btn-success" href="{{ route('login') }}"> Se connecter</a>
        </div>
    </div>
@endsection
