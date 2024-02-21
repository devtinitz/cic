<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags  -->
    <meta charset="utf-8" />
    <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />

    <title>{{$title ?? ''}} {{$setting->companyname ?? 'Tableau de bord'}}</title>
    <link rel="icon" type="image/png" href="/img/logo.png" />

    <!--Core CSS -->
    <link rel="stylesheet" href="{{asset('/css/app.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/main.css')}}" />
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">--}}
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/css/selectize.min.css">--}}
{{--    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />--}}
{{--    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bulma.min.css">--}}
{{--    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.bulma.min.css">--}}
{{--    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">--}}

    <link rel="stylesheet" href="{{asset('/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('/css/selectize.min.css')}}">
    <link href="{{asset('/css/select2.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('/css/dataTables.bulma.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/buttons.bulma.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/font-awesome.min.css')}}">

    <link rel="stylesheet" href="{{asset('/css/modified.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/datatable.css')}}" />

    <!-- Fonts -->
    <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800;900&display=swap"
            rel="stylesheet"
    />
    <link
            href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700"
            rel="stylesheet"
    />

    @stack('css')

    <!--Mapbox styles-->
</head>
<body>
<div id="huro-app" class="app-wrapper">
    <div class="app-overlay"></div>

    <!--Full pageloader-->
    <!-- Pageloader -->
    <div class="pageloader is-full"></div>
    <div class="infraloader is-full is-active"></div>
    <!--Mobile navbar-->
    <nav class="navbar mobile-navbar no-shadow is-hidden-desktop is-hidden-tablet" aria-label="main navigation">
        <div class="container">
            <!-- Brand -->
            <div class="navbar-brand">
                <!-- Mobile menu toggler icon -->
                <div class="brand-start">
                    <div class="navbar-burger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>

                <a class="navbar-item is-brand" href="index.html">
                    <img class="light-image" src="{{asset('/img/logos/logo.png')}}" alt="">
                </a>

                <div class="brand-end">
                    <div class="navbar-item has-dropdown is-notification is-hidden-tablet is-hidden-desktop">
                        <a class="navbar-link is-arrowless" href="javascript:void(0);">
                            <i data-feather="bell"></i>
                            <span class="new-indicator pulsate"></span>
                        </a>
                        <div class="navbar-dropdown is-boxed is-right">
                            <div class="heading">
                                <div class="heading-left">
                                    <h6 class="heading-title">Notifications</h6>
                                </div>
                                <div class="heading-right">
                                    <a class="notification-link" href="#">See all</a>
                                </div>
                            </div>
                            <div class="inner has-slimscroll">

                                <ul class="notification-list">
                                    <li>
                                        <a class="notification-item">
                                            <div class="img-left">
                                                <img class="user-photo" alt="" src="https://via.placeholder.com/150x150"
                                                     data-demo-src="{{asset('img/avatars/photos/7.jpg')}}" />
                                            </div>
                                            <div class="user-content">
                                                <p class="user-info"><span class="name">Alice C.</span> left a comment.</p>
                                                <p class="time">1 hour ago</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="notification-item">
                                            <div class="img-left">
                                                <img class="user-photo" alt="" src="https://via.placeholder.com/150x150"
                                                     data-demo-src="{{asset('img/avatars/photos/12.jpg')}}" />
                                            </div>
                                            <div class="user-content">
                                                <p class="user-info"><span class="name">Joshua S.</span> uploaded a file.</p>
                                                <p class="time">2 hours ago</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="notification-item">
                                            <div class="img-left">
                                                <img class="user-photo" alt="" src="https://via.placeholder.com/150x150"
                                                     data-demo-src="{{asset('img/avatars/photos/13.jpg')}}" />
                                            </div>
                                            <div class="user-content">
                                                <p class="user-info"><span class="name">Tara S.</span> sent you a message.</p>
                                                <p class="time">2 hours ago</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="notification-item">
                                            <div class="img-left">
                                                <img class="user-photo" alt="" src="https://via.placeholder.com/150x150"
                                                     data-demo-src="{{asset('img/avatars/photos/25.jpg')}}" />
                                            </div>
                                            <div class="user-content">
                                                <p class="user-info"><span class="name">Melany W.</span> left a comment.</p>
                                                <p class="time">3 hours ago</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown is-right is-spaced dropdown-trigger user-dropdown">
                        <div class="is-trigger" aria-haspopup="true">
                            <div class="profile-avatar">
                                <img class="avatar" src="https://via.placeholder.com/150x150"
                                     data-demo-src="{{asset('img/avatars/photos/8.jpg')}}" alt="">
                            </div>
                        </div>
                        <div class="dropdown-menu" role="menu">
                            <div class="dropdown-content">
                                <div class="dropdown-head">
                                    <div class="h-avatar is-large">
                                        <img class="avatar" src="https://via.placeholder.com/150x150"
                                             data-demo-src="{{asset('img/avatars/photos/8.jpg')}}" alt="">
                                    </div>
                                    <div class="meta">
                                        <span>Erik Kovalsky</span>
                                        <span>Product Manager</span>
                                    </div>
                                </div>
                                <a href="#" class="dropdown-item is-media">
                                    <div class="icon">
                                        <i class="lnil lnil-user-alt"></i>
                                    </div>
                                    <div class="meta">
                                        <span>Profile</span>
                                        <span>View your profile</span>
                                    </div>
                                </a>
                                <a class="dropdown-item is-media layout-switcher">
                                    <div class="icon">
                                        <i class="lnil lnil-layout"></i>
                                    </div>
                                    <div class="meta">
                                        <span>Layout</span>
                                        <span>Switch to admin/webapp</span>
                                    </div>
                                </a>
                                <hr class="dropdown-divider">
                                <a href="#" class="dropdown-item is-media">
                                    <div class="icon">
                                        <i class="lnil lnil-briefcase"></i>
                                    </div>
                                    <div class="meta">
                                        <span>Projects</span>
                                        <span>All my projects</span>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item is-media">
                                    <div class="icon">
                                        <i class="lnil lnil-users-alt"></i>
                                    </div>
                                    <div class="meta">
                                        <span>Team</span>
                                        <span>Manage your team</span>
                                    </div>
                                </a>
                                <hr class="dropdown-divider">
                                <a href="#" class="dropdown-item is-media">
                                    <div class="icon">
                                        <i class="lnil lnil-cog"></i>
                                    </div>
                                    <div class="meta">
                                        <span>Settings</span>
                                        <span>Account settings</span>
                                    </div>
                                </a>
                                <hr class="dropdown-divider">
                                <div class="dropdown-item is-button">
                                    <button class="button h-button is-primary is-raised is-fullwidth logout-button">
                                          <span class="icon is-small">
                                              <i data-feather="log-out"></i>
                                          </span>
                                        <span>Logout</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </nav>
    <!--Mobile sidebar-->
    <div class="mobile-main-sidebar">
        <div class="inner">
            <ul class="icon-side-menu">
                <li>
                    <a href="/admin-dashboards-personal-1.html" id="home-sidebar-menu-mobile">
                        <i data-feather="activity"></i>
                    </a>
                </li>
                <li>
                    <a href="/admin-grid-users-1.html" id="layouts-sidebar-menu-mobile">
                        <i data-feather="grid"></i>
                    </a>
                </li>
                <li>
                    <a href="/elements-hub.html" id="elements-sidebar-menu-mobile">
                        <i data-feather="box"></i>
                    </a>
                </li>
                <li>
                    <a href="javascript:" id="components-sidebar-menu-mobile">
                        <i data-feather="cpu"></i>
                    </a>
                </li>
                <li>
                    <a href="javascript:" id="open-messages-mobile">
                        <i data-feather="message-circle"></i>
                    </a>
                </li>
            </ul>

            <ul class="bottom-icon-side-menu">
                <li>
                    <a href="javascript:" class="right-panel-trigger" data-panel="search-panel">
                        <i data-feather="search"></i>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i data-feather="settings"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    @include('parts.menutop')
    <!--Sous menu -->

<!-- Content Wrapper -->
    <div id="app-onboarding" class="view-wrapper is-webapp" data-page-title="Action Page" data-naver-offset="214" data-menu-item="#layouts-navbar-menu" data-mobile-item="#home-sidebar-menu-mobile">
        <div class="page-content-wrapper">
            <div class="page-content is-relative">
                <div class="page-title has-text-centered is-webapp">
                    <div class="toolbar ml-auto">
                        <div class="toolbar-notifications is-hidden-mobile">
                            <div class="dropdown is-spaced is-dots is-right dropdown-trigger">
                                <div class="is-trigger" aria-haspopup="true" >
                                    <i data-feather="bell"></i>
                                    <span class="new-indicator pulsate"></span>
                                </div>
                                <div class="dropdown-menu" role="menu">
                                    <div class="dropdown-content">
                                        <div class="heading">
                                            <div class="heading-left">
                                                <h6 class="heading-title">Notifications</h6>
                                            </div>
                                            <div class="heading-right">
                                                <a class="notification-link" href="/admin-profile-notifications.html">See all</a>
                                            </div>
                                        </div>
                                        <ul class="notification-list">
                                            <li>
                                                <a class="notification-item">
                                                    <div class="img-left">
                                                        <img class="user-photo" alt="" src="https://via.placeholder.com/150x150"
                                                             data-demo-src="{{asset('img/avatars/photos/7.jpg')}}" />
                                                    </div>
                                                    <div class="user-content">
                                                        <p class="user-info"><span class="name">Alice C.</span> left a comment.</p>
                                                        <p class="time">1 hour ago</p>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="notification-item">
                                                    <div class="img-left">
                                                        <img class="user-photo" alt="" src="https://via.placeholder.com/150x150"
                                                             data-demo-src="{{asset('img/avatars/photos/7.jpg')}}" />
                                                    </div>
                                                    <div class="user-content">
                                                        <p class="user-info"><span class="name">Joshua S.</span> uploaded a file.</p>
                                                        <p class="time">2 hours ago</p>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="notification-item">
                                                    <div class="img-left">
                                                        <img class="user-photo" alt="" src="https://via.placeholder.com/150x150"
                                                             data-demo-src="{{asset('img/avatars/photos/7.jpg')}}" />
                                                    </div>
                                                    <div class="user-content">
                                                        <p class="user-info"><span class="name">Tara S.</span> sent you a message.</p>
                                                        <p class="time">2 hours ago</p>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="notification-item">
                                                    <div class="img-left">
                                                        <img class="user-photo" alt="" src="https://via.placeholder.com/150x150"
                                                             data-demo-src="{{asset('img/avatars/photos/7.jpg')}}" />
                                                    </div>
                                                    <div class="user-content">
                                                        <p class="user-info"><span class="name">Melany W.</span> left a comment.</p>
                                                        <p class="time">3 hours ago</p>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
