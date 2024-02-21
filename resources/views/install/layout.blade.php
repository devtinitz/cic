<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paramétrage de l'application</title>

    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('/setup/css/bootstrap.min.css') }}">

    <!-- sweetalert -->
    <link rel="stylesheet" href="{{ asset('/setup/css/sweetalert.css') }}">

    <link rel="stylesheet" href="{{ asset('/setup/css/install.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/setup/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/setup/select2/css/select2.css') }}">
    <style>
        .red{color: red}
        .container{width: 920px !important;}
        .title{font-size: 40px !important;}
        .mb-4{margin-bottom: 20px}
        .blink{
            animation: blink 2s linear infinite;
            color : #E56D0C;
        }
        @keyframes blink{
            0%{opacity: 0;}
            50%{opacity: .5;}
            100%{opacity: 1;}
        }
    </style>
    @stack('css')

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('js/html5shiv.min.js') }}"></script>
    <script src="{{ asset('js/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body>

<div class="container">
    <div class="login-body">
        <h1 class="title">Paramétrage de l'application</h1>
        <h5 class="thanks">Les champs marqués par (<span class="red">*</span>) sont obligatoire.</h5>
{{--        <div class="clear"></div>--}}
        <article class="container-login center-block">
            <section>
                @yield('content')
            </section>
        </article>
    </div>
    <div class="text-center mb-4">
        <span>Copyright © Cote d'Ivoire Câbles - Tous droits réservés - Conçu par <a href="https://www.tinitz.com" target="_blank" class="">Tinitz</a></span>
    </div>
</div>

<!-- jQuery 2.1.4 -->
<script src="{{ asset('/setup/js/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ asset('/setup/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/setup/select2/js/select2.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.pays').select2();
    });
</script>
@stack('js')
</body>
</html>
