@extends('template.index')

@section('content')
{{-- Button Group Navigation --}}
<div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
    <button role="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-deposit" id="modal-deposit-button">
        <span class="icon text-white-50">
            <i class="fas fa-pen"></i>
        </span>
        <span class="text">New</span>
    </button>
</div>

{{-- Page Content --}}
<div class="card">
    <div class="card-body">
        {{-- successs message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                <thead>
                    <th>Deposit Date</th>
                    <th>Deposit ID</th>
                    <th>Account</th>
                    <th>Label</th>
                    <th>Amount</th>
                    <th id="thead-actions">Actions</th>

                </thead>
                <tbody >
                    @foreach($deposits as $deposit)
                        <tr>
                            {{-- date format --}}
                            <td>{{ date('Y-m-d', strtotime($deposit->deposit_ticket_date)) }}</td>
                            <td>{{$deposit->id}}</td>
                            <td>{{$deposit->chartOfAccount->account_name}}</td>
                            <td><span class="badge badge-primary">Self</span></td>
                            <td>Birr {{ number_format($deposit->total_amount, 2) }}</td>
                            <td>
                                {{-- <a role="button" class="btn btn-sm btn-icon btn-primary mb-1 disabled">
                                    <!-- edit -->
                                    <span class="icon text-white-50">
                                        <i class="fas fa-pen"></i>
                                    </span>
                                </a> --}}
                                <button class="btn btn-sm btn-icon btn-secondary mb-1" data-toggle="modal" data-target="#modal-mail-confirmation" onclick="mailModal({{$deposit->id}})">
                                    <!-- email -->
                                    <span class="icon text-white-50">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                </button>
                                <button class="btn btn-sm btn-icon btn-secondary mb-1"  data-toggle="modal" data-target="#modal-print-confirmation" onclick="printModal({{$deposit->id}})">
                                    <!-- print -->
                                    <span class="icon text-white-50">
                                        <i class="fas fa-print"></i>
                                    </span>
                                </button>
                                <button class="btn btn-sm btn-icon btn-danger mb-1" disabled>
                                    <!-- void -->
                                    <span class="icon text-white-50">
                                        <i class="fas fa-ban"></i>
                                    </span>
                                </button>
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

{{-- Modals --}}
{{-- New Deposit --}}
<div class="modal fade" id="modal-deposit" tabindex="-1" role="dialog" aria-labelledby="modal-deposit-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-deposit-label">New Deposit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-deposit" class="ajax-submit-updated" method="post" enctype="multipart/form-data" action="{{route('deposits.deposits.store')}}" data-message="Successfully deposited receipts.">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group row">
                                <label for="d_bank_account" class="col-4 col-form-label">Select Bank Acct.<span class="text-danger ml-1">*</span></label>
                                <div class="col-sm-8">
                                    <input id="d_bank_account" class="form-control" name='bank_account'>
                                    <p class="text-danger error-message error-message-bank_account" style="display:none"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group row">
                                <label for="d_deposit_date" class="col-4 col-form-label">Deposit Ticket Date<span class="text-danger ml-1">*</span></label>
                                <div class="col-8">
                                    <input type="date" class="form-control" id="d_deposit_ticket_date" name="deposit_ticket_date" value="{{date('Y-m-d')}}"  required>
                                    <p class="text-danger error-message error-message-deposit_ticket_date" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="d_reference_number" class="col-4 col-form-label">Reference Number</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="d_reference_number" name="reference_number">
                                    <p class="text-danger error-message error-message-reference_number" style="display:none"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h2>Undeposited Sales</h2>
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Payment Method</th>
                                <th>Cheque/Reference #</th>
                                <th>Amount</th>
                                <th id="thead-actions">Deposit?</th>
                            </thead>
                            <tbody id="deposit-list">
                                {{-- customer_deposit --}}
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <tfoot>
                                <th class="text-center">
                                    Total Cash<br>
                                        <input type="text" class="form-control-plaintext text-center" id="d_total_cash" value="Birr 0.00" disabled>
                                </th>
                                <th class="text-center">
                                    Total Cheque<br>
                                    <input type="text" class="form-control-plaintext text-center" id="d_total_cheque" value="Birr 0.00" disabled>
                                </th>
                                <th class="text-center">
                                    Total Other<br>
                                    <input type="text" class="form-control-plaintext text-center" id="d_total_other" value="Birr 0.00" disabled>
                                </th>
                                <th class="text-center">
                                    Total Deposit<br>
                                    <input type="text" class="form-control-plaintext text-center" id="d_total_deposit" name="total_amount" value="Birr 0.00" readonly>
                                </th>
                            </tfoot>
                        </table>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="d_remark" class="col-sm-3 col-form-label">Remark</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="d_remark" name="remark"></textarea>
                                    <p class="text-danger error-message error-message-remark error-message-is_deposited" style="display:none"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-deposit">Save Deposit</button>
            </div>
        </div>
    </div>
</div>

{{-- confirmation mail modal --}}

<div class="modal fade" id="modal-mail-confirmation" tabindex="-1" role="dialog" aria-labelledby="modal-mail-confirmation-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-mail-confirmation-label">Confirm Mail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to send this deposit receipt to customer?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="" class="btn btn-primary" id="btn-send-mail">Send</a>
            </div>
        </div>
    </div>
</div>

{{-- Print confirmation Modal --}}
<div class="modal fade" id="modal-print-confirmation" tabindex="-1" role="dialog" aria-labelledby="modal-print-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-print-label">Confirm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to print deposit?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="" id="print-deposit" class="btn btn-primary">Print</a>
            </div>
        </div>
    </div>
</div>

<script>
        // Get id of transaction to mail confirmation modal
        function mailModal(id){
        // set attribute href of btn-send-mail
            $('#btn-send-mail').attr('href', '{{ route("deposits.deposit.mail", ":id") }}'.replace(':id', id));
        }

        // Get id of transaction to print confirmation modal
        function printModal(id){
        // set attribute href of print-deposit
            $('#print-deposit').attr('href', '{{ route("deposits.deposit.print", ":id") }}'.replace(':id', id));
        }


        $(document).ready(function () {
            $('#dataTables').DataTable();
            $('#dataTables2').DataTable();
            $('.dataTables_filter').addClass('pull-right');
        });
</script>
<script src="{{ asset('js/customer/deposit/template_select_bank.js') }}"></script>
<script src="{{ asset('js/customer/deposit/customer_deposit.js') }}"></script>
@endsection
