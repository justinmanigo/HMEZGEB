<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>HMEZGEB</title>

    <!-- Scripts needed to be pre-loaded -->
    @if (App::environment(['local']))
        <script src="{{URL::asset('vendor/jquery/jquery.min.js')}}"></script>
        <script src="{{URL::asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
        <script src="{{URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{URL::asset('vendor/popper/popper.min.js')}}"></script>
        <script src="{{URL::asset('vendor/tagify/tagify.min.js')}}"></script>
        <script src="{{URL::asset('vendor/tagify/tagify.polyfills.min.js')}}"></script>
        <script src="{{URL::asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{URL::asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{URL::asset('vendor/moment/moment.min.js')}}"></script>
        <script src="{{URL::asset('vendor/daterangepicker/daterangepicker.min.js')}}"></script>
    @else
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://unpkg.com/@yaireo/tagify@4.17.6/dist/tagify.min.js"></script>
        <script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    @endif

    <script type="text/javascript" src="{{ URL::asset('js/hoverable.js') }}"></script>

    <!-- Custom fonts for this template-->
    @if (App::environment(['local']))
        <link rel="stylesheet" href="{{URL::asset('vendor/fontawesome-free/css/all.min.css')}}">
        <link rel="stylesheet" href="{{URL::asset('vendor/daterangepicker/daterangepicker.css')}}">
        <link rel="stylesheet" href="{{URL::asset('vendor/tagify/tagify.css')}}">
        <link rel="stylesheet" href="{{URL::asset('css/sb-admin-2.min.css')}}">
    @else
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"  integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
        <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/css/sb-admin-2.min.css" rel="stylesheet" />
    @endif

    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="{{URL::asset('css/custom-template.css')}}">
    <link rel="stylesheet" href="{{URL::asset('/css/tagify-template.css')}}">

    @stack('styles')

</head>

<body id="page-top">

 <!-- Page Wrapper -->
    <div id="wrapper">
