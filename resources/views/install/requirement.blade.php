@extends('install.layout')
@section('content')
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-exclamation-sign"></i> Exigences minimale</h3>
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
                    @foreach($checks as $key => $check)
                        <li class="list-group-item">
                            <span class="badge badge-{{ $check ? 'success' : 'danger' }}">
                                <i class="glyphicon glyphicon-ok"></i>
                            </span>
                            {{ $check }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @if ($success)
                <a class="btn btn-success" href="{{ route('install.database') }}"> Configurer la base de données</a>
            @endif
        </div>
    </div>
@endsection
