@extends('template.index')

@push('styles')
<style>
    .table-employee-content { 
        /** Equivalent to pt-3 */
        padding-top:1rem!important;
    }

    #thead-actions {
        /** Fixed width, increase if adding addt. buttons **/
        width:120px;
    }

    #account-header-grid {
        display:grid;
        gap:16px;
        grid-template-columns:128px auto;
        margin-bottom:24px;
    }

    #account-picture-128 {
        width:128px;
        border-radius:100%;
    }

    #account-name-header {
        margin-top:16px;
        margin-bottom:0px;
        font-size:36px;
    }

    .account-h2 {
        font-size:20px;
        font-weight: 700;
    }

    .card-content-grid-header-2 {
        display:grid;
        gap:16px;
        grid-template-columns:auto 128px;
    }

    .card-content-grid-header-3 {
        display:grid;
        gap:16px;
        grid-template-columns:144px auto 128px;
        grid-template-areas:
            "header content btn";
    }

    .card-content-header {
        grid-area: header;
    }

    .card-content-value {
        grid-area: content;
    }

    .card-content-btn {
        grid-area: btn;
    }

    @media (max-width:991px) {
        #account-header-grid {
            grid-template-columns:auto;
        }

        #account-picture-128 {
            margin:0 auto;
            display:block;
        }

        #account-name-header {
            margin-top:0px;
            text-align:center;
        }

        #account-edit-photo-btn {
            display:block;
            margin:0 auto;
        }

        .card-content-grid-header-3 {
            display:grid;
            gap:16px;
            grid-template-columns:auto 128px;
            grid-template-areas:
                "header btn"
                "content content";
        }
    }
</style>

<script src="https://unpkg.com/@yaireo/tagify"></script>
<script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />

@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> 
@endpush

@section('content')

{{-- Alert Success --}}
<div id="alert-success" class="alert alert-success" style="display:none">
    <span id="alert-success-content" class="m-0"></span>
    <button type="button" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

{{-- Tab Navigation --}}
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="account-tab" href="/account/" role="tab"
            aria-controls="account" aria-selected="true">Your Account</a>
    </li>
    {{-- <li class="nav-item" role="presentation">
        <a class="nav-link" id="proforma-tab" data-toggle="tab" href="#proforma" role="tab"
            aria-controls="proforma" aria-selected="false">Proforma</a>
    </li> --}}
</ul>

{{-- Content --}}
<div class="card" class="content-card">
    <div class="card-body">
        @if(Route::currentRouteName() == 'account.yourAccount')
            @include('account.content.yourAccount')
        @endif
    </div>
</div>

<script src="js/account/update_info.js"></script>

@endsection