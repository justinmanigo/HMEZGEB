@extends('template.index')

@push('styles')
<style>
    .table-item-content { 
        /** Equivalent to pt-3 */
        padding-top:1rem!important;
    }

    #thead-actions {
        /** Fixed width, increase if adding addt. buttons **/
        width:60px;
    }

    input[type="checkbox"], label {
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="card col-lg-9 col-xl-8 mb-3">
    <div class="card-body">
        <h1 class="mb-3">New Deposit</h1>
        <form id="form-new-deposit" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="bank_account" class="col-sm-3 col-form-label">Select Bank<span class="text-danger ml-1">*</span></label>
                <div class="col-sm-9">
                    <select class="form-control" id="bank_account" name="bank_account">
                        <option>Bank A</option>
                    </select>
                </div>
            </div>
            <hr>
            <h2>Undeposited Sales</h2>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th id="thead-actions">Actions</th>
                        <th>Invoice Number</th>
                        <th>Customer Name</th>
                        <th>Date</th>
                        <th>Total</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="table-item-content">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="invoices_1483681825" name="invoices[]" value="">
                                </div>
                            </td>
                            <td class="table-item-content"><label for="invoices_1483681825">1483681825</label></td>
                            <td class="table-item-content">PocketDevs</td>
                            <td class="table-item-content">01/31/2022</td>
                            <td class="table-item-content">Birr 1,000</td>
                        </tr>
                        <tr>
                            <td class="table-item-content">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="invoices_1483681826" name="invoices[]" value="">
                                </div>
                            </td>
                            <td class="table-item-content"><label for="invoices_1483681826">1483681826</label></td>
                            <td class="table-item-content">Fullstack HQ</td>
                            <td class="table-item-content">02/01/2022</td>
                            <td class="table-item-content">Birr 2,000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    <div class="card-footer bg-white">
        <button type="button" class="btn btn-primary">Save Deposit</button>
        <a role="button" class="btn btn-secondary" href="{{ route('deposit.index') }}">Cancel</a>
    </div>
</div>
@endsection