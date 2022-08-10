@extends('template.index')

@push('styles')
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
@endpush

@section('content')

<div class="row">

    {{-- Main Content Section --}}
    <div class="col-xl-10 col-lg-9 col-12">
        {{-- Button Group Navigation --}}
        <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <span class="icon text-white-50">
                        <i class="fas fa-pen"></i>
                    </span>
                    <span class="text">New</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-receipt">Receipt</a>
                    <a role="button" class="dropdown-item" data-toggle="modal"
                        data-target="#modal-advance-revenue">Advance Revenue</a>
                    <a role="button" class="dropdown-item" data-toggle="modal"
                        data-target="#modal-credit-receipt">Credit Receipt</a>
                    <a role="button" class="dropdown-item" data-toggle="modal"
                        data-target="#modal-proforma">Proforma</a>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-import">
                <span class="icon text-white-50">
                    <i class="fas fa-file-import"></i>
                </span>
                <span class="text">Import</span>
            </button>
            {{-- <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-export">
                <span class="icon text-white-50">
                    <i class="fas fa-download"></i>
                </span>
                <span class="text">Export</span>
            </button> --}}
        <a class="btn btn-secondary" href="{{route('receipts.export.csv')}}">Export</a>
            {{-- <button type="button" class="btn btn-secondary">
                <span class="icon text-white-50">
                    <i class="fas fa-download"></i>
                </span>
                <span class="text">Download Excel Format</span>
            </button> --}}
        </div>

        {{-- Tab Navigation --}}
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="transactions-tab" data-toggle="tab" href="#transactions" role="tab"
                    aria-controls="transactions" aria-selected="true">Transactions</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="proforma-tab" data-toggle="tab" href="#proforma" role="tab"
                    aria-controls="proforma" aria-selected="false">Proforma</a>
            </li>
        </ul>

        {{-- Tab Contents --}}
        <div class="card" class="content-card">
            <div class="card-body tab-content" id="myTabContent">
                {{-- Transaction Contents --}}
                <div class="tab-pane fade show active" id="transactions" role="tabpanel"
                    aria-labelledby="transactions-tab">
                    @if(isset($_GET['success']))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $_GET['success'] }}
                            {{-- {{ session()->get('success') }} --}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @elseif(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                            <thead>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Customer Name</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                      
                                <tr>
                                    <td class="table-item-content">{{$transaction->date}}</td>
                                    <td class="table-item-content">
                                        @if($transaction->type == 'receipt')
                                        <span class="badge badge-success">Receipt</span>
                                        @elseif($transaction->type == 'advance_receipt')
                                        <span class="badge badge-primary">Advance Revenue</span>
                                        @elseif($transaction->type == 'credit_receipt')
                                        <span class="badge badge-info">Credit Receipt</span>
                                        @endif
                                    </td>
                                    <td class="table-item-content">{{$transaction->name}}</td>
                                    <td class="table-item-content">
                                        @if($transaction->status == 'unpaid')
                                        <span class="badge badge-danger">Unpaid</span>
                                        @elseif($transaction->status == 'partially_paid')
                                        <span class="badge badge-warning">Partially Paid</span>
                                        @elseif($transaction->status == 'paid')
                                        <span class="badge badge-success">Paid</span>
                                        @endif
                                    </td>
                                    <td class="table-item-content text-right">
                                        @if($transaction->type == 'receipt')
                                        {{ number_format($transaction->amount, 2) }}
                                        @elseif($transaction->type == 'advance_receipt')
                                        {{ number_format($transaction->advance_revenue_amount, 2) }}
                                        @elseif($transaction->type == 'credit_receipt')
                                            {{ number_format($transaction->credit_receipt_amount, 2) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaction->type == 'receipt')
                                        <a class="btn btn-secondary btn-sm" href="{{route('receipts.receipt.mail',$transaction->receipt->id)}}">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Proforma Contents --}}
                <div class="tab-pane fade" id="proforma" role="tabpanel" aria-labelledby="proforma-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTables2" width="100%" cellspacing="0">
                            <thead>
                                <th>Date</th>
                                <th>Customer Name</th>
                                <th>Amount</th>
                                <th id="thead-actions">Actions</th>
                            </thead>
                            <tbody>
                                @foreach($proformas as $proforma)
                                <tr>
                                        {{-- <button type="button" class="btn btn-small btn-icon btn-primary"
                                            data-toggle="tooltip" data-placement="bottom" title="Edit">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-danger "
                                        onClick="showModel({!! $proforma->id !!})">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button> --}}
                                    <td class="table-item-content">{{$proforma->date}}</td>
                                    <td class="table-item-content">{{$proforma->name}}</td>
                                    <td class="table-item-content text-right">{{ number_format($proforma->proforma_amount, 2) }}</td>
                                    <td>
                                        <a role="button" class="btn btn-sm btn-icon btn-primary mb-1 disabled">
                                            <!-- edit -->
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </a>
                                        <button class="btn btn-sm btn-icon btn-danger mb-1" disabled>
                                            <!-- delete -->
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--  Delete Modal --}}
    <div class="modal fade" id="deleteConfirmationModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-customer-label">Delete Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure to delete this record?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onClick="dismissModel()">Cancel</button>
                    <form id="delete-frm" class="" action="" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar Content --}}
    <div class="col-xl-2 col-lg-3 d-none d-lg-block">
        <h4 class="">Account Receivable</h4>
        {{-- Account Receivable Active --}}
        <div class="mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Birr 40,000</div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                2 Active</div>
                        </div>
                        <div class="col-auto">
                            {{-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Account Receivable Overdue --}}
        <div class="mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Birr 215,000</div>
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                5 Over Due</div>
                        </div>
                        <div class="col-auto">
                            {{-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



{{-- Modals --}}

{{--
KNOWN POTENTIAL PROBLEMS:
> Modal Contents have similar IDs for its contents.
POTENTIAL SOLUTIONS:
> Update form on button click via JS.
--}}

{{-- New Receipt --}}
<form class="ajax-submit-updated" action="{{route('receipts.receipt.store') }}" id="form-receipt" method="post" enctype="multipart/form-data" data-message="Successfully created receipt.">
    @csrf
    <div class="modal fade" id="modal-receipt" tabindex="-1" role="dialog" aria-labelledby="modal-receipt-label"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-receipt-label">New Receipt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('customer.receipt.forms.receipt')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form-receipt">Save Receipt</button>
                </div>
            </div>
        </div>
    </div>
</form>
{{-- New Advance Revenue --}}
<form class="ajax-submit-updated" action="{{route('receipts.advanceReceipt.store')}}" id="form-advance-revenue" method="post" enctype="multipart/form-data" data-message="Successfully created advance revenue.">
    @csrf   
    <div class="modal fade" id="modal-advance-revenue" tabindex="-1" role="dialog"
        aria-labelledby="modal-advance-revenue-label" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-advance-revenue-label">New Advance Revenue</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('customer.receipt.forms.advance_revenue')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form-advance-revenue">Save Advance Revenue</button>
                </div>
            </div>
        </div>
    </div>
</form>
{{-- New Credit Receipt --}}
<form class="ajax-submit-updated" action="{{route('receipts.creditReceipt.store')}} "id="form-credit-receipt" method="post" enctype="multipart/form-data" data-message="Successfully added credit receipt.">
    @csrf
    <div class="modal fade" id="modal-credit-receipt" tabindex="-1" role="dialog"
        aria-labelledby="modal-credit-receipt-label" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-credit-receipt-label">New Credit Receipt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('customer.receipt.forms.credit_receipt')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form-credit-receipt">Save Credit Receipt</button>
                </div>
            </div>
        </div>
    </div>
</form>
{{-- New Proforma --}}
<form class="ajax-submit-updated" action="{{route('receipts.proforma.store') }}" id="form-proforma" method="post" enctype="multipart/form-data" data-message="Successfully created proforma.">
    @csrf   
    <div class="modal fade" id="modal-proforma" tabindex="-1" role="dialog" aria-labelledby="modal-proforma-label" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-proforma-label">New Proforma</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('customer.receipt.forms.proforma')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form-proforma">Save Proforma</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- Import --}}
