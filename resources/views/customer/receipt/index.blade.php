@extends('template.index')

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
                        <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-sale">Sale <span class="badge badge-success">New</span></a>
                        <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-receipt">Receipt</a>
                        <a role="button" class="dropdown-item disabled" data-toggle="modal"
                            {{-- data-target="#modal-advance-revenue" --}}>Advance Revenue <span class="badge badge-danger">Soon</span></a>
                        <a role="button" class="dropdown-item" data-toggle="modal"
                            data-target="#modal-credit-receipt">Credit Receipt</a>
                        <a role="button" class="dropdown-item" data-toggle="modal"
                            data-target="#modal-proforma">Proforma</a>
                    </div>
                </div>
                {{-- <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-import">
                    <span class="icon text-white-50">
                        <i class="fas fa-file-import"></i>
                    </span>
                    <span class="text">Import</span>
                </button> --}}
                {{-- <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-export">
                    <span class="icon text-white-50">
                        <i class="fas fa-download"></i>
                    </span>
                    <span class="text">Export</span>
                </button> --}}
            <a class="btn btn-secondary" href="{{route('receipts.export.csv')}}">Export</a>
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
                                    <th>ID</th>
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
                                        <td class="table-item-content">{{$transaction->id}}</td>
                                        <td class="table-item-content">{{$transaction->date}}</td>
                                        <td class="table-item-content">
                                            @if($transaction->type == 'receipt')
                                                <span class="badge badge-success">Receipt</span>
                                            @elseif($transaction->type == 'advance_receipt')
                                                <span class="badge badge-primary">Advance Revenue</span>
                                            @elseif($transaction->type == 'credit_receipt')
                                                <span class="badge badge-info">Credit Receipt</span>
                                            @elseif($transaction->type == 'sale')
                                                <span class="badge badge-success">Sale</span>
                                            @endif
                                        </td>
                                        <td class="table-item-content">
                                            @if(isset($transaction->name))
                                                {{ $transaction->name }}
                                            @else
                                                {{ "Sales" }}
                                            @endif
                                        </td>
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
                                            Birr
                                            @if($transaction->type == 'receipt')
                                                {{ number_format($transaction->receipt_amount, 2) }}
                                            @elseif($transaction->type == 'advance_receipt')
                                                {{ number_format($transaction->advance_revenue_amount, 2) }}
                                            @elseif($transaction->type == 'credit_receipt')
                                                {{ number_format($transaction->credit_receipt_amount, 2) }}
                                            @elseif($transaction->type == 'sale')
                                                {{ number_format($transaction->sales_amount, 2) }}
                                            @endif
                                        </td>
                                        <td>
                                            {{-- TODO: Implement hover action bar --}}
                                            @if($transaction->type == 'receipt')
                                                <a href="{{route('receipts.receipts.show', $transaction->id)}}" class="btn btn-primary btn-sm edit">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                </a>
                                                <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-mail-confirmation" onclick="mailModal({{$transaction->id}}, 'receipt')" >
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                </button>
                                                <!-- print/pdf -->
                                                <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-print-confirmation" onclick="printModal({{$transaction->id}}, 'receipt')" >
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-print"></i>
                                                    </span>
                                                </button>
                                                @if($transaction->is_void == 'no')
                                                <!-- void -->
                                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-void-confirmation" onclick="voidModal({{$transaction->id}}, 'receipt')" >
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-ban"></i>
                                                    </span>
                                                </button>
                                                @else
                                                <!-- make it active -->
                                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-reactivate-confirmation" onclick="reactivateModal({{$transaction->id}}, 'receipt')" >
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                </button>
                                                @endif
                                            @elseif($transaction->type == 'advance_receipt')
                                                <a href="{{route('receipts.advanceReceipt.show', $transaction->id)}}" class="btn btn-primary btn-sm edit ">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                </a>
                                                <a class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-mail-confirmation" onclick="mailModal({{$transaction->id}}, 'advanceRevenue')">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                </a>
                                                <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-print-confirmation" onclick="printModal({{$transaction->id}}, 'advanceRevenue')" >
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-print"></i>
                                                    </span>
                                                </button>
                                                @if($transaction->is_void == 'no')
                                                <!-- void -->
                                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-void-confirmation" onclick="voidModal({{$transaction->id}}, 'advanceRevenue')">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-ban"></i>
                                                    </span>
                                                </button>
                                                <!-- make it active -->
                                                @else
                                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-reactivate-confirmation" onclick="reactivateModal({{$transaction->id}}, 'advanceRevenue')">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                </button>
                                                @endif
                                            @elseif($transaction->type == 'credit_receipt')
                                                <a href="{{route('receipts.creditReceipt.show', $transaction->id)}}" class="btn btn-primary btn-sm edit">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                </a>
                                                <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-mail-confirmation" onclick="mailModal({{$transaction->id}}, 'creditReceipt')">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                </button>
                                                <!-- print/pdf -->
                                                <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-print-confirmation" onclick="printModal({{$transaction->id}}, 'creditReceipt')">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-print"></i>
                                                    </span>
                                                </button>
                                                @if($transaction->is_void == 'no')
                                                <!-- void -->
                                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-void-confirmation" onclick="voidModal({{$transaction->id}}, 'creditReceipt')">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-ban"></i>
                                                    </span>
                                                </button>
                                                <!-- make it active -->
                                                @else
                                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-reactivate-confirmation" onclick="reactivateModal({{$transaction->id}}, 'creditReceipt')">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                </button>
                                                @endif
                                            @elseif($transaction->type == 'sale')
                                                <a href="javascript:void(0)" class="btn btn-primary btn-sm edit disabled">
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
                                                @if($transaction->is_void == 'no')
                                                    <!-- void -->
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-void-confirmation" disabled>
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-ban"></i>
                                                        </span>
                                                    </button>
                                                @else
                                                    <!-- make it active -->
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
                    {{-- Proforma Contents --}}
                    <div class="tab-pane fade" id="proforma" role="tabpanel" aria-labelledby="proforma-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTables2" width="100%" cellspacing="0">
                                <thead>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Customer Name</th>
                                    <th>Amount</th>
                                    <th id="thead-actions">Actions</th>
                                </thead>
                                <tbody>
                                    @foreach($proformas as $proforma)
                                    <tr>
                                        <td class="table-item-content">{{$proforma->id}}</td>
                                        <td class="table-item-content">{{$proforma->date}}</td>
                                        <td class="table-item-content">{{$proforma->name}}</td>
                                        <td class="table-item-content text-right">Birr {{ number_format($proforma->proforma_amount, 2) }}</td>
                                        <td>
                                            <a href="{{route('receipts.proformas.show', $proforma->proforma->id)}}" class="btn btn-primary btn-sm edit">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                            </a>
                                            <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-mail-confirmation" onclick="mailModal({{$proforma->proforma->id}}, 'proforma')">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-envelope"></i>
                                                </span>
                                            </button>
                                        <!-- print/pdf -->
                                            <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-print-confirmation" onclick="printModal({{$proforma->proforma->id}}, 'proforma')">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-print"></i>
                                                </span>
                                            </button>
                                        <!-- void -->
                                        @if($proforma->proforma->receiptReference->is_void == 'no')
                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-void-confirmation" onclick="voidModal({{$proforma->proforma->id}}, 'proforma')">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-ban"></i>
                                            </span>
                                        </button>
                                        <!-- make it active -->
                                        @else
                                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-reactivate-confirmation" onclick="reactivateModal({{$proforma->proforma->id}}, 'proforma')">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                            </span>
                                        </button>
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

        {{-- Sidebar Content --}}
        <div class="col-xl-2 col-lg-3 d-none d-lg-block">
            <h4 class="">Account Receivable</h4>
            {{-- Account Receivable Active --}}
            <div class="mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Birr {{number_format($total_balance,2)}}</div>
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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Birr {{number_format($total_balance_overdue,2)}}</div>
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

    {{-- Modals: Types --}}

    @include('customer.receipt.modals.types.receipt')
    @include('customer.receipt.modals.types.advance_revenue')
    @include('customer.receipt.modals.types.credit_receipt')
    @include('customer.receipt.modals.types.proforma')
    @include('customer.receipt.modals.types.sale')

    {{-- Modals: Actions --}}
    @include('customer.receipt.modals.actions.delete')
    @include('customer.receipt.modals.actions.export')
    @include('customer.receipt.modals.actions.import')
    @include('customer.receipt.modals.actions.mail')
    @include('customer.receipt.modals.actions.print')
    @include('customer.receipt.modals.actions.reactivate')
    @include('customer.receipt.modals.actions.void')

    {{-- Scripts --}}

    <script>
        // Get id of transaction to mail confirmation modal
        function mailModal(id, type){
            // set attribute href of btn-send-mail
            if(type=="receipt")
            $('#btn-send-mail').attr('href', '{{ route("receipts.receipt.mail", ":id") }}'.replace(':id', id));
            if(type=="advanceRevenue")
            $('#btn-send-mail').attr('href', '{{ route("receipts.advanceRevenue.mail", ":id") }}'.replace(':id', id));
            if(type=="creditReceipt")
            $('#btn-send-mail').attr('href', '{{ route("receipts.creditReceipt.mail", ":id") }}'.replace(':id', id));
            if(type=="proforma")
            $('#btn-send-mail').attr('href', '{{ route("receipts.proformas.mail", ":id") }}'.replace(':id', id));
        }

        // Get id of transaction to print confirmation modal
        function printModal(id, type){
            // set attribute href of print-receipt
            if(type=="receipt")
            $('#print-receipt').attr('href', '{{ route("receipts.receipt.print", ":id") }}'.replace(':id', id));
            if(type=="advanceRevenue")
            $('#print-receipt').attr('href', '{{ route("receipts.advanceRevenue.print", ":id") }}'.replace(':id', id));
            if(type=="creditReceipt")
            $('#print-receipt').attr('href', '{{ route("receipts.creditReceipt.print", ":id") }}'.replace(':id', id));
            if(type=="proforma")
            $('#print-receipt').attr('href', '{{ route("receipts.proformas.print", ":id") }}'.replace(':id', id));
        }

        // Void record

        function voidModal(id, type) {
            if(type=="receipt")
            $('#void-receipt').attr('href', '{{ route("receipts.receipt.void", ":id") }}'.replace(':id', id));
            if(type=="advanceRevenue")
            $('#void-receipt').attr('href', '{{ route("receipts.advanceRevenue.void", ":id") }}'.replace(':id', id));
            if(type=="creditReceipt")
            $('#void-receipt').attr('href', '{{ route("receipts.creditReceipt.void", ":id") }}'.replace(':id', id));
            if(type=="proforma")
            $('#void-receipt').attr('href', '{{ route("receipts.proformas.void", ":id") }}'.replace(':id', id));
        }

        function reactivateModal(id, type)
        {
            if(type=="receipt")
            $('#reactivate-receipt').attr('href', '{{ route("receipts.receipt.reactivate", ":id") }}'.replace(':id', id));
            if(type=="advanceRevenue")
            $('#reactivate-receipt').attr('href', '{{ route("receipts.advanceRevenue.reactivate", ":id") }}'.replace(':id', id));
            if(type=="creditReceipt")
            $('#reactivate-receipt').attr('href', '{{ route("receipts.creditReceipt.reactivate", ":id") }}'.replace(':id', id));
            if(type=="proforma")
            $('#reactivate-receipt').attr('href', '{{ route("receipts.proformas.reactivate", ":id") }}'.replace(':id', id));
        }

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
    <script src="/js/customer/receipt/template_select_receipt.js"></script>
    <script src="/js/customer/receipt/template_select_tax.js"></script>
    <script src="/js/customer/receipt/template_select_cash_account.js"></script>

    <script src="/js/customer/receipt/select_customer_receipt.js"></script>
    <script src="/js/customer/receipt/select_customer_proforma.js"></script>
    <script src="/js/customer/receipt/select_customer_advancerevenue.js"></script>
    <script src="/js/customer/receipt/select_customer_creditreceipt_updated.js"></script>

    <script src="/js/customer/receipt/template_select_item.js"></script>
    <script src="/js/customer/receipt/select_item_receipt.js"></script>
    <script src="/js/customer/receipt/select_item_proforma.js"></script>
    <script src="/js/customer/receipt/select_receipt_creditreceipt.js"></script>

    <script src="/js/customer/receipt/template_select_proforma.js"></script>
    <script src="/js/customer/receipt/select_proforma_receipt.js"></script>

    <script src="/js/customer/receipt/modal_sales.js"></script>
    <script src="/js/customer/receipt/modal_receipt.js"></script>
    <script src="/js/customer/receipt/default_values.js"></script>
@endsection
