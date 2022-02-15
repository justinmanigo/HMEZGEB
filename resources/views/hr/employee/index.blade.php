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

{{-- Button Group Navigation --}}
<div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
    <button type="button" class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-employee">
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
                    <th>Employee Name</th>
                    <th>Tin Number</th>
                    <th>Contact Number</th>
                    <th>Type</th>
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
                        <td class="table-item-content">Graeme Xyber Pastoril</td>
                        <td class="table-item-content">1234567890</td>
                        <td class="table-item-content">+63 912 345 6789</td>
                        <td class="table-item-content"><span class="badge badge-secondary">Employee</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Employee Modal --}}
<div class="modal fade" id="modal-employee" tabindex="-1" role="dialog" aria-labelledby="modal-employee-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-employee-label">New Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-employee" method="post" enctype="multipart/form-data">
                    
                    <div class="form-group row">
                        <label for="e_first_name" class="col-sm-3 col-lg-2 col-form-label">First Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-10">
                            <input type="text" class="form-control" id="e_first_name" name="first_name" placeholder="" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="e_father_name" class="col-sm-3 col-lg-2 col-form-label">Father Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-xl-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="e_father_name" name="father_name" placeholder="" required>
                        </div>

                        <label for="e_grandfather_name" class="col-sm-3 col-lg-2 col-form-label">G. Father Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-xl-4">
                            <input type="text" class="form-control" id="e_grandfather_name" name="grandfather_name" placeholder="" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="e_date_of_birth" class="col-sm-3 col-lg-2 col-form-label">Date of Birth</label>
                        <div class="col-sm-9 col-lg-10">
                            <input type="date" class="form-control" id="e_date_of_birth" name="date_of_birth" placeholder="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="e_mobile_number" class="col-sm-3 col-lg-2 col-form-label">Mobile Number<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="e_mobile_number" name="mobile_number" placeholder="">
                        </div>

                        <label for="e_telephone" class="col-sm-3 col-lg-2 col-form-label">Telephone</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="text" class="form-control" id="e_telephone" name="telephone" placeholder="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="e_email" class="col-sm-3 col-lg-2 col-form-label">Email</label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="e_email" name="email" placeholder="">
                        </div>

                        <label for="e_tin_number" class="col-sm-3 col-lg-2 col-form-label">Tin Number</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="text" class="form-control" id="e_tin_number" name="tin_number" placeholder="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="e_type" class="col-sm-3 col-lg-2 col-form-label">Type<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <select class="form-control" id="e_type" name="type">
                                <option>Employee</option>
                                <option>Commission Agent</option>
                            </select>
                        </div>

                        <label for="e_basic_salary" class="col-sm-3 col-lg-2 col-form-label">Basic Salary</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="text" class="form-control" id="e_basic_salary" name="basic_salary" placeholder="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="e_date_started_working" class="col-sm-3 col-lg-2  col-form-label">Date Started Working<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="date" class="form-control" id="e_date_started_working" name="date_started_working" placeholder="" required>
                        </div>

                        <label for="e_date_ended_working" class="col-sm-3 col-lg-2  col-form-label">Date Ended Working</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="date" class="form-control mb-2" id="e_date_ended_working" name="date_ended_working" placeholder="" required>
                            <div class="form-check">
                                <input class="form-check-input" id="e_is_still_working" type="checkbox" value="" name="is_still_working">
                                <label class="form-check-label" for="e_is_still_working">Still Working</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="e_emergency_contact_person" class="col-sm-3 col-lg-2  col-form-label">Emergency Contact Person</label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="e_emergency_contact_person" name="emergency_contact_person" placeholder="" required>
                        </div>

                        <label for="e_emergency_contact_number" class="col-sm-3 col-lg-2  col-form-label">Emergency Contact Number</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="text" class="form-control" id="e_emergency_contact_number" name="emergency_contact_number" placeholder="" required>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-employee">Save Customer</button>
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