<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="modal-import-label"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-import-label">Import Receipts</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-import" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="i_file" class="col-sm-4 col-form-label">File<span
                                class="text-danger ml-1">*</span></label>
                        <div class="col-sm-8">
                            <input type="file" id="i_file" name="file" class="mt-1" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-import">Import Receipts</button>
            </div>
        </div>
    </div>
</div>

{{-- Export
<div class="modal fade" id="modal-export" tabindex="-1" role="dialog" aria-labelledby="modal-export-label"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-export-label">Export Receipts</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-export" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="e_file_type" class="col-sm-4 col-form-label">File Type<span
                                class="text-danger ml-1">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" id="e_file_type" name="file_type" required>
                                <option>HTML</option>
                                <option>PDF</option>
                                <option>CSV</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-export">Export Receipts</button>
            </div>
        </div>
    </div>
</div> --}}

<script>
    $(document).ready(function () {
        $('#dataTables').DataTable();
        $('#dataTables2').DataTable();
        $('.dataTables_filter').addClass('pull-right');
    });
    // https://www.mockaroo.com/
    
    var controller;
    function showModel(id) {
        var frmDelete = document.getElementById("delete-frm");
        frmDelete.action = 'receipt/'+id;
        var confirmationModal = document.getElementById("deleteConfirmationModel");
        confirmationModal.style.display = 'block';
        confirmationModal.classList.remove('fade');
        confirmationModal.classList.add('show');
    }
    
    function dismissModel() {
        var confirmationModal = document.getElementById("deleteConfirmationModel");
        confirmationModal.style.display = 'none';
        confirmationModal.classList.remove('show');
        confirmationModal.classList.add('fade');
    }

    </script>
    <script src="/js/customer/receipt/template_select_customer.js"></script>
    <script src="/js/customer/receipt/template_select_tax.js"></script>
 
    <script src="/js/customer/receipt/select_customer_receipt.js"></script>
    <script src="/js/customer/receipt/select_customer_proforma.js"></script>
    <script src="/js/customer/receipt/select_customer_advancerevenue.js"></script>
    <script src="/js/customer/receipt/select_customer_creditreceipt.js"></script>

    <script src="/js/customer/receipt/template_select_item.js"></script>
    <script src="/js/customer/receipt/select_item_receipt.js"></script>
    <script src="/js/customer/receipt/select_item_proforma.js"></script>
    <script src="/js/customer/receipt/select_receipt_creditreceipt.js"></script>

    <script src="/js/customer/receipt/template_select_proforma.js"></script>
    <script src="/js/customer/receipt/select_proforma_receipt.js"></script>
    @endsection