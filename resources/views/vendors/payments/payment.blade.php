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
            <ul class="nav nav-tabs d-flex" id="myTab" role="tablist">
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
                <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Reference#</th>
                            <th>Date</th>
                            <th>Paid to</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($billPayments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>
                                <td>{{ $payment->date }}</td>
                                <td>{{ $payment->name }}</td>
                                <td>{{ $payment->amount_paid }}</td>
                                <td>
                                    <!-- edit -->
                                    <a class="btn btn-primary btn-sm edit disabled">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                    </a>
                                    <!-- send email -->
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <span class="icon text-white-50">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                    </button>
                                    <!-- print/pdf -->
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <span class="icon text-white-50">
                                            <i class="fas fa-print"></i>
                                        </span>
                                    </button>
                                    <!-- void -->
                                    <button class="btn btn-danger btn-sm" disabled>
                                        <span class="icon text-white-50">
                                            <i class="fas fa-ban"></i>
                                        </span>
                                    </button>
                                    <!-- make it active -->
                                    <button class="btn btn-success btn-sm" disabled>
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!--Other Payment content--->
            <div class="table-responsive tab-pane fade other_payment">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTables2" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Paid To</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($otherPayments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>{{ $payment->date }}</td>
                                    <td>
                                        @if($payment->type == 'payroll_payment')
                                            {{ "For Period # " . $payment->pp_period_number . " (" . $payment->pp_date_from . " - " . $payment->pp_date_to . ")" }}
                                        @elseif($payment->type == 'income_tax_payment')
                                            {{ "For Period # " . $payment->itp_period_number . " (" . $payment->itp_date_from . " - " . $payment->itp_date_to . ")" }}
                                        @elseif($payment->type == 'withholding_payment')
                                            {{ "For Period # " . $payment->wp_period_number . " (" . $payment->wp_date_from . " - " . $payment->wp_date_to . ")" }}
                                        @else
                                            {{ $payment->name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($payment->type == 'vat_payment')
                                            <span class="badge badge-info">VAT Payment</span>
                                        @elseif($payment->type == 'withholding_payment')
                                            <span class="badge badge-warning">Withholding Payment</span>
                                        @elseif($payment->type == 'payroll_payment')
                                            <span class="badge badge-success">Payroll Payment</span>
                                        @elseif($payment->type == 'income_tax_payment')
                                            <span class="badge badge-danger">Income Tax Payment</span>
                                        @elseif($payment->type == 'pension_payment')
                                            <span class="badge badge-primary">Pension Payment</span>
                                        {{-- @elseif($payment->type == 'commission_payment') --}}
                                            {{-- <span class="badge badge-secondary">Commission Payment</span> --}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($payment->status == 'unpaid')
                                            <span class="badge badge-danger">Unpaid</span>
                                        @elseif($payment->status == 'partially_paid')
                                            <span class="badge badge-warning">Partially Paid</span>
                                        @elseif($payment->status == 'paid')
                                            <span class="badge badge-success">Paid</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if($payment->type == 'vat_payment')
                                            {{ number_format($payment->vat_amount, 2) }}
                                        @elseif($payment->type == 'withholding_payment')
                                            {{ number_format($payment->withholding_amount, 2) }}
                                        @elseif($payment->type == 'payroll_payment')
                                            {{ number_format($payment->payroll_amount, 2) }}
                                        @elseif($payment->type == 'income_tax_payment')
                                            {{ number_format($payment->income_tax_amount, 2) }}
                                        @elseif($payment->type == 'pension_payment')
                                            {{ number_format($payment->pension_amount, 2) }}
                                        {{-- @elseif($payment->type == 'commission_payment') --}}
                                            {{-- {{ number_format($payment->commission_amount) }} --}}
                                        @endif
                                    </td>
                                    <td>
                                        <!-- edit -->
                                        <a class="btn btn-primary btn-sm edit disabled">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </a>
                                        <!-- send email -->
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <span class="icon text-white-50">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                        </button>
                                        <!-- print/pdf -->
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <span class="icon text-white-50">
                                                <i class="fas fa-print"></i>
                                            </span>
                                        </button>
                                        <!-- void -->
                                        <button class="btn btn-danger btn-sm" disabled>
                                            <span class="icon text-white-50">
                                                <i class="fas fa-ban"></i>
                                            </span>
                                        </button>
                                        <!-- make it active -->
                                        <button class="btn btn-success btn-sm" disabled>
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
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

<script>
    var controller;
    $(document).ready(function () {
        $('#dataTables').DataTable();
        $('#dataTables2').DataTable();
        $('.dataTables_filter').addClass('pull-right');
    });
</script>

<!-- Vendors -->
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
