<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags  -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>{{$setting->companyname}}</title>
    <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}" />

    <!--Core CSS -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">

</head>
<body>
<div id="huro-app" class="app-wrapper">

    <!--Full pageloader-->
    <!-- Pageloader -->
    <div class="pageloader is-full"></div>
    <div class="infraloader is-full is-active"></div>
    <div class="auth-wrapper">
        <!--Page body-->

        <div class="auth-wrapper-inner is-single">

            <!--Fake navigation-->
            <div class="auth-nav">
                <div class="left"></div>
                <div class="center">
                    <div class="header-item">
                        <img class="light-image" src="{{$setting->companylogo}}" alt="gtci-logo" style="border-radius: 50%;">
                    </div>
                </div>
                <div class="right">
                    <label class="dark-mode ml-auto">
                        <input type="checkbox" checked>
                    </label>
                </div>
            </div>

            <!--Single Centered Form-->
            <div class="single-form-wrap">
                <div class="inner-wrap">
                    <!--Form Title-->
                    <!--Form-->
                    <div class="form-card">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            @include('layouts.flashmessage')
                            <div id="signin-form" class="login-form">
                                <!-- Input -->
                                <div class="field">
                                    <div class="control has-icon">
                                        <input class="input" type="text" placeholder="Identifiant" name="username" value="{{old('username')}}">
                                        <span class="form-icon">
                                            <i data-feather="user"></i>
                                        </span>
                                    </div>
                                </div>
                                <!-- Input -->
                                <div class="field">
                                    <div class="control has-icon">
                                        <input class="input" type="password" placeholder="Mot de passe" name="password">
                                        <span class="form-icon">
                                            <i data-feather="lock"></i>
                                        </span>
                                    </div>
                                </div>
                                <!-- Submit -->
                                <div class="control login">
                                    <button class="button h-button is-success is-bold is-fullwidth is-raised" style="background-color: {{ $setting->companycolor }} !important;">Se connecter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="forgot-link has-text-centered">
                        <p>{{ $setting->companyname }} - Tous droits réservés - Conçu par <a href="https://www.tinitz.com/" target="_blank">Tinitz</a></p>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!--Huro Scripts-->
    <!-- Concatenated plugins -->
    <script src="{{asset('/js/app.js')}}"></script>

    <!-- Huro js -->
    <script src="{{asset('/js/functions.js')}}"></script>
    <script src="{{asset('/js/auth.js')}}"></script>
    @stack('js')
</div>
</body>
</html>
