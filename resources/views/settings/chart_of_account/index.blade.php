@extends('template.index')

@push('styles')
    <style>
        .content-card {
            border-radius:0px 0px 5px 5px;
        }
    </style>
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
            <button id="btn-modal-beginning-balance" role="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-beginning-balance">
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
                {{-- success error --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(isset($_GET['success']))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $_GET['success'] }}
                    {{-- {{ session()->get('success') }} --}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
                {{-- Transaction Contents --}}
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
                                    <td class="table-item-content">{{ $coa->account_name }}</td>
                                    <td class="table-item-content">{{ $coa->type }}</td>
                                    <td class="table-item-content">{{ $coa->category }}</td>
                                    <td class="table-item-content text-right">
                                        @if($coa->normal_balance == 'Debit')
                                            <span class="@if($coa->balance_if_debit < 0) text-danger @else text-success @endif">
                                                {{ number_format($coa->balance_if_debit, 2) }}
                                            </span>
                                        @elseif($coa->normal_balance == 'Credit')
                                        <span class="@if($coa->balance_if_credit < 0) text-danger @else text-success @endif">
                                            {{ number_format($coa->balance_if_credit, 2) }}
                                        </span>
                                        @endif
                                    </td>
                                    <td class="table-item-content h6">
                                        @if($coa->status == 'Active')
                                            <span class="badge badge-success">{{ $coa->status }}</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $coa->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-icon btn-primary" data-toggle="tooltip" data-placement="bottom" title="Edit" disabled>
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete" disabled>
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
                        <label for="coa_number" class="col-sm-3 col-lg-2 col-form-label">Chart of Account Number<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <input type="text" class="form-control" id="coa_number" name="coa_number" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="coa_category" class="col-sm-3 col-lg-2 col-form-label">Category<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            {{-- <input type="text" class="form-control" id="coa_category" name="coa_category"> --}}
                            <input id="coa_category" name='coa_category' class="form-control" required>
                            <div class="form-check mr-3 mt-1">
                                <input class="form-check-input" id="coa_is_bank" type="checkbox" value="yes" name="coa_is_bank" disabled>
                                <label class="form-check-label" for="coa_is_bank">Is this a Bank account?</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="coa_name" class="col-sm-3 col-lg-2 col-form-label">Account Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <input type="text" class="form-control" id="coa_name" name="account_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="coa_bank_account_number" class="col-sm-3 col-lg-2 col-form-label">Bank Account Number<span class="text-danger coa_bank ml-1" style="display:none">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <input type="text" class="form-control" id="coa_bank_account_number" name="bank_account_number" required disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="coa_bank_branch" class="col-sm-3 col-lg-2 col-form-label">Bank Branch<span class="text-danger coa_bank ml-1" style="display:none">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <input type="text" class="form-control" id="coa_bank_branch" name="bank_branch" required disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="coa_bank_account_type" class="col-sm-3 col-lg-2 col-form-label">Bank Account Type<span class="text-danger coa_bank ml-1" style="display:none">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <select class="form-control" id="coa_bank_account_type" name="bank_account_type" required disabled>
                                <option value='' selected disabled hidden>Choose Bank Account Type</option>
                                <option value="savings">Savings Account</option>
                                <option value="checking">Checking Account</option>
                            </select>
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

{{-- Beginning Balance --}}
<div class="modal fade" id="modal-beginning-balance" tabindex="-1" role="dialog" aria-labelledby="modal-beginning-balance-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-beginning-balance-label">Configure Beginning Balance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-beginning-balance-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form class="ajax-submit-updated" id="form-beginning-balance" method="post" action="{{ url('/ajax/settings/coa/beginning-balance') }}" style="display:none" data-message="Successfully updated Beginning Balance.">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <th>Account #</th>
                                <th>Account Name</th>
                                <th>Category</th>
                                <th>Debit</th>
                                <th>Credit</th>
                            </thead>
                            <thead>
                                <th colspan="5">Debits</th>
                            </thead>
                            <tbody id="bb_debit"></tbody>
                            <thead>
                                <th colspan="5">Credits</th>
                            </thead>
                            <tbody id="bb_credit"></tbody>
                            <tfoot>
                                <th colspan="3" class="pt-2">Total</th>
                                <th>
                                    <p id="bb_debit_total" class="text-right pr-2 pt-2">0.00</p>
                                </th>
                                <th>
                                    <p id="bb_credit_total" class="text-right pr-2 pt-2">0.00</p>
                                </th>
                            </tfoot>
                        </table>
                        <p class="text-danger error-message error-message-sum text-right" style="display:none"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="close-form-beginning-balance" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="submit-form-beginning-balance" type="submit" class="btn btn-primary" form="form-beginning-balance" disabled='true'>Save Beginning Balance</button>
            </div>
        </div>
    </div>
</div>


{{-- Import Modal --}}
<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="Modal Import Chart Of Account">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-customer-label">Import Chart Of Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-import-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form-import" method="post" action="{{ route('settings.coa.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row container">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" name="file" required>
                            <label class="custom-file-label" for="file">Choose file</label>
                          </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="i_submit_btn" form="form-import">Import Chart Of Account</button>
            </div>
        </div>
    </div>
</div>

{{-- Export Modal CSV or PDF--}}

<div class="modal fade" id="modal-export" tabindex="-1" role="dialog" aria-labelledby="Modal Export Chart Of Account">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-customer-label">Export Chart Of Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-export-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form-export" method="post" action="{{ route('settings.coa.export') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="e_type" class="col-12 col-lg-6 col-form-label">Type<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <select class="form-control" id="e_type" name="type" required>
                                <option value="csv">CSV</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="e_submit_btn" form="form-export">Export Chart Of Account</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#dataTables').DataTable();
        $('.dataTables_filter').addClass('pull-right');
    });

    // add the file name only in file input field
    $('.custom-file-input').on('change', function() {
    var fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>

<script src="/js/settings/chart_of_accounts/template_select_coa_category.js"></script>
<script src="/js/settings/chart_of_accounts/select_coa_category.js"></script>

<script>
    $("#btn-modal-beginning-balance").click(function(){
        $("#modal-beginning-balance-spinner").show();
        $("#form-beginning-balance").hide();
        $("#bb_debit").html("");
        $("#bb_credit").html("");
        $("#bb_debit_total").html("0.00");
        $("#bb_credit_total").html("0.00");

        // Get data from server.
        var request = $.ajax({
            url: `/ajax/settings/coa/beginning-balance`,
            method: "GET",
        });

        request.done(function(res, status, jqXHR ) {
            $("#form-beginning-balance").show();
            $("#modal-beginning-balance-spinner").hide();
            $("#submit-form-beginning-balance").removeAttr("disabled");

            console.log("Request successful.");
            console.log(res);

            var sum_debits = 0.00;
            var sum_credits = 0.00;

            res.debits.forEach(function(d){
                createBeginningBalanceRow(d, 'debit');
                sum_debits += parseFloat(d.amount);
            });

            res.credits.forEach(function(c){
                createBeginningBalanceRow(c, 'credit');
                sum_credits += parseFloat(c.amount);
            });

            $("#bb_debit_total").html(sum_debits.toFixed(2));
            $("#bb_credit_total").html(sum_credits.toFixed(2));
        });

        request.fail(function(jqXHR, status, error) {
            console.log("Request failed.");
        });
    });

    function createBeginningBalanceRow(coa, type)
    {
        amount = parseFloat(coa.amount).toFixed(2);

        let inner = `
            <tr>
                <td>
                    <input name="${ type=='debit' ? 'debit' : 'credit' }_coa_id[]" class="form-control-plaintext" type="text" value="${coa.id}" hidden readonly>
                    ${coa.chart_of_account_no}
                </td>
                <td>${coa.account_name}</td>
                <td>${coa.category}</td>
                <td>
                    ${type == 'debit'
                        ? `<input name="debit_amount[]" class="bb_debit_amount form-control form-control-sm inputPrice text-right" type="number" step="0.01" min="0" placeholder="0.00" value="${amount}" required>`
                        : ''
                    }
                </td>
                <td>
                    ${type == 'credit'
                        ? `<input name="credit_amount[]" class="bb_credit_amount form-control form-control-sm inputPrice text-right" type="number" step="0.01" min="0" placeholder="0.00" value="${amount}" required>`
                        : ''
                    }
                </td>
            </tr>
        `;

        if(type == 'debit') {
            $("#bb_debit").append(inner);
        }
        else if(type == 'credit') {
            $("#bb_credit").append(inner);
        }
    }

    $(document).on('change', '.bb_debit_amount', function(event){
        calculateTotalBeginningBalance('bb_debit_total', 'bb_debit');
    });

    $(document).on('change', '.bb_credit_amount', function(event){
        calculateTotalBeginningBalance('bb_credit_total', 'bb_credit');
    });

    function calculateTotalBeginningBalance(id, table)
    {
        let total = 0;
        $(`#${table}`).find(`.${table}_amount`).each(function(){
            total += parseFloat($(this).val());
        });

        $(`#${id}`).html(total.toFixed(2));
    }
</script>
@endsection
