@extends('template')
@push('css')
    <style>
        .flashmessage{
            margin: 15px;
            font-size: 15px;
        }

        .blink{
            text-align: center;
        }
        .blink span{
            animation: blink 2s linear infinite;
        }
        @keyframes blink{
            0%{opacity: 0;}
            50%{opacity: .5;}
            100%{opacity: 1;}
        }
    </style>
@endpush
@section('content')
    <div class="page-content-inner">
        <!--Profile Settings-->
        <div class="profile-wrapper">
            <div class="profile-header has-text-centered">
                @include('parts.profilecompanyheader')
{{--                ok--}}
            </div>
            <!--End Total Demande de fond en attente-->

            @include('parts.graph')

            <div class="profile-body">
                @include('parts.profilecompanybody')
            </div>
        @endsection
        @push('thesescripts')

                <script>
                    $(document).ready(function(){
                        $(document).on('click', '.delete', function(){
                            console.log('ok');
                            $('.delete').parent('.notification').hide();
                        });
                    })
                </script>
    @endpush


