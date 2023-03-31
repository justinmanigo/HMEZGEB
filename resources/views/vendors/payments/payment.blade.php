@extends('template.index')

@section('content')

<div>
    {{-- btn groups --}}
        <div class="btn-group mb-3" role="group">
            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">New Payment</span>
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <a role="button" class="dropdown-item" data-toggle="modal" data-target=".bill-payment-modal">Bill</a>
                <a role="button" class="dropdown-item disabled" data-toggle="modal" {{-- data-target=".VAT-payment-modal" --}}>VAT <span class="badge badge-danger">Soon</span></a>
                <a role="button" class="dropdown-item" data-toggle="modal"
                    data-target="#modal-withholding-payment">Withholding <span class="badge badge-success">New</span></a>
                <a role="button" class="dropdown-item" data-toggle="modal"
                    data-target="#modal-payroll-payment">Payroll <span class="badge badge-success">New</span></a>
                <a role="button" class="dropdown-item" data-toggle="modal"
                    data-target="#modal-income-tax-payment">Income Tax <span class="badge badge-success">New</span></a>
                <a role="button" class="dropdown-item disabled" data-toggle="modal"
                    {{-- data-target=".pension-payment-modal" --}}>Pension <span class="badge badge-danger">Soon</span></a>
                <a role="button" class="dropdown-item disabled" data-toggle="modal"
                    {{-- data-target=".commission-payment-modal" --}}>Commision <span class="badge badge-danger">Soon</span></a>
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
        </div>

    {{-- Modals --}}

    {{-- BillPayment --}}
    @include('vendors.payments.modals.types.bill_payment')
    @include('vendors.payments.modals.types.withholding_payment')
    @include('vendors.payments.modals.types.income_tax_payment')

    {{-- VAT --}}
    <div class="modal fade VAT-payment-modal" id="modal-vat-payment" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center">
                        <img class="mr-5"
                            src="https://user-images.githubusercontent.com/75387615/156304203-f98fe8db-d7a4-409f-a83c-8221c88e6e80.jpg">
                        <p class="h3 pl-4 m-auto">New VAT Payment</p>
                        <a class="close" data-dismiss="modal">×</a>
                    </div>
                    <form id="contactForm" action="" method="post" role="form">
                        Coming Soon.
                        {{-- @include('vendors.payments.forms.VATPaymentModal') --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <input type="submit" class="btn btn-primary" id="submit"> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Payroll --}}
    <div class="modal fade payroll-payment-modal" id="modal-payroll-payment" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center">
                        <img class="mr-5"
                            src="https://user-images.githubusercontent.com/75387615/156304203-f98fe8db-d7a4-409f-a83c-8221c88e6e80.jpg">
                        <p class="h3 pl-4 m-auto">New Payroll Payment</p>
                        <a class="close" data-dismiss="modal">×</a>
                    </div>
                    <form class="ajax-submit-updated" id="form-payroll-payment" name="contact" role="form" action="{{ url('/payment/payroll') }}" method="POST" data-message="Succesfully saved payroll payment.">
                        @csrf
                        @include('vendors.payments.forms.payrollPaymentModal')
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" form="form-payroll-payment">Save & Close</button>
                            <button type="submit" class="btn btn-primary" form="form-payroll-payment" data-new="modal-payroll-payment">Save & New</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Pension --}}
    <div class="modal fade pension-payment-modal" id="modal-pension-payment" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center">
                        <img class="mr-5"
                            src="https://user-images.githubusercontent.com/75387615/156304203-f98fe8db-d7a4-409f-a83c-8221c88e6e80.jpg">
                        <p class="h3 pl-4 m-auto">New Pension Payment</p>
                        <a class="close" data-dismiss="modal">×</a>
                    </div>
                    <form action="{{route('payments.pension.store')}}" method="post" id="contactForm" name="contact"
                        role="form">
                        @csrf
                        Coming Soon.
                        {{-- @include('vendors.payments.forms.pensionPaymentModal') --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <input type="submit" class="btn btn-primary" id="submit"> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Commission --}}
    <div class="modal fade commission-payment-modal" id="modal-commission-payment" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center">
                        <img class="mr-5"
                            src="https://user-images.githubusercontent.com/75387615/156304203-f98fe8db-d7a4-409f-a83c-8221c88e6e80.jpg">
                        <p class="h3 pl-4 m-auto">New Commission Payment</p>
                        <a class="close" data-dismiss="modal">×</a>
                    </div>
                    <form id="contactForm" name="contact" role="form">
                        Coming Soon.
                        {{-- @include('vendors.payments.forms.commissionPaymentModal') --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <input type="submit" class="btn btn-primary" id="submit"> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Tab Contents --}}
    <div class="card">
        <div class="card-body tab-content">
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

            {{-- Tab Navigation --}}
            <ul class="nav nav-tabs d-flex mb-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="bill_payment-tab" data-toggle="tab" href=".bill_payment" role="tab"
                        aria-controls="bill-payment" aria-selected="true">Bill Payment</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="other_payment-tab" data-toggle="tab" href=".other_payment" role="tab"
                        aria-controls="other-payment" aria-selected="false">Other Payment</a>
                </li>
            </ul>

            <!--Bill Payment content--->
            <div class="table-responsive tab-pane fade show active bill_payment">
                <!-- add search input group -->
                <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                    <form id="bill-payments-search-form">
                        <div class="input-group mr-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="search-addon"><i class="fas fa-search"></i></span>
                            </div>
                            <input id="bill-payments-search-input" type="text" class="form-control" placeholder="Search" aria-label="Search"
                                aria-describedby="search-addon">
                            <button id="bill-payments-search-submit" type="submit" class="btn btn-primary" disabled style="border-radius:0px 5px 5px 0px">
                                <span class="icon text-white-50">
                                    <i class="fas fa-search"></i>
                                </span>
                                <span class="text">Submit</span>
                            </button>
                        </div>
                    </form>
                    <div class="btn-group" role="group" aria-label="Second group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="bill-payments-page-number-label">Page 0 of 0</span>
                        </div>
                        <button id="bill-payments-prev" type="button" class="btn btn-secondary" disabled=true>Prev</button>
                        <button id="bill-payments-next" type="button" class="btn btn-secondary" disabled=true>Next</button>
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
                        <tbody id="bill-payments-list">
                            <!-- JS will populate this -->
                        </tbody>
                    </table>
                </div>
            </div>
            <!--Other Payment content--->
            <div class="table-responsive tab-pane fade other_payment">
                <!-- add search input group -->
                <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                    <form id="other-payments-search-form">
                        <div class="input-group mr-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="search-addon"><i class="fas fa-search"></i></span>
                            </div>
                            <input id="other-payments-search-input" type="text" class="form-control" placeholder="Search" aria-label="Search"
                                aria-describedby="search-addon">
                            <button id="other-payments-search-submit" type="submit" class="btn btn-primary" disabled style="border-radius:0px 5px 5px 0px">
                                <span class="icon text-white-50">
                                    <i class="fas fa-search"></i>
                                </span>
                                <span class="text">Submit</span>
                            </button>
                        </div>
                    </form>
                    <div class="btn-group" role="group" aria-label="Second group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="other-payments-page-number-label">Page 0 of 0</span>
                        </div>
                        <button id="other-payments-prev" type="button" class="btn btn-secondary" disabled=true>Prev</button>
                        <button id="other-payments-next" type="button" class="btn btn-secondary" disabled=true>Next</button>
                    </div>
                </div>

                {{-- Transaction Contents --}}
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th width="160px">Actions</th>
                        </thead>
                        <tbody id="other-payments-list">
                            <!-- JS will populate this -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var controller;
    $(document).ready(function () {
        $('#dataTables').DataTable();
        $('#dataTables2').DataTable();
        $('.dataTables_filter').addClass('pull-right');
    });
