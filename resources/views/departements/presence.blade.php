@extends('template')
@section('content')
    <div class="page-content-inner">
        <div class="profile-wrapper">
            <!--Breadcrumb-->
        @include('layouts.breadcrumb')
        <!--Edit Profile-->
            <div class="account-wrapper">
                <div class="columns">
                    <div class="column is-3">
                        @include('departements.menugauche')
                    </div>
                    <div class="column is-9">
                        @include('layouts.flashmessage')
                        <div class="account-box is-form">
                            <div class="form-head">
                                <div class="form-head-inner">
                                    <div class="left">
                                        <h3>{{$section_title}}</h3>
                                        <p><i class="lnil lnil-warning"></i> Cette section est réservée pour afficher le récapitulatif de présence d'un département.</p>
                                    </div>
                                    <div class="right">
                                        <div class="buttons">
                                            @include('parts.precedent')
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-body">
                                <div class="s-card demo-table column.is-half">
                                    @include('parts.graph')
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Navigation-->
                </div>

                @endsection