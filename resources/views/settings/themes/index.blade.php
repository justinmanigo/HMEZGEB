@extends('template.index')

@push('styles')
<style>

    .container_theme{
    height: 50px;
    width: 100px;
    display: flex;
    }

    .left{
    border-top-left-radius: 9999px ;
    border-bottom-left-radius: 9999px ;
    background-color: aqua;
    height: 100%;
    width: 25%;

    }

    .right{
    border-top-right-radius: 9999px ;
    border-bottom-right-radius: 9999px ;
    background-color: rgb(17, 155, 155);
    height: 100%;
    width: 25%;
    }

</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
@endpush

@section('content')
<div class="d-sm-flex align-items-start justify-content-between mb-2">
    <h1>Themes</h1>
</div>
<div class="row">

    <div class="col-auto">
        <div class="card my-3">
            <a href="#" class="btn btn-light btn-icon-split">
                <span class="icon text-gray-600">
                    <i class="fas fa-image"></i>
                </span>
                <span class="text pl-5">Background</span>
            </a>
        </div>
        <div class="card">
            <a href="#" class="btn btn-light btn-icon-split">
                <span class="icon text-gray-600">
                    <i class="fas fa-arrow-right"></i>
                </span>
                <span class="text">Color and Theme</span>
            </a>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header ">
                <h6 >Customized this page</h6>
            </div>
            <div class="card-body ">
                <div class="d-flex flex-row">
                    <div class="">
                        <div class="container_theme rounded-circle">
                            <div class="left"></div>
                            <div class="right"></div>
                        </div>
                    </div>
                    <div class="">
                        <div class="container_theme rounded-circle">
                            <div class="left"></div>
                            <div class="right"></div>
                        </div>
                    </div>
                    <div class="">
                        <div class="container_theme rounded-circle">
                            <div class="left"></div>
                            <div class="right"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