</script>

<!-- Vendors -->
<script src="/js/hoverable.js"></script>
<script src="/js/vendors/payment/bill_payments_table.js"></script>
<script src="/js/vendors/payment/other_payments_table.js"></script>
<script src="/js/vendors/payment/table_actions.js"></script>

<script src="/js/tagify_templates/template_select_cash_account.js"></script>
<script src="/js/vendors/template_select_payroll_period.js"></script>
<script src="/js/tagify_templates/template_select_bill.js"></script>
<script src="/js/human_resource/template_select_employee.js"></script>
<script src="/js/vendors/template_select_vendor.js"></script>

<script src="/js/vendors/payment/modal_bill_payment.js"></script>
<script src="/js/vendors/payment/modal_withholding_payment.js"></script>
<script src="/js/vendors/payment/modal_payroll_payment.js"></script>
<script src="/js/vendors/payment/modal_income_tax_payment.js"></script>

<script src="/js/vendors/payment/default_values.js"></script>
<script src="/js/vendors/payment/select_vendor_billpayment_updated.js"></script>
<script src="/js/vendors/payment/select_vendor_payroll.js"></script>
<script src="/js/vendors/payment/select_vendor_vat.js"></script>
<script src="/js/vendors/payment/select_vendor_withholding.js"></script>
<script src="/js/vendors/payment/select_vendor_pension.js"></script>
<script src="/js/vendors/payment/select_vendor_income_tax.js"></script>
<!-- Employee -->
<script src="/js/vendors/payment/select_employee_commission.js"></script>

<!-- Select bill -->
<script src="/js/vendors/payment/select_payment_bill.js"></script>
<script src="/js/vendors/payment/select_payment_withholding.js"></script>


<!-- Items -->
<script src="/js/vendors/template_select_item.js"></script>

@endsection
