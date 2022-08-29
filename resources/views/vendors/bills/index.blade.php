@extends('template.index')

@push('styles')
<style>
    @media (max-width: 576px) {
        .responsive-btn {
            font-size: .5rem;
        }
    }

    /*
            TEMPORARY
        */
    /* Suggestions items */
    .tagify__dropdown.vendors-list .tagify__dropdown__item {
        padding: .5em .7em;
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 0 1em;
        grid-template-areas: "avatar name"
            "avatar email";
    }

    .tagify__dropdown.vendors-list .tagify__dropdown__item:hover .tagify__dropdown__item__avatar-wrap {
        transform: scale(1.2);
    }

    .tagify__dropdown.vendors-list .tagify__dropdown__item__avatar-wrap {
        grid-area: avatar;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        overflow: hidden;
        background: #EEE;
        transition: .1s ease-out;
    }

    .tagify__dropdown.vendors-list img {
        width: 100%;
        vertical-align: top;
    }

    .tagify__dropdown.vendors-list strong {
        grid-area: name;
        width: 100%;
        align-self: center;
    }

    .tagify__dropdown.vendors-list span {
        grid-area: email;
        width: 100%;
        font-size: .9em;
        opacity: .6;
    }

    .tagify__dropdown.vendors-list .addAll {
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

    <div class="col-xl-10 col-lg-9 col-12">
        <!----buttons----->
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
                    <a role="button" class="dropdown-item" data-toggle="modal"
                        data-target=".bd-example-modal-xl">Bill</a>
                    <a role="button" class="dropdown-item" data-toggle="modal"
                        data-target=".bd-purchaseOrder-modal-xl">Purchase Order</a>
                </div>
            </div>
            {{-- <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-import">
                <span class="icon text-white-50">
                    <i class="fas fa-file-import"></i>
                </span>
                <span class="text">Import</span>
            </button> --}}
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-export">
                <span class="icon text-white-50">
                    <i class="fas fa-download"></i>
                </span>
                <span class="text">Export</span>
            </button>
            {{-- <button type="button" class="btn btn-secondary">
                <span class="icon text-white-50">
                    <i class="fas fa-download"></i>
                </span>
                <span class="text">Download Excel Format</span>
            </button> --}}
        </div>


        <!-- DataTales Example -->

        <div class="card shadow mb-4">
            <!---------Table--------->
            <div class="card-body">
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @elseif(session()->has('danger'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session()->get('danger') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                @elseif(isset($_GET['success']))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ $_GET['success'] }}
                        {{-- {{ session()->get('success') }} --}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>     
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Reference#</th>
                                <th>Type</th>
                                <th>Vendor Name</th>
                                <th>Remark</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- foreach bills -->
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>{{$transaction->date}}</td>
                                <td>{{$transaction->id}}</td>
                                <!-- Select type -->
                                <td class="h6">
                                    @if($transaction->type == 'bill')<span class="badge badge-primary">Bill</span>
                                    @elseif($transaction->type == 'purchase_order')<span class="badge badge-primary">Purchase
                                        Order</span>
                                </td>
                                @endif
                                <td>{{$transaction->name}}</td>
                                <!-- Select status -->
                                <td class="h6">
                                    @if($transaction->status == 'paid')<span class="badge badge-success">Paid</span>
                                    @elseif($transaction->status == 'unpaid')<span class="badge badge-danger">Unpaid</span>
                                    @elseif($transaction->status == 'partially_paid')<span
                                        class="badge badge-warning">Partially
                                        Paid</span>
                                    @endif
                                </td>

                                <td>Birr 
                                    @if($transaction->type == 'bill')
                                        {{ number_format($transaction->bill_amount, 2) }}
                                    @elseif($transaction->type == 'purchase_order')
                                        {{ number_format($transaction->purchase_order_amount, 2) }}
                                    @endif
                                </td>
                                <td>
                                    {{-- TODO: Implement hover action bar --}}
                                    
                                    <!-- edit -->
                                    @if($transaction->type == 'bill')
                                    <a href="{{route('bills.bills.show', $transaction->bills->id)}}" class="btn btn-primary btn-sm edit">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                    </a>
                                    {{-- mail --}}
                                    {{-- button mail confirmation modal  --}}
                                    <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-mail-confirmation" onclick="mailModal({{$transaction->bills->id}},'bill')"> 
                                        <span class="icon text-white-50">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                    </button>
                                    <!-- print/pdf -->
                                    <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-print-confirmation" onclick="printModal({{$transaction->bills->id}},'bill')">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-print"></i>
                                        </span>
                                    </button>
                                    <!-- void -->
                                    @if($transaction->is_void == 'no')
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-void-confirmation" onclick="voidModal({{$transaction->bills->id}},'bill')">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-ban"></i>
                                        </span>
                                    </button>
                                    <!-- make it active -->
                                    @else
                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-reactivate-confirmation" onclick="reactivateModal({{$transaction->bills->id}},'bill')">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    </button>
                                    @endif
                                    @else
                                        <a href="{{route('bills.purchaseOrder.show', $transaction->purchaseOrders->id)}}" class="btn btn-primary btn-sm edit">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </a>
                                        <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-mail-confirmation" onclick="mailModal({{$transaction->purchaseOrders->id}},'purchaseOrder')">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                        </button>
                                    <!-- print/pdf -->
                                    <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-print-confirmation" onclick="printModal({{$transaction->purchaseOrders->id}},'purchaseOrder')">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-print"></i>
                                        </span>
                                    </button>
                                    <!-- void -->
                                    @if($transaction->is_void == 'no')
                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-void-confirmation" onclick="voidModal({{$transaction->purchaseOrders->id}},'purchaseOrder')">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-ban"></i>
                                            </span>
                                        </button>
                                        <!-- make it active -->
                                        @else
                                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-reactivate-confirmation" onclick="reactivateModal({{$transaction->purchaseOrders->id}},'purchaseOrder')">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                            </span>
                                        </button>
                                    @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- side content --}}
    <div class="col-xl-2 col-lg-3 d-none d-lg-block">
        <h4 class="">Account Receivable</h4>
        {{-- Account Receivable Active --}}
        <div class="mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Birr {{number_format($total_balance)}}</div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                {{$count}} Active</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Birr {{number_format($total_balance_overdue)}}</div>
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                {{$count_overdue}} Over Due</div>
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

