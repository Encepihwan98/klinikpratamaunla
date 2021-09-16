<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('titlle')</title>
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link rel="stylesheet" href="{{url('plugins/font-icons/fontawesome/css/fontawesome.min.css')}}">
        <!-- Styles -->
        {{-- <link href="{{url('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/css/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{url('plugins/animate/animate.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/css/authentication/form-2.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="{{ url('assets/css/forms/theme-checkbox-radio.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('assets/css/forms/switches.css') }}"> --}}
        <link href="{{url('css/app.css')}}" rel="stylesheet" type="text/css" />
        <style>
            .colored-toast.swal2-icon-success {
            background-color: #a5dc86 !important;
            }

            .colored-toast.swal2-icon-error {
            background-color: #f27474 !important;
            }

            .colored-toast.swal2-icon-warning {
            background-color: #f8bb86 !important;
            }

            .colored-toast.swal2-icon-info {
            background-color: #3fc3ee !important;
            }

            .colored-toast.swal2-icon-question {
            background-color: #87adbd !important;
            }

            .colored-toast .swal2-title {
            color: white;
            }

            .colored-toast .swal2-close {
            color: white;
            }

            .colored-toast .swal2-html-container {
            color: white;
            }

            .swal2-popup {
            font-size: 12px!important;
            }
        </style>
        @yield('style')
    </head>
    <body>
        <div id="app"></div>
        <script src="{{mix('js/app.js')}}"></script>
        {{-- <script src="{{url('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
        <script src="{{url('bootstrap/js/popper.min.js')}}"></script>
        <script src="{{url('bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{ url('plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ url('assets/js/app.js') }}"></script>
        <script>
            $(document).ready(function() {
                App.init();
            });
        </script>
        <script src="{{ url('assets/js/custom.js') }}"></script>
        <script src="{{ url('assets/js/authentication/form-2.js') }}"></script>
        <script src="{{ url('assets/js/dashboard/dash_2.js') }}"></script> --}}
        @yield('script')

    </body>
</html>
