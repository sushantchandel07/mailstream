<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>

    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mailbox | Africahied</title>
    <style>
        .unread-email .subject b {
            font-weight: bold;
            color: #000;
        }

        .read-email .subject {
            font-weight: normal;
            color: #777;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@latest/fonts/remixicon.css">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.25.0-lts/standard/ckeditor.js"></script>
    <script src="{{asset('quickmail/js/mailbox.js')}}"></script>


    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.icon">
        
    <!-- Bootstrap Css -->
    <!-- Bootstrap Css -->
    <link href="{{asset('quickmail/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />  
    <link href="{{asset('quickmail/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('quickmail/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <!-- <link href="/assets/css/custom.min.css" rel="stylesheet" type="text/css" /> -->

  
</head>
<body>
<div id="layout-wrapper">


    @include('quickmail::partial.header')
    @include('quickmail::partial.sidebar')
    <div class="content">
    <div class="page-content">   
        @yield('content')
        </div>
    </div>
    @include('quickmail::partial.footer')

</div>
    <!-- JAVASCRIPT -->  
     <script>
   
     </script>
     <script src="{{ asset('quickmail/js/mailbox.js') }}"></script>

    <script src="{{asset('quickmail/js/mailbox.init.js')}}"></script>
    <script src="{{asset('quickmail/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('quickmail/js/simplebar.min.js')}}"></script>
    <script src="{{asset('quickmail/js/waves.min.js')}}"></script>
    <script src="{{asset('quickmail/js/feather.min.js')}}"></script>
    <script src="{{asset('quickmail/js/lord-icon-2.1.0.js')}}"></script>
    <script src="{{asset('quickmail/js/plugins.js')}}"></script>
   
    <!-- App js -->
    <script src="{{ asset('quickmail/js/app.js') }}"></script>
</body>
</html>
 