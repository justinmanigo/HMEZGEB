@extends('template.index')

@push('styles')
<style>
    .table-item-content { 
        /** Equivalent to pt-3 */
        padding-top:1rem!important;
    }

    #thead-actions {
        /** Fixed width, increase if adding addt. buttons **/
        width:120px;
    }

    input[type="checkbox"], label {
        cursor: pointer;
    }
</style>
@endpush

@section('content')
{{-- Button Group Navigation --}}
<div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
    <button role="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-deposit">
        <span class="icon text-white-50">
            <i class="fas fa-pen"></i>
        </span>
        <span class="text">New</span>
    </button> 
</div>

{{-- Page Content --}}
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                    <thead>
                        <th id="thead-actions">Actions</th>
                        <th>Date</th>
                        <th>Bank</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{-- <button type="button" class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                </button> --}}
                            </td>
                            <td>Feb. 1, 2022</td>
                            <td>Bank A</td>
                            <td>Birr 1,000</td>
                        </tr>
                    </tbody>
                </table>
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
                <form id="form-deposit" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="d_bank_account" class="col-sm-3 col-lg-2 col-form-label">Select Bank Acct.<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-4">
                            <select class="form-control" id="d_bank_account" name="bank_account">
                                <option>Bank A</option>
                            </select>
                        </div>

                        <label for="d_deposit_date" class="col-sm-3 col-lg-2 col-form-label">Deposit Date<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="date" class="form-control" id="d_deposit_date" name="deposit_date">
                        </div>
                    </div>
                    <div class="form-group row">
                        {{-- Temporarily blank first column --}}
                        <div class="col-lg-6 d-none d-lg-flex"></div>

                        <label for="d_deposit_id" class="col-sm-3 col-lg-2 col-form-label">Deposit ID<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="text" class="form-control" id="d_deposit_id" name="deposit_id">
                        </div>
                    </div>
                    <hr>
                    <h2>Undeposited Sales</h2>
                    <div class="table-responsive">
                          <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                            <thead>
                                <th>Invoice Number</th>
                                <th>Customer Name</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th id="thead-actions">Actions</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="table-item-content"><label for="d_invoices_1483681825">1483681825</label></td>
                                    <td class="table-item-content">PocketDevs</td>
                                    <td class="table-item-content">01/31/2022</td>
                                    <td class="table-item-content">Birr 1,000</td>
                                    <td class="table-item-content">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="d_invoices_1483681825" name="invoices[]" value="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table-item-content"><label for="d_invoices_1483681826">1483681826</label></td>
                                    <td class="table-item-content">Fullstack HQ</td>
                                    <td class="table-item-content">02/01/2022</td>
                                    <td class="table-item-content">Birr 2,000</td>
                                    <td class="table-item-content">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="d_invoices_1483681826" name="invoices[]" value="">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" form="form-deposit">Save Deposit</button>
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