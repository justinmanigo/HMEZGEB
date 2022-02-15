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
    <button type="button" class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-addition">
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
            <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
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

{{-- Addition Modal --}}
<div class="modal fade" id="modal-addition" tabindex="-1" role="dialog" aria-labelledby="modal-addition-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-addition-label">New Addition</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="form-addition" method="POST">
                    <div class="form-group row">
                        <label for="a_date" class="col-sm-3 col-lg-2 col-form-label">Date<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="date" class="form-control" id="a_date" name="date" placeholder="" required>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                            <thead>
                                <th>Actions</th>
                                <th>Employee Name</th>
                                <th>Price</th>
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
                                </tr>
                                <tr>
                                    <td colspan="3">
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
                            <label for="a_description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                            <div class="col-sm-9 col-lg-10">
                                <textarea class="form-control" id="a_description" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-addition">Save Addition</button>
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