{{-- Modal Contents --}}
<!--------For add bill--->
<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <img class="mr-5"
                    src="https://user-images.githubusercontent.com/75387615/156304203-f98fe8db-d7a4-409f-a83c-8221c88e6e80.jpg">
                <p class="h3 pl-4 m-auto">New Bill</p>
                <a class="close" data-dismiss="modal">×</a>
            </div>
            <form class="ajax-submit-updated" id="form-new-bill" action="{{route('bills.bill.store') }}" method="post"
                enctype="multipart/form-data" data-message="Successfully created bill.">
                @csrf
                @include('vendors.bills.forms.addBillModal')
            </form>
        </div>
    </div>
</div>
<!--------For purchase order--->
<div class="modal fade bd-purchaseOrder-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <img class="mr-5"
                    src="https://user-images.githubusercontent.com/75387615/156304203-f98fe8db-d7a4-409f-a83c-8221c88e6e80.jpg">
                <p class="h3 pl-4 m-auto">Purchase Order</p>
                <a class="close" data-dismiss="modal">×</a>
            </div>
            <form class="ajax-submit-updated" id="form-purchase-order" action="{{route('bills.purchaseOrder.store') }}"
                method="post" data-message="Successfully created a purchase order.">
                @csrf
                @include('vendors.bills.forms.purchaseOrderModal')
            </form>
        </div>
    </div>
</div>

{{-- confirmation modal send mail --}}
<div class="modal fade" id="modal-mail-confirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Send Mail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to send this record to the client?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="" class="btn btn-primary" id="modal-mail-confirmation-btn">Send</a>
            </div>
        </div>
    </div>
</div>

{{-- confirmation modal print --}}
<div class="modal fade" id="modal-print-confirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Print</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to print this record?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="" class="btn btn-primary" id="modal-print-confirmation-btn">Send</a>
            </div>
        </div>
    </div>
</div>

{{-- confirmation modal void --}}
<div class="modal fade" id="modal-void-confirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Void</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to void this record?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="" class="btn btn-primary" id="modal-void-confirmation-btn">Void</a>
            </div>
        </div>
    </div>
</div>

{{-- confirmation modal reactivate --}}
<div class="modal fade" id="modal-reactivate-confirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Reactivate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reactivate this record?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="" class="btn btn-primary" id="modal-reactivate-confirmation-btn">Reactivate</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

<script>
    // Get id of transaction to mail confirmation modal
    function mailModal(id,type){
        // set attribute href of btn-send-mail
        if(type == 'bill')
        $('#modal-mail-confirmation-btn').attr('href', '{{ route("bills.bill.mail", ":id") }}'.replace(':id', id));
        else if(type == 'purchaseOrder')
        $('#modal-mail-confirmation-btn').attr('href', '{{ route("bills.purchaseOrder.mail", ":id") }}'.replace(':id', id));
        
    }

    // Get id of transaction to print confirmation modal
    function printModal(id,type){
        // set attribute href of btn-send-mail
        if(type == 'bill')
        $('#modal-print-confirmation-btn').attr('href', '{{ route("bills.bill.print", ":id") }}'.replace(':id', id));
        else if(type == 'purchaseOrder')
        $('#modal-print-confirmation-btn').attr('href', '{{ route("bills.purchaseOrder.print", ":id") }}'.replace(':id', id));
    }

    // VOID
    function voidModal(id,type){
        // set attribute href of btn-send-mail
        if(type == 'bill')
        $('#modal-void-confirmation-btn').attr('href', '{{ route("bills.bill.void", ":id") }}'.replace(':id', id));
        else if(type == 'purchaseOrder')
        $('#modal-void-confirmation-btn').attr('href', '{{ route("bills.purchaseOrder.void", ":id") }}'.replace(':id', id));
    }

    //  Reactivate
    function reactivateModal(id,type){
        // set attribute href of btn-send-mail
        if(type == 'bill')
        $('#modal-reactivate-confirmation-btn').attr('href', '{{ route("bills.bill.reactivate", ":id") }}'.replace(':id', id));
        else if(type == 'purchaseOrder')
        $('#modal-reactivate-confirmation-btn').attr('href', '{{ route("bills.purchaseOrder.reactivate", ":id") }}'.replace(':id', id));
    }



    var controller;
$(document).ready(function() {
    $('#dataTables').DataTable();
    $('.dataTables_filter').addClass('pull-right');
});

//$('#details').trumbowyg();
//$('#features').trumbowyg();
</script>

<!-- Vendors -->
<script src="/js/vendors/template_select_tax.js"></script>
<script src="/js/vendors/template_select_vendor.js"></script>
<script src="/js/vendors/template_select_purchase_order.js"></script>
<script src="/js/vendors/bill/select_vendor_bill.js"></script>
<script src="/js/vendors/bill/select_vendor_purchaseorder.js"></script>
<script src="/js/vendors/bill/select_purchase_order_bill.js"></script>

<!-- Items -->
<script src="/js/vendors/template_select_item.js"></script>
<script src="/js/vendors/bill/select_item_bill.js"></script>
<script src="/js/vendors/bill/select_item_purchaseorder.js"></script>

@endsection