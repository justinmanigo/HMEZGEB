@extends('template.index')

@section('content')
<div class="row">

    <div class="col-12">
        <!----buttons----->
        <div class="d-flex justify-content-between mb-3">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">New Bill</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a role="button" class="dropdown-item" data-toggle="modal"
                            data-target="#modal-cogs">COGS <span class="badge badge-success">New</span></a>
                        <a role="button" class="dropdown-item" data-toggle="modal"
                            data-target="#modal-expense">Expense <span class="badge badge-success">New</span></a>
                        <a role="button" class="dropdown-item" data-toggle="modal"
                            data-target="#modal-bill">Bill</a>
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
            <div class="mt-2 mb-0 pb-0">
                <h5 class="pb-0 mb-0">
                    Account Payable:
                    <span class="badge badge-warning pb-1">Active: {{$count}}</span>
                    <span class="badge badge-warning mr-2 pb-1">{{number_format($total_balance,2)}}</span>
                    <span class="badge badge-danger pb-1">Overdue: {{$count_overdue}}</span>
                    <span class="badge badge-danger pb-1">{{number_format($total_balance_overdue,2)}}</span>
                </h5>
            </div>
        </div>



        <!-- DataTales Example -->

        <div class="card mb-4">
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

                <!-- add search input group -->
                <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                    <form id="bills-search-form">
                        <div class="input-group mr-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="search-addon"><i class="fas fa-search"></i></span>
                            </div>
                            <input id="bills-search-input" type="text" class="form-control" placeholder="Search" aria-label="Search"
                                aria-describedby="search-addon">
                            <button id="bills-search-submit" type="submit" class="btn btn-primary" disabled style="border-radius:0px 5px 5px 0px">
                                <span class="icon text-white-50">
                                    <i class="fas fa-search"></i>
                                </span>
                                <span class="text">Submit</span>
                            </button>
                        </div>
                    </form>
                    <div class="btn-group" role="group" aria-label="Second group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="bills-page-number-label">Page 0 of 0</span>
                        </div>
                        <button id="bills-prev" type="button" class="btn btn-secondary" disabled=true>Prev</button>
                        <button id="bills-next" type="button" class="btn btn-secondary" disabled=true>Next</button>
                    </div>
                </div>

                {{-- Transaction Contents --}}
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Vendor/Description</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th width="160px">Actions</th>
                        </thead>
                        <tbody id="bills-list">
                            <!-- JS will populate this -->
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Vendor/Description</th>
                                <th>Remark</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- foreach bills -->
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{$transaction->id}}</td>
                                    <td>{{$transaction->date}}</td>
                                    <!-- Select type -->
                                    <td class="h6">
                                        @if($transaction->type == 'bill')
                                            <span class="badge badge-primary">Bill</span>
                                        @elseif($transaction->type == 'purchase_order')
                                            <span class="badge badge-secondary">Purchase Order</span>
                                        @elseif($transaction->type == 'cogs')
                                            <span class="badge badge-info">COGS</span>
                                        @elseif($transaction->type == 'expense')
                                            <span class="badge badge-warning">Expense</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaction->type == 'bill' || $transaction->type == 'purchase_order')
                                            {{$transaction->name}}
                                        @elseif($transaction->type == 'cogs')
                                            {{ 'COGS' }}
                                        @elseif($transaction->type == 'expense')
                                            {{ 'Expense' }}
                                        @endif
                                    </td>
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
                                        @elseif($transaction->type == 'cogs')
                                            {{ number_format($transaction->cost_of_goods_sold_amount, 2) }}
                                        @elseif($transaction->type == 'expense')
                                            {{ number_format($transaction->expenses_amount, 2) }}
                                        @endif
                                    </td>
                                    <td>
                                        {{-- TODO: Implement hover action bar --}}

                                        <!-- edit -->
                                        @if($transaction->type == 'bill')
                                            <a href="#{{--route('bills.bills.show', $transaction->bills->id)--}}" class="btn btn-primary btn-sm edit disabled">
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
                                        @elseif($transaction->type == 'purchase_order')
                                            <a href="javascript:void(0)" class="btn btn-primary btn-sm edit disabled">
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
                                        @elseif($transaction->type == 'cogs')
                                            <a href="#" class="btn btn-primary btn-sm edit disabled">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                            </a>
                                            <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-mail-confirmation" disabled>
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-envelope"></i>
                                                </span>
                                                </button>
                                            <!-- print/pdf -->
                                            <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-print-confirmation" disabled>
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-print"></i>
                                                </span>
                                            </button>
                                            <!-- void -->
                                            @if($transaction->is_void == 'no')
                                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-void-confirmation" disabled>
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-ban"></i>
                                                    </span>
                                                </button>
                                                <!-- make it active -->
                                            @else
                                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-reactivate-confirmation" disabled>
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                </button>
                                            @endif
                                        @elseif($transaction->type == 'expense')
                                            <a href="#" class="btn btn-primary btn-sm edit disabled">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                            </a>
                                            <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-mail-confirmation" disabled>
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-envelope"></i>
                                                </span>
                                                </button>
                                            <!-- print/pdf -->
                                            <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-print-confirmation" disabled>
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-print"></i>
                                                </span>
                                            </button>
                                            <!-- void -->
                                            @if($transaction->is_void == 'no')
                                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-void-confirmation" disabled>
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-ban"></i>
                                                    </span>
                                                </button>
                                                <!-- make it active -->
                                            @else
                                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-reactivate-confirmation" disabled>
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
</div>

