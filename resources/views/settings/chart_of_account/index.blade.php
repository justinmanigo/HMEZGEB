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
        <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
            <button role="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-deposit">
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
                                <tr>
                                    
                                    <td class="table-item-content">1030</td>
                                    <td class="table-item-content">Cash on Hand	</td> 
                                    <td class="table-item-content"> Asset	</td>
                                    <td class="table-item-content"> Cash </td>
                                    <td class="table-item-content">00.00</td>
                                    <td class="h6"><span class="badge badge-warning">Active</span></td>
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

</div>




{{-- Modals --}}
{{-- New Account --}}
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
                        <label for="d_deposit_id" class="col-sm-3 col-lg-2 col-form-label">Account Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <input type="text" class="form-control" id="d_deposit_id" name="deposit_id">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="d_bank_account" class="col-sm-3 col-lg-2 col-form-label">Account Type<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <select class="form-control" id="d_bank_account" name="bank_account">
                                <option>Bank A</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="d_deposit_id" class="col-sm-3 col-lg-2 col-form-label">Category<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <input type="text" class="form-control" id="d_deposit_id" name="deposit_id">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="d_bank_account" class="col-sm-3 col-lg-2 col-form-label">Balance<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <select class="form-control" id="d_bank_account" name="bank_account">
                                <option>Savings </option>
                                <option>Checking </option>
                            </select>
                        </div>
                  
                    </div>
                    <div class="form-group row">
                        <label for="d_bank_account" class="col-sm-3 col-lg-2 col-form-label">Status<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <select class="form-control" id="d_bank_account" name="bank_account">
                                <option>Active </option>
                                <option>Offline </option>
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