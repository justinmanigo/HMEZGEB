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
      .dropdown-menu-quick-new {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000000!important;
        display: none;
        float: left;
        min-width: 40rem!important;
        padding: 1rem 0;
        margin: 0.125rem 0.125rem 0 0!important;
        font-size: 0.85rem;
        color: #858796;
        text-align: left;
        list-style: none;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #e3e6f0;
        border-radius: 0.35rem;
      }
    </style>

<style>
  .table-item-content {
      /** Equivalent to pt-3 */
      padding-top: 1rem !important;
  }

  .thead-actions {
      /** Fixed width, increase if adding addt. buttons **/
      width: 120px;
  }

  .content-card {
      border-radius: 0px 0px 5px 5px;
  }

  .inputPrice::-webkit-inner-spin-button,
  .inputTax::-webkit-inner-spin-button,
  .inputPrice::-webkit-outer-spin-button,
  .inputTax::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
  }

  input[type="checkbox"],
  label {
      cursor: pointer;
  }

  /*
          TEMPORARY
      */
  /* Suggestions items */
  .tagify__dropdown.customers-list .tagify__dropdown__item {
      padding: .5em .7em;
      display: grid;
      grid-template-columns: auto 1fr;
      gap: 0 1em;
      grid-template-areas: "avatar name"
          "avatar email";
  }

  .tagify__dropdown.customers-list .tagify__dropdown__item:hover .tagify__dropdown__item__avatar-wrap {
      transform: scale(1.2);
  }

  .tagify__dropdown.customers-list .tagify__dropdown__item__avatar-wrap {
      grid-area: avatar;
      width: 36px;
      height: 36px;
      border-radius: 50%;
      overflow: hidden;
      background: #EEE;
      transition: .1s ease-out;
  }

  .tagify__dropdown.customers-list img {
      width: 100%;
      vertical-align: top;
  }

  .tagify__dropdown.customers-list strong {
      grid-area: name;
      width: 100%;
      align-self: center;
  }

  .tagify__dropdown.customers-list span {
      grid-area: email;
      width: 100%;
      font-size: .9em;
      opacity: .6;
  }

  .tagify__dropdown.customers-list .addAll {
      border-bottom: 1px solid #DDD;
      gap: 0;
  }


  /* Tags items */
  .tagify__tag {
      white-space: nowrap;
  }

  .tagify__tag:hover .tagify__tag__avatar-wrap {
      transform: scale(1.6) translateX(-10%);
  }

  .tagify__tag .tagify__tag__avatar-wrap {
      width: 16px;
      height: 16px;
      white-space: normal;
      border-radius: 50%;
      background: silver;
      margin-right: 5px;
      transition: .12s ease-out;
  }

  .tagify__tag img {
      width: 100%;
      vertical-align: top;
      pointer-events: none;
  }
</style>

<script src="https://unpkg.com/@yaireo/tagify"></script>
<script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />

    @stack('styles')
    
</head>

<body id="page-top">

 <!-- Page Wrapper -->
    <div id="wrapper">