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

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="{{URL::asset('vendor/fontawesome-free/css/all.min.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="{{URL::asset('css/sb-admin-2.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/custom-template.css')}}">
      <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
        .crop-logo-container {
            width: 56px;
            height: 41px;
            overflow: hidden;
        }

        .crop-text-container {
            margin-top:8px;
            width: 140px;
            height: 32px;
            overflow: hidden;
        }

        .crop-logo-container img {
            margin: 0px 0px 0px -8px;
            width:auto;
            height:56px!important
        }

        .crop-text-container img {
            margin: -70px 0px 0px 0px;
            width:auto;
            height:96px!important
        }
    </style>

    @stack('styles')

</head>

<body id="page-top">

 <!-- Page Wrapper -->
    <div id="wrapper">
