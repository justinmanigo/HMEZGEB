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
    <button type="button" class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-employee" onclick="initCreateEmployee()">
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
                    <th>Mobile Number</th>
                    <th>Type</th>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <td>
                                <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="modal" data-target="#modal-employee" onclick="initEditEmployee({{ $employee->id }})">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-pen"></i>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-small btn-icon btn-danger" data-toggle="modal" data-target="#modal-employee-delete" onclick="initDeleteEmployee({{ $employee->id }})">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-trash"></i>
                            </td>
                            <td class="table-item-content">{{ $employee->first_name . " " .$employee->father_name . " " . $employee->given_father_name }}</td>
                            <td class="table-item-content">{{ $employee->tin_number }}</td>
                            <td class="table-item-content">{{ $employee->mobile_number }}</td>
                            <td class="table-item-content">
                                @if($employee->type == 'employee')
                                    <span class="badge badge-success">Employee</span>
                                @elseif($employee->type == 'commission_agent')
                                    <span class="badge badge-primary">Commission Agent</span>
                                @else {{-- This is only included to visually catch errors. --}}
                                    <span class="badge badge-secondary">Other</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
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
                <div id="modal-employee-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form-employee" method="post" action="{{ route('employees.store') }}">
                    @csrf
                    <input type="hidden" id="e_http_method" name="_method" value="POST">
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

                        <label for="e_given_father_name" class="col-sm-3 col-lg-2 col-form-label">Given Father Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-xl-4">
                            <input type="text" class="form-control" id="e_given_father_name" name="given_father_name" placeholder="" required>
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
                            <select class="form-control" id="e_type" name="type" required>
                                <option value='employee'>Employee</option>
                                <option value='commission_agent'>Commission Agent</option>
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
                            <input type="date" class="form-control mb-2" id="e_date_ended_working" name="date_ended_working" placeholder="">
                            <div class="form-check">
                                <input class="form-check-input" id="e_is_still_working" type="checkbox" name="is_still_working">
                                <label class="form-check-label" for="e_is_still_working">Still Working</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="e_emergency_contact_person" class="col-sm-3 col-lg-2  col-form-label">Emergency Contact Person</label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="e_emergency_contact_person" name="emergency_contact_person" placeholder="" required>
                        </div>

                        <label for="e_contact_number" class="col-sm-3 col-lg-2  col-form-label">Emergency Contact Number</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="text" class="form-control" id="e_contact_number" name="contact_number" placeholder="" required>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-employee" id="e_submit_btn">Save Customer</button>
            </div>
        </div>
    </div>
</div>

{{-- Delete Employee Modal --}}
<div class="modal fade" id="modal-employee-delete" tabindex="-1" role="dialog" aria-labelledby="Modal Delete Tax">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-customer-label">Delete Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure to delete this record?
                <form id="form-employee-delete" class="" action="" method="POST">
                    @method('DELETE')
                    @csrf
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger" form="form-employee-delete">Delete Tax</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#dataTables').DataTable();
        $('.dataTables_filter').addClass('pull-right');
    });

    function initEditEmployee(id)
    {
        $("#form-employee").hide();
        $("#modal-employee-spinner").show();
        $("#e_http_method").val("PUT");
        $("#form-employee").attr("action", "/employee/" + id)
        $("#e_submit_btn").html("Update Employee").attr("disabled", 'disabled');
        $("#modal-employee-label").html("Edit Employee");
        
        // Get data from server.
        var request = $.ajax({
            url: "/ajax/hr/employees/get/" + id,
            method: "GET",
        });
            
        request.done(function(res, status, jqXHR ) {
            $("#form-employee").show();
            $("#modal-employee-spinner").hide();
            $("#e_submit_btn").removeAttr("disabled");
            console.log("Request successful.");
            console.log(res);

            if($('#e_is_still_working').is(':checked'))
            {
                $("#e_date_ended_working").attr('disabled', 'disabled');
                $("#e_date_ended_working").removeAttr('required');
            }

            // Fields
            $("#e_first_name").val(res.first_name);
            $("#e_father_name").val(res.father_name);
            $("#e_given_father_name").val(res.given_father_name);
            $("#e_date_of_birth").val(res.date_of_birth);
            $("#e_mobile_number").val(res.mobile_number);
            $("#e_telephone").val(res.telephone);
            $("#e_email").val(res.email);
            $("#e_tin_number").val(res.tin_number);
            $("#e_type").val(res.type);
            $("#e_basic_salary").val(res.basic_salary);
            $("#e_date_started_working").val(res.date_started_working);
            $("#e_date_ended_working").val(res.date_ended_working == undefined ? '' : res.date_ended_working);

            $("#e_emergency_contact_person").val(res.emergency_contact_person);
            $("#e_contact_number").val(res.contact_number);
            
            // If Date Ended Working is null
            if(res.date_ended_working == undefined)
                $('#e_is_still_working').click();

            // $("#e_name").val(res.name);
            // $("#e_percentage").val(res.percentage);
        });
        
        request.fail(function(jqXHR, status, error) {
            console.log("Request failed.");
        });
    }
    function initCreateEmployee()
    {
        $("#e_http_method").val("POST");
        $("#form-employee").attr("action", "{{ route('employees.store') }}")
        $("#e_submit_btn").html("Save Employee");
        $("#modal-employee-label").html("New Employee");
        $("#e_submit_btn").removeAttr("disabled");
        
        // Fields
        $("#e_first_name").val('');
        $("#e_father_name").val('');
        $("#e_given_father_name").val('');
        $("#e_date_of_birth").val('');
        $("#e_mobile_number").val('');
        $("#e_telephone").val('');
        $("#e_email").val('');
        $("#e_tin_number").val('');
        $("#e_type").val('');
        $("#e_basic_salary").val('');
        $("#e_date_started_working").val('');
        $("#e_date_ended_working").val('');
        $("#e_emergency_contact_person").val('');
        $("#e_contact_number").val('');

        if($('#e_is_still_working').is(':checked'))
        {
            $("#e_date_ended_working").attr('disabled', 'disabled');
            $("#e_date_ended_working").removeAttr('required');
            $('#e_is_still_working').click();
        }
    }
    function initDeleteEmployee(id)
    {
        $("#form-employee-delete").attr("action", "/employee/" + id);
    }

    $('#e_is_still_working').on('change',function(){
        var _val = $(this).is(':checked') ? 'checked' : 'unchecked';
        if(_val == 'checked')
        {
            $("#e_date_ended_working").attr('disabled', 'disabled');
            $("#e_date_ended_working").removeAttr('required');
        }
        else
        {
            $("#e_date_ended_working").removeAttr('disabled');
            $("#e_date_ended_working").attr('required', 'required');
        }
        console.log(_val);
    });
</script>
@endsection