@include('vendors.bills.modals.types.cogs')
@include('vendors.bills.modals.types.expense')
@include('vendors.bills.modals.types.bill')

{{-- Modal Contents --}}
<!--------For purchase order--->
<div class="modal fade bd-purchaseOrder-modal-xl" id="modal-purchase-order" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <img class="mr-5"
                    src="https://user-images.githubusercontent.com/75387615/156304203-f98fe8db-d7a4-409f-a83c-8221c88e6e80.jpg">
                <p class="h3 pl-4 m-auto">Purchase Order</p>
                <a class="close" data-dismiss="modal">×</a>
            </div>
            <form class="ajax-submit-updated" id="form-purchase-order" action="{{ url('/vendors/bills/purchaseorder') }}"
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
        $('#modal-reactivate-confirmation-btn').attr('href', '{{ route("bills.bill.revalidate", ":id") }}'.replace(':id', id));
        else if(type == 'purchaseOrder')
        $('#modal-reactivate-confirmation-btn').attr('href', '{{ route("bills.purchaseOrder.revalidate", ":id") }}'.replace(':id', id));
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
<script src="/js/hoverable.js"></script>
<script src="/js/vendors/bill/bills_table.js"></script>
<script src="/js/vendors/bill/table_actions.js"></script>

<script src="/js/vendors/template_select_tax.js"></script>
<script src="/js/vendors/template_select_vendor.js"></script>
<script src="/js/vendors/template_select_purchase_order.js"></script>
<script src="/js/tagify_templates/template_select_cash_account.js"></script>
<script src="/js/tagify_templates/template_select_expense_account.js"></script>
<script src="/js/vendors/template_select_item.js"></script>
<script src="/js/vendors/bill/select_item_bill.js"></script>
<script src="/js/vendors/bill/select_item_purchaseorder.js"></script>
<script src="/js/vendors/bill/select_vendor_bill.js"></script>
<script src="/js/vendors/bill/select_vendor_purchaseorder.js"></script>
<script src="/js/vendors/bill/select_purchase_order_bill.js"></script>

<script src="/js/vendors/bill/modal_bill.js"></script>
<script src="/js/vendors/bill/modal_cogs.js"></script>
<script src="/js/vendors/bill/modal_expense.js"></script>
<script src="/js/vendors/bill/default_values.js"></script>

@endsection
