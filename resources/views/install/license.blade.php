@extends('install.layout')
@section('content')
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-folder-close"></i>
                Vérification et activation de la licence
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
            <form action="{{ route('install.license.validate') }}" method="post">
                @csrf
                <div class="panel-group" style="margin-bottom : 0px">
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="col-md-2"><label>Clé de licence <span class="red">*</span></label></div>
                                <div class="col-md-10"><input type="text" name="licence_key" value="{{ old('licence_key') }}" class="form-control" placeholder="XX-XXXX-XXXX-XXXX-XX"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 text-center partial" style="margin-bottom : 0px !important;  display : none">
                                @include('install.partial')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-success" type="submit">
                            Activer la licence
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
            $('form').submit(function () {
                $('.partial').css('display','block');
            });
        });
    </script>
@endpush
