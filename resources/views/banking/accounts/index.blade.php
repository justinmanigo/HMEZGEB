@extends('template.index')

@push('styles')
    <style>
        .table-item-content { 
        /** Equivalent to pt-3 */
        padding-top:1rem!important;
        }

        .thead-actions {
            /** Fixed width, increase if adding addt. buttons **/
            width:120px;
        }
        .content-card {
            border-radius:0px 0px 5px 5px;
        }

        .inputPrice::-webkit-inner-spin-button, .inputTax::-webkit-inner-spin-button,
        .inputPrice::-webkit-outer-spin-button, .inputTax::-webkit-outer-spin-button {
            -webkit-appearance: none; 
            margin: 0; 
        }

        input[type="checkbox"], label {
            cursor: pointer;
        }
    </style>
@endpush

@section('content')

<div class="row">

    {{-- Main Content Section --}}
    <div class="col-xl-12 col-lg-12 col-12">
        {{-- Button Group Navigation --}}
        <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
            <button role="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-deposit">
                <span class="icon text-white-50">
                    <i class="fas fa-pen"></i>
                </span>
                <span class="text">New</span>
            </button> 
        </div>

        {{-- Tab Navigation --}}
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="transactions-tab" data-toggle="tab" href="#transactions" role="tab" aria-controls="transactions" aria-selected="true">Bank Accounts</a>
            </li>
            {{-- <li class="nav-item" role="presentation">
                <a class="nav-link" id="proforma-tab" data-toggle="tab" href="#proforma" role="tab" aria-controls="proforma" aria-selected="false">Proforma</a>
            </li> --}}
        </ul>

        {{-- Tab Contents --}}
        <div class="card" class="content-card">
            <div class="card-body tab-content" id="myTabContent">
                {{-- Transaction Contents --}}
                <div class="tab-pane fade show active" id="transactions" role="tabpanel" aria-labelledby="transactions-tab">
                    <div class="table-responsive">
                         <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                            <thead>
                                
                                <th>Chart of Acct#</th>
                                <th>Bank Name</th>
                                <th>Branch</th>
                                <th>Type</th>
                                <th>Account Number</th>
                                <th>Balance</th>
                                <th class="thead-actions">Actions</th>
                                
                            </thead>
                            <tbody>
                                <tr>
                                    
                                    <td class="table-item-content">1030</td>
                                    <td class="table-item-content">Commercail Bank of Ethiopia	</td> 
                                    <td class="table-item-content"> Main Branch	</td>
                                    <td class="table-item-content"> Checking Account </td>
                                    <td class="table-item-content">100002344758</td>
                                    <td class="table-item-content">700,000.00 </td>
                                    <td>
                                        <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-small btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Proforma Contents --}}
                <div class="tab-pane fade" id="proforma" role="tabpanel" aria-labelledby="proforma-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th class="thead-actions">Actions</th>
                                <th>Invoice Number</th>
                                <th>Customer Name</th>
                                <th>Date</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-small btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button>
                                    </td>
                                    <td class="table-item-content">1483681825</td>
                                    <td class="table-item-content">PocketDevs</td>
                                    <td class="table-item-content">01/31/2022</td>
                                    <td class="table-item-content">Birr 1,000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

   

</div>



{{-- Modals --}}

{{-- 
    KNOWN POTENTIAL PROBLEMS:
    > Modal Contents have similar IDs for its contents.
    POTENTIAL SOLUTIONS:
    > Update form on button click via JS.
--}}

{{-- New Receipt --}}
<div class="modal fade" id="modal-receipt" tabindex="-1" role="dialog" aria-labelledby="modal-receipt-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-receipt-label">New Receipt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('customer.receipt.forms.receipt')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" form="form-receipt">Save Receipt</button>
            </div>
        </div>
    </div>
</div>

{{-- New Advance Revenue --}}
<div class="modal fade" id="modal-advance-revenue" tabindex="-1" role="dialog" aria-labelledby="modal-advance-revenue-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-advance-revenue-label">New Advance Revenue</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('customer.receipt.forms.advance_revenue')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" form="form-advance-revenue">Save Advance Revenue</button>
            </div>
        </div>
    </div>
</div>

{{-- New Credit Receipt --}}
<div class="modal fade" id="modal-credit-receipt" tabindex="-1" role="dialog" aria-labelledby="modal-credit-receipt-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-credit-receipt-label">New Credit Receipt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('customer.receipt.forms.credit_receipt')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" form="form-credit-receipt">Save Credit Receipt</button>
            </div>
        </div>
    </div>
</div>

{{-- New Proforma --}}
<div class="modal fade" id="modal-proforma" tabindex="-1" role="dialog" aria-labelledby="modal-proforma-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-proforma-label">New Proforma</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('customer.receipt.forms.proforma')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" form="form-proforma">Save Proforma</button>
            </div>
        </div>
    </div>
</div>

{{-- Import --}}
<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="modal-import-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-import-label">Import Receipts</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-import" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="i_file" class="col-sm-4 col-form-label">File<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-8">
                            <input type="file" id="i_file" name="file" class="mt-1" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-import">Import Receipts</button>
            </div>
        </div>
    </div>
</div>

{{-- Export --}}
<div class="modal fade" id="modal-export" tabindex="-1" role="dialog" aria-labelledby="modal-export-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-export-label">Export Receipts</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-export" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="e_file_type" class="col-sm-4 col-form-label">File Type<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" id="e_file_type" name="file_type" required>
                                <option>HTML</option>
                                <option>PDF</option>
                                <option>CSV</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-export">Export Receipts</button>
            </div>
        </div>
    </div>
</div>

{{-- Modals --}}
{{-- New Deposit --}}
<div class="modal fade" id="modal-deposit" tabindex="-1" role="dialog" aria-labelledby="modal-deposit-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-deposit-label">New Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-deposit" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="d_deposit_id" class="col-sm-3 col-lg-2 col-form-label">Chart of Account Number</label>
                        <div class="col-sm-9 col-lg-6">
                            <input type="text" class="form-control" id="d_deposit_id" name="deposit_id" value="1031" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="d_deposit_id" class="col-sm-3 col-lg-2 col-form-label">Bank Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <input type="text" class="form-control" id="d_deposit_id" name="deposit_id">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="d_bank_account" class="col-sm-3 col-lg-2 col-form-label">Select Bank Acct.<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <select class="form-control" id="d_bank_account" name="bank_account">
                                <option>Bank A</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="d_deposit_id" class="col-sm-3 col-lg-2 col-form-label">Account Number<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <input type="text" class="form-control" id="d_deposit_id" name="deposit_id">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="d_bank_account" class="col-sm-3 col-lg-2 col-form-label">Account Type<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <select class="form-control" id="d_bank_account" name="bank_account">
                                <option>Savings </option>
                                <option>Checking </option>
                            </select>
                        </div>
                    </div>

 
                
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" form="form-deposit">Save Account</button>
            </div>
        </div>
    </div>
</div>

<script>
        $(document).ready(function () {
            $('#dataTables').DataTable();
            $('.dataTables_filter').addClass('pull-right');
        });
</script>

@endsection