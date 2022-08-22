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
                <p class="alert alert-danger">
                    This feature is not yet available at the moment. This is only a static page for demonstration purposes.
                </p>
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
                    <button type="submit" class="btn btn-primary" disabled>Import</button>
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
                <div class="row">
                    <nav class="col-12 col-lg-8">
                        <div class="nav nav-pills" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-status-tab" data-toggle="tab" href="#nav-status" role="tab" aria-controls="nav-status" aria-selected="false">Status</a>
                            <a class="nav-item nav-link" id="nav-bank-statement-tab" data-toggle="tab" href="#nav-bank-statement" role="tab" aria-controls="nav-bank-statement" aria-selected="true">Bank Statement</a>
                            <a class="nav-item nav-link" id="nav-cash-book-tab" data-toggle="tab" href="#nav-cash-book" role="tab" aria-controls="nav-cash-book" aria-selected="false">Cash Book</a>
                        </div>
                    </nav>
                    <div class="col-12 col-lg-4 mt-3">
                        <div class="form-check d-lg-flex justify-content-end">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label mr-lg-4" for="defaultCheck1">
                                Show Reconciled Transactions
                            </label>
                        </div>
                    </div>
                </div>
                <hr>
                
                <div class="tab-content" id="nav-tabContent">
                    
                    <div class="tab-pane fade show active" id="nav-status" role="tabpanel" aria-labelledby="nav-contact-tab">
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

                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit" disabled>Process Reconciliation</button>
                                <button class="btn btn-outline-danger" type="button" disabled>Cancel</button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-bank-statement" role="tabpanel" aria-labelledby="nav-bank-statement-tab">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Balance</th>
                                    <th>Actions</th>
                                    {{-- <th>OK?</th> --}}
                                </thead>
                                <tbody>
                                    <tr class="d-table-row">
                                        <td>August 31, 2022</td>
                                        <td>Bank Statement</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>
                                            <button data-id="1" data-type="bank-statement" class="btn btn-sm btn-primary btn-correct-and-match" data-toggle="modal" data-target="#correctAndMatch">Correct and Match</button>
                                            <button data-id="1" data-type="bank-statement" class="btn btn-sm btn-info btn-create-and-match" data-toggle="modal" data-target="#createAndMatch">Create Transaction</button>
                                        </td>
                                        {{-- <td>
                                            <a href="#" class="btn btn-sm btn-success">OK</a>
                                        </td> --}}
                                    </tr>
                                </tbody>
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
                                    {{-- <th>OK?</th> --}}
                                </thead>
                                <tbody>
                                    <tr class="d-table-row">
                                        <td>August 31, 2022</td>
                                        <td>Bank Statement</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary">Correct and Match</a>
                                            <a href="#" class="btn btn-sm btn-info">Create Transaction</a>
                                        </td>
                                        {{-- <td>
                                            <a href="#" class="btn btn-sm btn-success">OK</a>
                                        </td> --}}
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<!-- Correct and Match -->
<div class="modal fade" id="correctAndMatch" tabindex="-1" role="dialog" aria-labelledby="correctAndMatchLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="correctAndMatchLabel">Correct and Match</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <h5>Transaction Details</h5>
                        <p>
                            Source:<br>
                            <strong id="correctAndMatch-source">Bank Statement</strong>
                        </p>
                        <p>
                            Date:<br>
                            <strong id="correctAndMatch-date">2022-08-31</strong>
                        </p>
                        <p>
                            Description:<br>
                            <strong id="correctAndMatch-description">Test Description</strong>
                        </p>
                        <p>
                            Debit:<br>
                            <strong id="correctAndMatch-debit">0.00</strong>
                        </p>
                        <p>
                            Credit:<br>
                            <strong id="correctAndMatch-credit">300.00</strong>
                        </p>

                        <hr>

                        <h5>Correct Amount</h5>
                        <div class="input-group input-group-sm mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="">DR</span>
                            </div>
                            <input id="correctAndMatch-debit" type="text" class="form-control text-right" placeholder="Debit">
                        </div>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="">CR</span>
                            </div>
                            <input id="correctAndMatch-credit" type="text" class="form-control text-right" placeholder="Credit">
                        </div>
                    </div>
                    <div class="col-12 col-lg-9">
                        <h5>Find & Match Transaction</h5>
                        <div class="form-group">
                            <!-- search -->
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Search</span>
                                </div>
                                <input id="correctAndMatch-search" type="text" class="form-control" placeholder="Search">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>August 31, 2022</td>
                                        <td>Bank Statement</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>
                                            <!-- checkbox -->
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <h5 class="mr-3">Difference: <strong class="text-danger">0.00 / (0.00)</strong></h5>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Correct & Match</button>
            </div>
        </div>
    </div>
</div>

<!-- Create Transaction -->
<div class="modal fade" id="createAndMatch" tabindex="-1" role="dialog" aria-labelledby="createAndMatchLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAndMatchLabel">Create Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <h5>Transaction Details</h5>
                        <p>
                            Source:<br>
                            <strong id="createAndMatch-source">Bank Statement</strong>
                        </p>
                        <p>
                            Date:<br>
                            <strong id="createAndMatch-date">2022-08-31</strong>
                        </p>
                        <p>
                            Description:<br>
                            <strong id="createAndMatch-description">Test Description</strong>
                        </p>
                        <p>
                            Debit:<br>
                            <strong id="createAndMatch-debit">0.00</strong>
                        </p>
                        <p>
                            Credit:<br>
                            <strong id="createAndMatch-credit">300.00</strong>
                        </p>
                    </div>
                    <div class="col-12 col-lg-9">
                        <h5>Create & Match Transaction</h5>
                        <div class="form-group">
                            <!-- type -->
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Type</span>
                                </div>
                                <select id="createAndMatch-type" class="form-control">
                                    <option value="" disabled>BANK STATEMENT</option>
                                    <option value="deposit_in_transit">&nbsp;&nbsp;Deposit in Transit</option><!-- Add -->
                                    <option value="outstanding_cheque">&nbsp;&nbsp;Outstanding Cheque</option><!-- Deduct -->
                                    <option value="" disabled>CASH BOOK</option>
                                    <option value="missing_receipts">&nbsp;&nbsp;Missing Receipt</option><!-- Add -->
                                    <option value="interest_received">&nbsp;&nbsp;Interest Received</option><!-- Add -->
                                    <option value="bank_fee">&nbsp;&nbsp;Bank Fee</option><!-- Deduct -->
                                    <option value="bounced_cheque">&nbsp;&nbsp;Bounced Cheque</option><!-- Deduct -->
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- search -->
                            <label for="createAndMatch-search">Description</label>
                            <textarea id="createAndMatch-description" type="text" class="form-control">
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Create Transaction</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="/js/banking/template_select_bank.js"></script>
<script src="/js/banking/reconciliation/select_bank.js"></script>
@endpush