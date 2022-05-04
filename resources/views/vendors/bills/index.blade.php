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
<div class="container-fluid">
    <div class="d-sm-flex align-items-start justify-content-between">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Bills</h1>
        <!--- card for account payable--->
        <div class="col-xl-3 col-md-6 mb-4 border-1">
            <div class="card border-left-primary shadow h-100 pt-2">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                        Account Payable
                    </div>
                </div>
                <div class="card-body">
                    <div class="row no-gutters d-flex align-items-center justify-content-around">
                        <div class="h6 mb-0">
                            <span class="font-weight-bold text-gray-800">$40,000</span><br>
                            <small>Active</small>
                        </div>
                        <div class="h6 mb-0">
                            <span class="font-weight-bold text-danger">$3,500</span><br>
                            <small>Over Due</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header pt-3">
            <div class="row d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary col-md-2">Bills</h6>

                <!----buttons----->
                <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                    <button type="button" class="btn btn-secondary">
                        <span class="icon text-white-50">
                            <i class="fas fa-download"></i>
                        </span>
                        <span class="text">Download Excel Format</span>
                    </button>
                </div>
                <!---- end buttons----->
            </div>
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if(session()->has('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session()->get('warning') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
        </div>

        {{-- Modal Contents --}}
        <!--------For add vendor--->
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
                    <form action="{{route('bills.bill.store') }}" method="post" id="contactForm" name="contact"
                        role="form">
                        @csrf
                        @include('vendors.bills.forms.addBillModal')
                    </form>
                </div>
            </div>
        </div>
        <!--------For purchase order--->
        <div class="modal fade bd-purchaseOrder-modal-xl" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center">
                        <img class="mr-5"
                            src="https://user-images.githubusercontent.com/75387615/156304203-f98fe8db-d7a4-409f-a83c-8221c88e6e80.jpg">
                        <p class="h3 pl-4 m-auto">Purchase Order</p>
                        <a class="close" data-dismiss="modal">×</a>
                    </div>
                    <form action="{{route('bills.purchaseOrder.store') }}" method="post" id="contactForm" name="contact"
                        role="form">
                        @csrf
                        @include('vendors.bills.forms.purchaseOrderModal')
                    </form>
                </div>
            </div>
        </div>
        <!---------Table--------->
        <div class="card-body">
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
                        </tr>
                    </thead>

                    <tbody>
                        <!-- foreach bills -->
                        @foreach($bill_and_purchase_order as $bill)
                        <tr onclick="window.location='/'">
                            <td>{{$bill->date}}</td>
                            <td>{{$bill->id}}</td>
                            <!-- Select type -->
                            <td class="h6">
                                @if($bill->type == 'bill')<span class="badge badge-primary">Bill</span>
                                @elseif($bill->type == 'purchase_order')<span class="badge badge-primary">Purchase
                                    Order</span>
                            </td>
                            @endif
                            <td>{{$bill->name}}</td>
                            <!-- Select status -->
                            <td class="h6">
                                @if($bill->remark == 'paid')<span class="badge badge-success">Paid</span>
                                @elseif($bill->remark == 'unpaid')<span class="badge badge-danger">Unpaid</span>
                                @elseif($bill->remark == 'partially_paid')<span class="badge badge-warning">Partially
                                    Paid</span>
                                @endif
                            </td>

                            <td>{{$bill->grand_total}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->


<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

<script>
var controller;
$(document).ready(function() {
    $('#dataTables').DataTable();
    $('.dataTables_filter').addClass('pull-right');
});

//$('#details').trumbowyg();
//$('#features').trumbowyg();
</script>

<!-- Vendors -->
<script src="/js/vendors/template_select_vendor.js"></script>
<script src="/js/vendors/bill/select_vendor_bill.js"></script>
<script src="/js/vendors/bill/select_vendor_purchaseorder.js"></script>

<!-- Items -->
<script src="/js/vendors/template_select_item.js"></script>
<script src="/js/vendors/bill/select_item_bill.js"></script>
<script src="/js/vendors/bill/select_item_purchaseorder.js"></script>



@endsection