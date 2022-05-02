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
        margin:0;
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

@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session()->get('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if(session()->has('danger'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session()->get('danger') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

@endif

{{-- Tab Navigation --}}
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="account-tab" data-toggle="tab" href="#account" role="tab"
            aria-controls="account" aria-selected="true">Account</a>
    </li>
    {{-- <li class="nav-item" role="presentation">
        <a class="nav-link" id="proforma-tab" data-toggle="tab" href="#proforma" role="tab"
            aria-controls="proforma" aria-selected="false">Proforma</a>
    </li> --}}
</ul>

{{-- Tab Contents --}}
<div class="card" class="content-card">
    <div class="card-body tab-content" id="myTabContent">
        {{-- Tab 1 - Account --}}
        <div class="tab-pane fade show active p-3" id="account" role="tabpanel"
            aria-labelledby="account-tab">
            
            @include('account.tabs.account')

        </div>
        {{-- Tab 2 --}}
        {{-- <div class="tab-pane fade" id="proforma" role="tabpanel" aria-labelledby="proforma-tab">
            
        </div> --}}
    </div>
</div>

@endsection