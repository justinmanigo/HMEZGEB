@extends('template.index')

@push('styles')
<style>
    .table-employee-content { 
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

{{-- Button Group Navigation --}}
<div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
    <button type="button" class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-loan">
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
                <thead>
                    <th id="thead-actions">Actions</th>
                    <th>Date</th>
                    <th>Employee Name</th>
                    <th>Type</th>
                    <th>Price</th>
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
                        <td class="table-employee-content">Feb. 8, 2022</td>
                        <td class="table-employee-content">Graeme Xyber Pastoril</td>
                        <td class="table-employee-content"><span class="badge badge-secondary">Employee</span></td>
                        <td class="table-employee-content">Birr 300.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Deduction Modal --}}
<div class="modal fade" id="modal-loan" tabindex="-1" role="dialog" aria-labelledby="modal-loan-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-loan-label">New Loan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <label for="l_date" class="col-sm-3 col-lg-2 col-form-label">Date<span class="text-danger ml-1">*</span></label>
                    <div class="col-sm-9 col-lg-4">
                        <input type="date" class="form-control" id="l_date" name="date" placeholder="" required>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>Actions</th>
                            <th>Employee Name</th>
                            <th>Price</th>
                            <th>Paid In</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </button>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-select-employee">Select</button>
                                        </div>
                                        <div class="input-group-append">
                                            <input type="text" class="form-control" name="employee_name[]" placeholder="Employee Name" disabled>
                                        </div>
                                        <input type="hidden" name="employee_id[]" value="">
                                    </div>
                                </td>
                                <td>
                                    <input type="text" class="form-control text-right" name="price[]" placeholder="0.00" required>
                                </td>
                                <td>
                                    <select class="form-control" name="paid_in[]" required>
                                        <option>-Select Paid In-</option>
                                        <option value="1 Month">1 Month</option>
                                        <option value="3 Months">3 Months</option>
                                        <option value="6 Months">6 Months</option>
                                        <option value="9 Months">9 Months</option>
                                        <option value="12 Months">12 Months</option>
                                        <option value="18 Months">18 Months</option>
                                        <option value="24 Months">24 Months</option>
                                        <option value="30 Months">30 Months</option>
                                        <option value="36 Months">36 Months</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="form-group row">
                        <label for="l_description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                        <div class="col-sm-9 col-lg-10">
                            <textarea class="form-control" id="l_description" name="description"></textarea>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" form="modal-loan">Save Loan</button>
            </div>
        </div>
    </div>
</div>
@endsection