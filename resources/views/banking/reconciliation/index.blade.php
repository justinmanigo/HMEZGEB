@extends('template.index')

@push('styles')
<style>
    .thead-actions {
        /** Fixed width, increase if adding addt. buttons **/
        width: 120px;
    }
</style>

<script src="https://unpkg.com/@yaireo/tagify"></script>
<script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <h1>Bank Reconciliation</h1>
    </div>
    <div class="row mb-4">
        <div class="card col-12 col-lg-6">
            <div class="card-body">
                <p>To proceed with the bank reconciliation process, kindly select a Bank Account and import its bank statement in the form below.</p>
                <form id="form-getting-started" action="" method="POST">
                    <div class="form-group">
                        <label for="bank-account">Bank Account</label>
                        <input class="form-control" id="gs_bank_account" name="bank_account">
                    </div>
                    <div class="form-group">
                        <label for="bank-statement">Bank Statement</label>
                        <input type="file" class="form-control-file" id="gs_bank_statement" name="bank_statement">
                    </div>
                    <button type="submit" class="btn btn-primary">Import</button>
                </form>
            </div>
        </div>        
    </div>
    <div class="row mb-4">
        <div class="card col-12">
            <div class="card-body">
                <h4 class="mb-0">Bank Account Name</h4>
                <p>Account Number</p>
                <p>Bank Reconcilation as of <strong>August 31, 2022</strong>
                <hr>
                <nav>
                    <div class="nav nav-pills" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-bank-statement-tab" data-toggle="tab" href="#nav-bank-statement" role="tab" aria-controls="nav-bank-statement" aria-selected="true">Bank Statement</a>
                        <a class="nav-item nav-link" id="nav-cash-book-tab" data-toggle="tab" href="#nav-cash-book" role="tab" aria-controls="nav-cash-book" aria-selected="false">Cash Book</a>
                        <a class="nav-item nav-link" id="nav-status-tab" data-toggle="tab" href="#nav-status" role="tab" aria-controls="nav-status" aria-selected="false">Status</a>
                        </div>
                    </nav>
                    <hr>
                    <div class="tab-content" id="nav-tabContent">
                        
                        <div class="tab-pane fade show active" id="nav-bank-statement" role="tabpanel" aria-labelledby="nav-bank-statement-tab">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                        <th>Actions</th>
                                        <th>OK?</th>
                                    </thead>
                                    <div class="tbody">
                                        <tr>
                                            <td>August 31, 2022</td>
                                            <td>Bank Statement</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>
                                                <button data-id="1" data-type="bank-statement" class="btn btn-sm btn-primary btn-correct-and-match" data-toggle="modal" data-target="#correctAndMatch">Correct and Match</button>
                                                <a href="#" class="btn btn-sm btn-info">Create Transaction</a>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-success">OK</a>
                                            </td>
                                        </tr>
                                    </div>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-cash-book" role="tabpanel" aria-labelledby="nav-cash-book-tab">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                        <th>Actions</th>
                                        <th>OK?</th>
                                    </thead>
                                    <div class="tbody">
                                        <tr>
                                            <td>August 31, 2022</td>
                                            <td>Bank Statement</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-primary">Correct and Match</a>
                                                <a href="#" class="btn btn-sm btn-info">Create Transaction</a>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-success">OK</a>
                                            </td>
                                        </tr>
                                    </div>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-status" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                                <th>Bank Statement</th>
                                                <th>Debit</th>
                                                <th>Credit</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Unadjusted Closing Balance</td>
                                                    <td class="text-right">0.00</td>
                                                    <td class="text-right">0.00</td>
                                                </tr>
                                            </tbody>
                                            <tr>
                                                <td colspan="3"></td>
                                            </tr>
                                            <tbody>
                                                <tr>
                                                    <td>Add Deposits in Transit</td>
                                                    <td class="text-right">0.00</td>
                                                    <td class="text-right">0.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Deduct Outstanding Cheques</td>
                                                    <td class="text-right">0.00</td>
                                                    <td class="text-right">0.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Add / Deduct Bank Errors</td>
                                                    <td class="text-right">0.00</td>
                                                    <td class="text-right">0.00</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><span class="text-white">.</span></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><span class="text-white">.</span></td>
                                                </tr>
                                            </tbody>
                                            <tr>
                                                <td colspan="3"></td>
                                            </tr>
                                            <tfoot>
                                                <th>Adjusted Closing Balance</th>
                                                <th class="text-right">0.00</th>
                                                <th class="text-right">0.00</th>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                                <th>Cash Book</th>
                                                <th>Debit</th>
                                                <th>Credit</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Unadjusted Closing Balance</td>
                                                    <td class="text-right">0.00</td>
                                                    <td class="text-right">0.00</td>
                                                </tr>
                                            </tbody>
                                            <tr>
                                                <td colspan="3"></td>
                                            </tr>
                                            <tbody>
                                                <tr>
                                                    <td>Add Missing Receipts</td>
                                                    <td class="text-right">0.00</td>
                                                    <td class="text-right">0.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Add Interest Received</td>
                                                    <td class="text-right">0.00</td>
                                                    <td class="text-right">0.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Deduct Bank Fees</td>
                                                    <td class="text-right">0.00</td>
                                                    <td class="text-right">0.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Deduct Bounced Cheques</td>
                                                    <td class="text-right">0.00</td>
                                                    <td class="text-right">0.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Add / Deduct Errors in Cash Book</td>
                                                    <td class="text-right">0.00</td>
                                                    <td class="text-right">0.00</td>
                                                </tr>
                                            </tbody>
                                            <tr>
                                                <td colspan="3"></td>
                                            </tr>
                                            <tfoot>
                                                <th>Adjusted Closing Balance</th>
                                                <th class="text-right">0.00</th>
                                                <th class="text-right">0.00</th>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="table">
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                                <th>Unreconciled Amount</th>
                                                <th class="text-right">0.00</th>
                                                <th class="text-right">0.00</th>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>

</div>

@endsection

@push('scripts')
<script src="/js/banking/template_select_bank.js"></script>
<script src="/js/banking/reconciliation/select_bank.js"></script>
@endpush