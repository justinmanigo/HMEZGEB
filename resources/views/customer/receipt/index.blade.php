@extends('template.index')

@section('content')

    <div class="row">

        {{-- Main Content Section --}}
        <div class="col-12">
            <div class="d-flex justify-content-between mb-3">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">New Receipt</span>
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
                <div class="mt-2 mb-0 pb-0">
                    <h5 class="pb-0 mb-0">
                        Account Receivable:
                        <span class="badge badge-warning pb-1">Active: {{$count}}</span>
                        <span class="badge badge-warning mr-2 pb-1">{{number_format($total_balance,2)}}</span>
                        <span class="badge badge-danger pb-1">Overdue: {{$count_overdue}}</span>
                        <span class="badge badge-danger pb-1">{{number_format($total_balance_overdue,2)}}</span>
                    </h5>
                </div>
            </div>

            {{-- Tab Contents --}}
            <div class="card" class="content-card">
                <div class="card-body tab-content" id="myTabContent">

                    {{-- Tab Navigation --}}
                    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
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
                    </ul>

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

    <script src="/js/hoverable.js"></script>
    <script src="/js/customer/receipt/receipt/receipts_table.js"></script>
    <script src="/js/customer/receipt/receipt/sales_table.js"></script>
    <script src="/js/customer/receipt/receipt/credit_receipts_table.js"></script>
    <script src="/js/customer/receipt/receipt/proformas_table.js"></script>
    <script src="/js/customer/receipt/receipt/table_actions.js"></script>

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
@endsection
