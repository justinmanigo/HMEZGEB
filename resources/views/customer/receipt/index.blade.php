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

            {{-- Tab Navigation --}}
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="receipts-tab" data-toggle="tab" href="#sales" role="tab"
                        aria-controls="receipts" aria-selected="true">Sales</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="receipts-tab" data-toggle="tab" href="#receipts" role="tab"
                        aria-controls="receipts" aria-selected="true">Receipts</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link disabled" id="receipts-tab" data-toggle="tab" href="#advance-revenues" role="tab"
                        aria-controls="receipts" aria-selected="true">Advance Revenues <span class="badge badge-danger">Soon</span></a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="receipts-tab" data-toggle="tab" href="#credit-receipts" role="tab"
                        aria-controls="receipts" aria-selected="true">Credit Receipts</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="proforma-tab" data-toggle="tab" href="#proformas" role="tab"
                        aria-controls="proforma" aria-selected="false">Proforma</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-muted" id="transactions-tab" data-toggle="tab" href="#transactions" role="tab"
                        aria-controls="transactions" aria-selected="true">Transactions</a>
                </li>
            </ul>

            {{-- Tab Contents --}}
            <div class="card" class="content-card">
                <div class="card-body tab-content" id="myTabContent">

                    {{-- Sales Contents --}}
                    <div class="tab-pane fade show" id="sales" role="tabpanel" aria-labelledby="sales-tab">
                        <!-- add search input group -->
                        <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                            <form id="sales-search-form">
                                <div class="input-group mr-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="search-addon"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input id="sales-search-input" type="text" class="form-control" placeholder="Search" aria-label="Search"
                                        aria-describedby="search-addon">
                                    <button id="sales-search-submit" type="submit" class="btn btn-primary" disabled style="border-radius:0px 5px 5px 0px">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <span class="text">Submit</span>
                                    </button>
                                </div>
                            </form>
                            <div class="btn-group" role="group" aria-label="Second group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="sales-page-number-label">Page 0 of 0</span>
                                </div>
                                <button id="sales-prev" type="button" class="btn btn-secondary" disabled=true>Prev</button>
                                <button id="sales-next" type="button" class="btn btn-secondary" disabled=true>Next</button>
                            </div>
                        </div>

                        {{-- Transaction Contents --}}
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th width="160px">Actions</th>
                                </thead>
                                <tbody id="sales-list">
                                    <!-- JS will populate this -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Receipts Contents --}}
                    <div class="tab-pane active fade show" id="receipts" role="tabpanel" aria-labelledby="receipts-tab">
                        <!-- add search input group -->
                        <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                            <form id="receipts-search-form">
                                <div class="input-group mr-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="search-addon"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input id="receipts-search-input" type="text" class="form-control" placeholder="Search" aria-label="Search"
                                        aria-describedby="search-addon">
                                    <button id="receipts-search-submit" type="submit" class="btn btn-primary" disabled style="border-radius:0px 5px 5px 0px">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <span class="text">Submit</span>
                                    </button>
                                </div>
                            </form>
                            <div class="btn-group" role="group" aria-label="Second group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="receipts-page-number-label">Page 0 of 0</span>
                                </div>
                                <button id="receipts-prev" type="button" class="btn btn-secondary" disabled=true>Prev</button>
                                <button id="receipts-next" type="button" class="btn btn-secondary" disabled=true>Next</button>
                            </div>
                        </div>

                        {{-- Transaction Contents --}}
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th width="160px">Actions</th>
                                </thead>
                                <tbody id="receipts-list">
                                    <!-- JS will populate this -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Credit Receipt Contents --}}
                    <div class="tab-pane fade show" id="credit-receipts" role="tabpanel" aria-labelledby="credit-receipts-tab">
                        <!-- add search input group -->
                        <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                            <form id="credit-receipts-search-form">
                                <div class="input-group mr-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="search-addon"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input id="credit-receipts-search-input" type="text" class="form-control" placeholder="Search" aria-label="Search"
                                        aria-describedby="search-addon">
                                    <button id="credit-receipts-search-submit" type="submit" class="btn btn-primary" disabled style="border-radius:0px 5px 5px 0px">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <span class="text">Submit</span>
                                    </button>
                                </div>
                            </form>
                            <div class="btn-group" role="group" aria-label="Second group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="credit-receipts-page-number-label">Page 0 of 0</span>
                                </div>
                                <button id="credit-receipts-prev" type="button" class="btn btn-secondary" disabled=true>Prev</button>
                                <button id="credit-receipts-next" type="button" class="btn btn-secondary" disabled=true>Next</button>
                            </div>
                        </div>

                        {{-- Transaction Contents --}}
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th width="160px">Actions</th>
                                </thead>
                                <tbody id="credit-receipts-list">
                                    <!-- JS will populate this -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Proforma Contents --}}
                    <div class="tab-pane fade show" id="proformas" role="tabpanel" aria-labelledby="proformas-tab">
                        <!-- add search input group -->
                        <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                            <form id="proformas-search-form">
                                <div class="input-group mr-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="search-addon"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input id="proformas-search-input" type="text" class="form-control" placeholder="Search" aria-label="Search"
                                        aria-describedby="search-addon">
                                    <button id="proformas-search-submit" type="submit" class="btn btn-primary" disabled style="border-radius:0px 5px 5px 0px">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <span class="text">Submit</span>
                                    </button>
                                </div>
                            </form>
                            <div class="btn-group" role="group" aria-label="Second group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="proformas-page-number-label">Page 0 of 0</span>
                                </div>
                                <button id="proformas-prev" type="button" class="btn btn-secondary" disabled=true>Prev</button>
                                <button id="proformas-next" type="button" class="btn btn-secondary" disabled=true>Next</button>
                            </div>
                        </div>

                        {{-- Transaction Contents --}}
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Due in</th>
                                    <th>Amount</th>
                                    <th width="160px">Actions</th>
                                </thead>
                                <tbody id="proformas-list">
                                    <!-- JS will populate this -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Deprecated --}}
                    <div class="tab-pane fade show" id="transactions" role="tabpanel"
                        aria-labelledby="transactions-tab">


                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                                <thead>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Description</th>
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
                                                <span>Receipt for <b>{{ $transaction->name }}</b></span>
                                            @elseif($transaction->type == 'advance_receipt')
                                                <span>Advance Revenue for <b>{{ $transaction->name }}</b></span>
                                            @elseif($transaction->type == 'credit_receipt')
                                                <span>Credit Receipt for <b>{{ $transaction->name }}</b></span>
                                            @elseif($transaction->type == 'sale')
                                                <span>Sale</span>
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
                                                @if(!$transaction->is_void)
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
                                                <a href="{{route('receipts.advance_revenues.show', $transaction->id)}}" class="btn btn-primary btn-sm edit ">
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
                                                @if(!$transaction->is_void)
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
                                                <a href="{{route('receipts.credit_receipts.show', $transaction->id)}}" class="btn btn-primary btn-sm edit">
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
                                                @if(!$transaction->is_void)
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
                                                @if(!$transaction->is_void)
                                                    <!-- void -->
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-void-confirmation" onclick="voidModal({{$transaction->id}}, 'sale')">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-ban"></i>
                                                        </span>
                                                    </button>
                                                @else
                                                    <!-- make it active -->
                                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-reactivate-confirmation" onclick="reactivateModal({{$transaction->id}}, 'sale')">
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
            $('#btn-send-mail').attr('href', '{{ route("receipts.receipts.mail", ":id") }}'.replace(':id', id)));
            if(type=="advanceRevenue")
            $('#btn-send-mail').attr('href', '{{ route("receipts.advance_revenues.mail", ":id") }}'.replace(':id', id));
            if(type=="creditReceipt")
            $('#btn-send-mail').attr('href', '{{ route("receipts.credit_receipts.mail", ":id") }}'.replace(':id', id));
            if(type=="proforma")
            $('#btn-send-mail').attr('href', '{{ route("receipts.proformas.mail", ":id") }}'.replace(':id', id));
        }

        // Get id of transaction to print confirmation modal
        function printModal(id, type){
            // set attribute href of print-receipt
            if(type=="receipt")
            $('#print-receipt').attr('href', '{{ route("receipts.receipts.print", ":id") }}'.replace(':id', id));
            if(type=="advanceRevenue")
            $('#print-receipt').attr('href', '{{ route("receipts.advance_revenues.print", ":id") }}'.replace(':id', id));
            if(type=="creditReceipt")
            $('#print-receipt').attr('href', '{{ route("receipts.credit_receipts.print", ":id") }}'.replace(':id', id));
            if(type=="proforma")
            $('#print-receipt').attr('href', '{{ route("receipts.proformas.print", ":id") }}'.replace(':id', id));
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

    <script src="/js/customer/receipt/receipt/receipts_table.js"></script>
    <script src="/js/customer/receipt/receipt/sales_table.js"></script>
    <script src="/js/customer/receipt/receipt/credit_receipts_table.js"></script>
    <script src="/js/customer/receipt/receipt/proformas_table.js"></script>

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
    <script src="/js/customer/receipt/modal_credit_receipt.js"></script>
    <script src="/js/customer/receipt/default_values.js"></script>

    <script>
        // Void record

        function voidModal(id, type) {
            if(type=="receipt")
            $('#void-receipt').attr('data-href', '{{ route("receipts.receipts.void", ":id") }}'.replace(':id', id));
            if(type=="advanceRevenue")
            $('#void-receipt').attr('data-href', '{{ route("receipts.advance_revenues.void", ":id") }}'.replace(':id', id));
            if(type=="creditReceipt")
            $('#void-receipt').attr('data-href', '{{ route("receipts.credit_receipts.void", ":id") }}'.replace(':id', id));
            if(type=="proforma")
            $('#void-receipt').attr('data-href', '{{ route("receipts.proformas.void", ":id") }}'.replace(':id', id));
            if(type=="sale")
            $('#void-receipt').attr('data-href', '{{ route("receipts.sales.void", ":id") }}'.replace(':id', id));

            $('#void-receipt').attr('data-id', id).attr('href', '#').attr('data-type', type);
        }

        function reactivateModal(id, type)
        {
            if(type=="receipt")
            $('#reactivate-receipt').attr('data-href', '{{ route("receipts.receipts.reactivate", ":id") }}'.replace(':id', id));
            if(type=="advanceRevenue")
            $('#reactivate-receipt').attr('data-href', '{{ route("receipts.advance_revenues.reactivate", ":id") }}'.replace(':id', id));
            if(type=="creditReceipt")
            $('#reactivate-receipt').attr('data-href', '{{ route("receipts.credit_receipts.reactivate", ":id") }}'.replace(':id', id));
            if(type=="proforma")
            $('#reactivate-receipt').attr('data-href', '{{ route("receipts.proformas.reactivate", ":id") }}'.replace(':id', id));
            if(type=="sale")
            $('#reactivate-receipt').attr('data-href', '{{ route("receipts.sales.reactivate", ":id") }}'.replace(':id', id));

            $('#reactivate-receipt').attr('data-id', id).attr('href', '#').attr('data-type', type);
        }

        $(document).on('click', '#void-receipt', function(e){
            e.preventDefault();

            var id = $(this).attr('data-id');
            var href = $(this).attr('data-href');

            // on success, close modal, then toggle void button
            $.ajax({
                url: href,
                type: 'GET',
                success: function(result) {
                    $('#modal-void-confirmation').modal('hide');
                    // get parent of #vr-receipt-id
                    let parent = $('#vr-receipt-'+id).parent();
                    $('#vr-receipt-'+id).remove();

                    // refer to receipts_table.js
                    parent.append(`
                    <button id="vr-receipt-${id}" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-reactivate-confirmation" data-type="receipt" data-id="${id}" data-action="reactivate" data-page="receipts")" >
                        <span class="icon text-white-50">
                            <i class="fas fa-check"></i>
                        </span>
                    </button>
                    `)

                    if($('#void-receipt').attr('data-type') == 'receipt') {
                        credit_receipt_search("", credit_receipts_page_number_current);
                    }
                    else if($('#void-receipt').attr('data-type') == 'creditReceipt'){
                        receipt_search("", credit_receipts_page_number_current);
                    }

                }
            });
        })

        $(document).on('click', '#reactivate-receipt', function(e){
            e.preventDefault();

            var id = $(this).attr('data-id');
            var href = $(this).attr('data-href');

            // on success, close modal, then toggle void button
            $.ajax({
                url: href,
                type: 'GET',
                success: function(result) {
                    $('#modal-reactivate-confirmation').modal('hide');
                    // get parent of #vr-receipt-id
                    let parent = $('#vr-receipt-'+id).parent();
                    $('#vr-receipt-'+id).remove();

                     // refer to receipts_table.js
                    parent.append(`
                    <button id="vr-receipt-${id}" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-void-confirmation")" data-type="receipt" data-id="${id}" data-action="void" data-page="receipts">
                        <span class="icon text-white-50">
                            <i class="fas fa-ban"></i>
                        </span>
                    </button>
                    `)

                    if($('#reactivate-receipt').attr('data-type') == 'receipt') {
                        credit_receipt_search("", credit_receipts_page_number_current);
                    }
                    else if($('#reactivate-receipt').attr('data-type') == 'creditReceipt'){
                        receipt_search("", credit_receipts_page_number_current);
                    }
                }
            });
        })
    </script>
@endsection
