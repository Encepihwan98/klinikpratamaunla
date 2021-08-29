@include('inc.function')
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('titlle')</title>

    <link href="{{url('assets/css/loader.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{url('assets/js/loader.js')}}"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="{{url('plugins/font-icons/fontawesome/css/fontawesome.min.css')}}">
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{url('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/css/components/custom-modal.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('plugins/animate/animate.css')}}" rel="stylesheet" type="text/css" />
    
    @yield('style')
</head>
<body>
    
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->
    
    @include('inc.navbar')
    
    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>
        
        @include('inc.sidebar')

        <!--  BEGIN CONTENT PART  -->
        <div id="content" class="main-content">

            @yield('content')

        </div>
        <!--  END CONTENT PART  -->

    </div>
    <!-- END MAIN CONTAINER -->
    <script src="{{url('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
    <script src="{{url('bootstrap/js/popper.min.js')}}"></script>
    <script src="{{url('bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{url('plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{url('assets/js/app.js')}}"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="{{url('assets/js/custom.js')}}"></script>
    <script src="{{url('plugins/highlight/highlight.pack.js')}}"></script>
    @yield('script')

</body>
</html>
