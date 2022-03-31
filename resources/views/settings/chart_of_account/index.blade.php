@extends('template.index')

@push('styles')
    <style>
        .table-item-content { 
        /** Equivalent to pt-3 */
        padding-top:1rem!important;
        }

        .thead-actions {
            /** Fixed width, increase if adding addt. buttons **/
            width:120px;
        }
        .content-card {
            border-radius:0px 0px 5px 5px;
        }

        .inputPrice::-webkit-inner-spin-button, .inputTax::-webkit-inner-spin-button,
        .inputPrice::-webkit-outer-spin-button, .inputTax::-webkit-outer-spin-button {
            -webkit-appearance: none; 
            margin: 0; 
        }

        input[type="checkbox"], label {
            cursor: pointer;
        }
        
        /*
            TEMPORARY
        */
        /* Suggestions items */
        .tagify__dropdown.customers-list .tagify__dropdown__item{
            padding: .5em .7em;
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 0 1em;
            grid-template-areas: "avatar name"
                                "avatar email";
        }
        .tagify__dropdown.customers-list .tagify__dropdown__item:hover .tagify__dropdown__item__avatar-wrap{
            transform: scale(1.2);
        }
        .tagify__dropdown.customers-list .tagify__dropdown__item__avatar-wrap{
            grid-area: avatar;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            overflow: hidden;
            background: #EEE;
            transition: .1s ease-out;
        }
        .tagify__dropdown.customers-list img{
            width: 100%;
            vertical-align: top;
        }
        .tagify__dropdown.customers-list strong{
            grid-area: name;
            width: 100%;
            align-self: center;
        }
        .tagify__dropdown.customers-list span{
            grid-area: email;
            width: 100%;
            font-size: .9em;
            opacity: .6;
        }
        .tagify__dropdown.customers-list .addAll{
            border-bottom: 1px solid #DDD;
            gap: 0;
        }
        /* Tags items */
         .tagify__tag{
            white-space: nowrap;
        }
         .tagify__tag:hover .tagify__tag__avatar-wrap{
            transform: scale(1.6) translateX(-10%);
        }
         .tagify__tag .tagify__tag__avatar-wrap{
            width: 16px;
            height: 16px;
            white-space: normal;
            border-radius: 50%;
            background: silver;
            margin-right: 5px;
            transition: .12s ease-out;
        }
         .tagify__tag img{
            width: 100%;
            vertical-align: top;
            pointer-events: none;
        }
    </style>

    <script src="https://unpkg.com/@yaireo/tagify"></script>
    <script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')

<div class="row">

    {{-- Main Content Section --}}
    <div class="col-xl-12 col-lg-12 col-12">
        {{-- Button Group Navigation --}}
        <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
            <button role="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-coa">
                <span class="icon text-white-50">
                    <i class="fas fa-pen"></i>
                </span>
                <span class="text">New</span>
            </button> 
        </div>
        <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
            <button role="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-coa">
                <span class="icon text-white-50">
                    <i class="fas fa-pen"></i>
                </span>
                <span class="text">Beginning balance</span>
            </button> 
        </div>
        <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-import">
                    <span class="icon text-white-50">
                        <i class="fas fa-file-import"></i>
                    </span>
                    <span class="text">Import</span>
                </button>
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-export">
                    <span class="icon text-white-50">
                        <i class="fas fa-download"></i>
                    </span>
                    <span class="text">Export</span>
                </button>
            </div>
        {{-- Tab Navigation --}}
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="transactions-tab" data-toggle="tab" href="#transactions" role="tab" aria-controls="transactions" aria-selected="true">Chart of Accounts</a>
            </li>
        </ul>

        {{-- Tab Contents --}}
        <div class="card" class="content-card">
            <div class="card-body tab-content" id="myTabContent">
                {{-- Transaction Contents --}}
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="tab-pane fade show active" id="transactions" role="tabpanel" aria-labelledby="transactions-tab">
                    <div class="table-responsive">
                         <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                            <thead>
                                
                                <th>Chart of Acct#</th>
                                <th>Account Name</th>
                                <th>Account Type</th>
                                <th>Categories</th>
                                <th>Balance</th>
                                <th>Status</th>
                                <th class="thead-actions">Actions</th>
                                
                            </thead>
                            <tbody>
                                @foreach($chart_of_accounts as $coa)
                                <tr>
                                    <td class="table-item-content">{{ $coa->chart_of_account_no }}</td>
                                    <td class="table-item-content">{{ $coa->name }}</td> 
                                    <td class="table-item-content">{{ $coa->type }}</td>
                                    <td class="table-item-content">{{ $coa->category }}</td>
                                    <td class="table-item-content">{{ $coa->current_balance }}</td>
                                    <td class="table-item-content h6">
                                        @if($coa->status == 'Active')
                                            <span class="badge badge-success">{{ $coa->status }}</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $coa->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-small btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button> --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

</div>
{{-- {{ $chart_of_accounts[0]->id }} --}}



{{-- Modals --}}
{{-- New Account --}}
<div class="modal fade" id="modal-coa" tabindex="-1" role="dialog" aria-labelledby="modal-deposit-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-deposit-label">New Chart of Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-coa" method="post" action="/settings/coa">
                    @csrf
                    <div class="form-group row">
                        <label for="coa_number" class="col-sm-3 col-lg-2 col-form-label">Chart of Account Number</label>
                        <div class="col-sm-9 col-lg-6">
                            <input type="text" class="form-control" id="coa_number" name="coa_number">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="coa_name" class="col-sm-3 col-lg-2 col-form-label">Account Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <input type="text" class="form-control" id="coa_name" name="coa_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="coa_category" class="col-sm-3 col-lg-2 col-form-label">Category<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            {{-- <input type="text" class="form-control" id="coa_category" name="coa_category"> --}}
                            <input id="coa_category" name='coa_category'>
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label for="coa_beginning_balance" class="col-sm-3 col-lg-2 col-form-label">Beginning Balance<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            {{-- <input type="text" class="form-control" id="coa_category" name="coa_category"> --}}
                            <input type="number" step=".01" class="form-control inputPrice" id="coa_beginning_balance" name="coa_beginning_balance" placeholder="0.00">
                        </div>
                    </div>         
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-coa">Save Account</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#dataTables').DataTable();
        $('.dataTables_filter').addClass('pull-right');
    });


</script>
<script src="/js/settings/chart_of_accounts/template_select_coa_category.js"></script>
<script src="/js/settings/chart_of_accounts/select_coa_category.js"></script>

@endsection