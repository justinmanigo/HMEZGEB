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
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
@endpush

@section('content')

<div class="card col-12 col-lg-6 mb-3">
    <div class="card-body">
        <p>Filter</p>
        <hr>
        <form>
            <div class="form-group row">
                <label for="employee" class="col-12 col-md-3">Employee</label>
                <div class="col-12 col-lg-6">
                    <input type="text" class="form-control" id="employee" name="employee" list="list_employees">
                    <datalist id="list_employees">
                        <option>Graeme Xyber Pastoril</option>
                        <option>Justin Manigo</option>
                        <option>Lester Fong</option>
                    </datalist>
                </div>
            </div>
            <div class="form-group row">
                <label for="month" class="col-12 col-md-3">Select Month</label>
                <div class="col-12 col-lg-6">
                    <input type="month" class="form-control "id="month" name="month">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12 col-md-3"></div>
                <div class="col-8 col-lg-3">
                    <button type="submit" class="form-control btn btn-primary">Search</button>
                </div>
                <div class="col-4 col-lg-3">
                    <button type="button" class="form-control btn btn-secondary">Reset</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Button Group Navigation --}}
{{-- <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
    <button type="button" class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-employee">
        <span class="icon text-white-50">
            <i class="fas fa-pen"></i>
        </span>
        <span class="text">New</span>
    </button>   
</div> --}}

{{-- Page Content --}}
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th id="thead-actions">Actions</th>
                    <th>Employee Name</th>
                    <th>Status</th>
                    <th>Basic Salary</th>
                    <th>Additions</th>
                    <th>Deductions</th>
                    <th>Grand Total</th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="tooltip" data-placement="bottom" title="View">
                                <span class="icon text-white-50">
                                    <i class='fa fa-eye text-white'></i>
                                </span>
                            </button>
                            <button type="button" class="btn btn-small btn-icon btn-danger" data-toggle="modal" data-target="#modal-payment">
                                <span class="icon text-white-50">
                                    <i class='fa fa-money text-white'></i>
                                </span>
                            </button>
                        </td>
                        <td class="table-item-content">Graeme Xyber Pastoril</td>
                        <td class="table-item-content"><span class="badge badge-secondary">Unpaid</span></td>
                        <td class="table-item-content">Birr 10,000</td>
                        <td class="table-item-content">Birr 0.00</td>
                        <td class="table-item-content">Birr 0.00</td>
                        <td class="table-item-content">Birr 10,000.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- TODO Later when more info arrives: --}}
{{-- Salary Details Modal (Eye Icon)--}}

{{-- Payment Modal (Money Icon)--}}
<div class="modal fade" id="modal-payment" tabindex="-1" role="dialog" aria-labelledby="modal-payment-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-payment-label">Payment for February 2022</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="form-overtime" method="POST">
                    <div class="form-group row">
                        <label for="p_basic_salary" class="col-lg-4 col-form-label">Basic Salary</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control text-right" id="p_basic_salary" name="basic_salary" placeholder="0.00" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="p_total_additions" class="col-lg-4 col-form-label">Total Additions</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control text-right" id="p_total_additions" name="total_additions" placeholder="0.00" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="p_total_deductions" class="col-lg-4 col-form-label">Total Deductions</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control text-right" id="p_total_deductions" name="total_deductions" placeholder="0.00" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="p_gross_salary" class="col-lg-4 col-form-label">Gross Salary</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control text-right" id="p_gross_salary" name="gross_salary" placeholder="0.00" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="p_payment_method" class="col-lg-4 col-form-label">Payment Method</label>
                        <div class="col-lg-8">
                            <select class="form-control" id="p_payment_method" name="payment_method" required>
                                <option value="">-Select Payment Method-</option>
                                <option value="offline">Offline</option>
                                <option value="online">Online</option>
                                <option value="paypal">Paypal</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="p_notes" class="col-lg-4 col-form-label">Notes</label>
                        <div class="col-lg-8">
                            <textarea class="form-control" id="p_notes" name="notes"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-payment">Save Payment</button>
            </div>
        </div>
    </div>
</div>
@endsection