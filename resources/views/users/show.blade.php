@extends('template')
@push('css')
    <style>
        label{
            font-weight: bold;
        }
    </style>
@endpush
@section('content')
    <div class="page-content-inner">
        <div class="profile-wrapper">
            <!--Breadcrumb-->
        @include('layouts.breadcrumb')
        <!--Edit Profile-->
            <div class="account-wrapper">
                <div class="columns">
                    <!--Navigation-->
                    @include('users.menugauche')
                    <!--Form-->
                    <div class="column is-9">
                    @include('layouts.flashmessage')
                        <div class="account-box is-form is-footerless">
                            <div class="form-head">
                                <div class="form-head-inner">
                                    <div class="left">
                                        <h3>{{$section_title}}</h3>
                                        <p><i class="lnil lnil-warning"></i> Cette section est réservée pour les détails d'un client.</p>
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
                                <div class="fieldset" style="max-width: none !important;">
                                    <div class="columns is-multiline">
                                        <!--Field-->
                                        <div class="column is-3">
                                            <label for="identifiant">Username</label>
                                            <div class="field">
                                                <div class="control has-icon">
                                                    <p><b>{{$user->username ?? ''}}</b></p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Field-->
                                        <div class="column is-3">
                                            <label for="type">Nom et prénoms </label>
                                            <div class="field">
                                                <div class="control has-icon">
                                                    <p><b>{{ucfirst($user->name) ?? ''}} {{ucfirst($user->prenoms)  ?? ''}}</b></p>
                                                </div>
                                            </div>
                                        </div>
                                        
										<div class="column is-3">
                                            <label for="nom">Espace</label>
                                            <div class="field">
                                                <div class="control has-icon">
                                                    <p><b>{{$user->espace->nom  ?? ''}}</b></p>
                                                </div>
                                            </div>
                                        </div>
										
                                    </div>
                                </div>
                                <!--Fieldset-->
                                <div class="fieldset" style="max-width: none !important;">
                                    <div class="columns is-multiline">
                                        <!--Field-->
                                        <div class="column is-3">
                                            <label for="nom">Email</label>
                                            <div class="field">
                                                <div class="control has-icon">
                                                    <p><b>{{$user->email  ?? ''}}</b></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-3">
                                            <label for="pays">Contact</label>
                                            <div class="field">
                                                <div class="control has-icon">
                                                    <p><b>{{$user->telephone  ?? ''}}</b></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-3">
                                            <label for="email">Pays / Ville</label>
                                            <div class="field">
                                                <div class="control has-icon">
                                                    <p><b>{{$user->pays->name  ?? ''}} / {{$user->ville  ?? ''}}</b></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column is-3">
                                            <label for="contact">Adresse </label>
                                            <div class="field">
                                                <div class="control has-icon">
                                                    <p><b>{{$user->adresse  ?? ''}}</b></p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="column is-3">
                                            <label for="nom">Crée le </label>
                                            <div class="field">
                                                <div class="control has-icon">
                                                    <p><b>{{date('d/m/Y à H:i:s',strtotime($user->created_at))  ?? ''}} par {{$user->created_by  ?? ''}}</b></p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!--Fieldset-->
                            </div>
                        </div>
                    </div>

                </div>
                <div class="columns">
                    <div class="column is-12">
                        <div class="page-content-inner all-projects">
                            
      
                            <div class="columns">
                                <div class="column is-12">
                                    <div class="account-box is-form is-footerless">
                                        <div class="form-head">
                                            <div class="form-head-inner">
                                                <div class="left">
                                                    <h3>Liste des actions</h3>
                                                    <p><i class="lnil lnil-warning"></i> Cette section est réservée pour afficher la liste des actions effectués par cet utilisateur.</p>
                                                </div>                                            
                                            </div>
                                        </div>
                                        <div class="form-body">
                                    
                                            <div class="s-card demo-table column.is-half">
                                                <table  id="example" class="" style="width:100%">
                                                    <thead>
                                                        <tr class="table100-head">
                                                            <th>Date</th>
                                                            <th>Module </th>
                                                            <th>Action menée</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($logs as $l)
                                                            <tr>
                                                                <td>{{date('d/m/Y à H:i:s',strtotime($l->created_at))}} </td>                                                        
                                                                <td>{{ucfirst($l->module)}}</td>
                                                                <td>{{ucfirst($user->name)}} {{ucfirst($user->prenoms)}} {{ucfirst($l->action)}}</td>														
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="paging-first-datatable" class="pagination datatable-pagination">
                                                <div class="datatable-info">
                                                    <span></span>
                                                </div>
                                            </div>
                                            @include('paginations.default', ['paginator' => $logs ])
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
      
                        </div>
      
                    </div>
                </div>
            </div>
    @include('clients.create')
@endsection
