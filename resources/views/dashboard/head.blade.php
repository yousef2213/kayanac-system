<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link rel="shortcut icon" href="{{ asset('1.png') }}" type="image/x-icon">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kayanac - كيانك المحاسبي</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">


    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>

    {{-- style.css --}}

    {{-- <link rel="stylesheet" href="{{ asset('docsupport/style.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('docsupport/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('chosen.css') }}">

    <!-- Custom styles for this template-->
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('js/bootstrap-datepicker.js') }}">

    <link rel="stylesheet" href="{{ asset('boot5/bootstrap.min.css') }}">


    @stack('styles')

</head>
