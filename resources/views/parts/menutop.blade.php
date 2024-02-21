

<style>

    .menuInerTitle{
        font-size: 12px !important;
    }
    .topMenuIco{
        font-size: 20px !important;
        color: #fff !important;
    }

    .ico40{
        font-size: 40px !important;
    }

    .centered-link span{
        font-size: 12px !important;
    }

    .webapp-navbar
    .webapp-navbar-inner
    .center
    .centered-links
    .centered-link:hover i{
        color: #041f4a !important;
    }

</style>
    <!--Webapp navbar regular-->
    <div class="webapp-navbar" style="background: {{$setting->companycolor}} !important;">
        <div class="webapp-navbar-inner">
            <div class="left">
                <a href="{{route('dashboard')}}" class="brand">
                    <img class="light-image" src="{{ asset('img/logo.png') }}" alt="Logo : {{$setting->companyname}}" />
                </a>
                <div class="separator"></div>
                <div class="dropdown project-dropdown dropdown-trigger is-spaced">
                    <span class="status-indicator"></span>
                </div>
                <h1 id="" class="title is-5">{{ucfirst($section_title ?? '')}}</h1>
            </div>
            <!--Libelle Menu centre-->
            <div class="center">
                <div id="webapp-navbar-menu" class="centered-links">
                    <!--
                        <a id="dashboards-navbar-menu" class="centered-link centered-link-toggle active" data-menu-id="dashboards-webapp-menu">
                            <i data-feather="activity"></i>
                            <span>Parametrage</span>
                        </a>
                    -->

                    <a id="layouts-navbar-menu" class="centered-link centered-link-toggle" data-menu-id="layouts-webapp-menu">
                        <!--<i data-feather="cog"></i>-->
                        <i class="lnil lnil-cog topMenuIco"></i>
                        <span style="margin-top: 4px;">Paramétrage</span>
                    </a>
                    <a id="components-navbar-menu" class="centered-link centered-link-toggle" data-menu-id="components-webapp-menu">
                        <i data-feather="cpu"></i>
                        <span>Modules</span>
                    </a>
{{--                    <a href="#" class="centered-link">--}}
{{--                        <i data-feather="message-circle"></i>--}}
{{--                        <span>Message</span>--}}
{{--                    </a>--}}
{{--                    <a class="centered-link centered-link-search">--}}
{{--                        <i data-feather="search"></i>--}}
{{--                        <span>Rechercher</span>--}}
{{--                    </a>--}}
                </div>
                <div id="webapp-navbar-search" class="centered-search is-hidden">
                    <form method="get" action="#">
                        <div class="columns is-multiline">
                            <div class="column is-8">
                                <div class="field">
                                    <div class="control has-icon">
                                        <input type="text" class="input is-rounded search-input" name="search" placeholder="Rechercher...">
                                        <div class="form-icon">
                                            <i data-feather="search"></i>
                                        </div>
                                        <div id="webapp-navbar-search-close" class="form-icon is-right">
                                            <i data-feather="x"></i>
                                        </div>
                                        <!--<div class="search-results has-slimscroll"></div>-->
                                    </div>
                                </div>
                            </div>
                            <div class="column is-4">
                                <div class="field">
                                    <button id="save-button" type="submit" class="button h-button is-primary is-raised" style="background-color: #fff; color : {{$setting->companycolor}} !important;">Valider</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--Menu de droite-->
            <div class="right">
                @include('parts.notification')
                @include('parts.sidebaruser')

            </div>
        </div>
    </div>
{{--    @include('layouts.flashmessage')--}}
	<div class="webapp-subnavbar">

        <div id="layouts-webapp-menu" class="webapp-subnavbar-inner tabs-wrapper ">
            <div class="tabs-inner">
                <div class="tabs is-centered is-4">
                    <ul>
                        <li data-tab="list-pages-tab" class="is-active"><a class="menuInerTitle">Paramètres généraux</a></li>
                    </ul>
                </div>
            </div>

            <div class="container">
                <div id="list-pages-tab" class="tab-content is-active">
                    <div class="tab-content-inner" style="">
                        <div class="center has-slimscroll">
                            <div class="columns">
                                <div class="column is-6">
                                    <a href="{{route('users.index')}}" class="column-placeholder">
                                        <i class="lnil lnil-users ico40"></i>
                                        <h3>Utilisateur</h3>
                                    </a>
                                    <a href="{{route('espaces.index')}}" class="column-placeholder">
                                        <i class="lnil lnil-layout-alt-2 ico40"></i>
                                        <h3>Espace utilisateur</h3>
                                    </a>
                                </div>

                                <div class="column is-6">
                                    <a href="{{route('settings')}}" class="column-placeholder">
                                        <i class="lnil lnil-laptop ico40"></i>
                                        <h3>Système</h3>
                                    </a>
                                    <a href="{{route('logs')}}" class="column-placeholder">
                                        <i class="lnil lnil-database ico40"></i>
                                        <h3>Historique d'activité</h3>
                                    </a>
                                </div>
{{--                                <div class="column is-4">--}}
{{--                                    <a href="#" class="column-placeholder">--}}
{{--                                        <i class="lnil lnil-alarm-clock ico40"></i>--}}
{{--                                        <h3>Horaires</h3>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--src/partials/navbar/webapp/menus/-->
        <div id="components-webapp-menu" class="webapp-subnavbar-inner tabs-wrapper">
            <div class="tabs-inner">
                <div class="tabs is-centered is-2">
                    <ul>
                        <li data-tab="components-basic-pages-tab" class="is-active"><a class="menuInerTitle">Configuration de modules</a></li>
                    </ul>
                </div>
            </div>


            <div class="container">
                <div id="components-basic-pages-tab" class="tab-content is-active">
                    <div class="tab-content-inner">
                        <div class="center has-slimscroll">
                            <div class="columns">
                                <div class="column is-4">
                                    <a href="{{ route('sieges.index') }}" class="column-placeholder">
                                        <i class="lnil lnil-apartment ico40"></i>
                                        <h3>Sièges</h3>
                                    </a>
                                    <a href="{{ route('agences.index') }}" class="column-placeholder">
                                        <i class="lnil lnil-apartment-alt ico40"></i>
                                        <h3>Agences</h3>
                                    </a>
                                </div>

                                <div class="column is-4">
                                    <a href="{{ route('departements.index') }}" class="column-placeholder">
                                        <i class="lnil lnil-thumbnail ico40"></i>
                                        <h3>Départements</h3>
                                    </a>
                                    <a href="{{ route('employes.index') }}" class="column-placeholder">
                                        <i class="lnil lnil-users ico40"></i>
                                        <h3>Employés</h3>
                                    </a>
                                </div>

                                <div class="column is-4">
                                    <a href="{{ route('presences.index') }}" class="column-placeholder">
                                        <i class="lnil lnil-calender-alt ico40"></i>
                                        <h3>Présences</h3>
                                    </a>
                                    <a href="{{ route('permissions.index') }}" class="column-placeholder">
                                        <i class="lnil lnil-briefcase-alt ico40"></i>
                                        <h3>Permissions</h3>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Page body-->
    <div class="mobile-subsidebar">
        <div class="inner">
            <div class="sidebar-title">
                <h3>Paramètres</h3>
            </div>
            <ul class="submenu">
                <li class="has-children">
                    <div class="collapse-wrap">
                        <a href="javascript:void(0);" class="parent-link">Général <i data-feather="chevron-right"></i></a>
                    </div>
                    <ul>
                        <li>
                            <a class="is-submenu" href="{{route('espaces.index')}}">
                                <i class="lnil lnil-list-alt"></i>
                                <span>Espaces utilisateurs</span>
                            </a>
                        </li>
                        <li>
                            <a class="is-submenu" href="{{route('users.index')}}">
                                <i class="lnil lnil-list-alt"></i>
                                <span>Utilisateur</span>
                            </a>
                        </li>
                        <li>
                            <a class="is-submenu" href="{{route('settings')}}">
                                <i class="lnil lnil-list-alt"></i>
                                <span>Systeme</span>
                            </a>
                        </li>
                        <li>
                            <a class="is-submenu" href="#">
                                <i class="lnil lnil-list-alt"></i>
                                <span>Type TC</span>
                            </a>
                        </li>
                        <li>
                            <a class="is-submenu" href="#">
                                <i class="lnil lnil-list-alt"></i>
                                <span>Compte</span>
                            </a>
                        </li>
                        <li>
                            <a class="is-submenu" href="#">
                                <i class="lnil lnil-list-alt"></i>
                                <span>Activité</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="has-children">
                    <div class="collapse-wrap">
                        <a href="javascript:void(0);" class="parent-link">Modules <i data-feather="chevron-right"></i></a>
                    </div>
                    <ul>
                        <li>
                            <a class="is-submenu" href="#">
                                <i class="lnil lnil-list-alt"></i>
                                <span>Agents</span>
                            </a>
                        </li>
                        <li>
                            <a class="is-submenu" href="#">
                                <i class="lnil lnil-list-alt"></i>
                                <span>Armateurs</span>
                            </a>
                        </li>
                        <li>
                            <a class="is-submenu" href="#">
                                <i class="lnil lnil-list-alt"></i>
                                <span>Navires</span>
                            </a>
                        </li>
                        <li>
                            <a class="is-submenu" href="#">
                                <i class="lnil lnil-list-alt"></i>
                                <span>Documents</span>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </div>
    </div>



