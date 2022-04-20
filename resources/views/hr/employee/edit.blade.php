@extends('template.index')
@section('content')


<div class="modal-header">
    <h5 class="modal-title" id="modal-employee-label">Edit Employee</h5>
   
</div>
<form id="form-employee" action="{{ url('employee/'.$employees->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="modal-body">
        <div class="form-group row">
            <label for="e_first_name" class="col-sm-3 col-lg-2 col-form-label">First Name<span class="text-danger ml-1">*</span></label>
            <div class="col-sm-9 col-lg-10">
                <input type="text" class="form-control" id="e_first_name" value="{{ $employees->first_name }}" name="first_name" placeholder="" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="e_father_name" class="col-sm-3 col-lg-2 col-form-label">Father Name<span class="text-danger ml-1">*</span></label>
            <div class="col-sm-9 col-xl-4 mb-3 mb-lg-0">
                <input type="text" class="form-control" id="e_father_name"  value="{{ $employees->father_name}}" name="father_name" placeholder="" required>
            </div>

            <label for="e_grandfather_name" class="col-sm-3 col-lg-2 col-form-label">G. Father Name<span class="text-danger ml-1">*</span></label>
            <div class="col-sm-9 col-xl-4">
                <input type="text" class="form-control" id="e_grandfather_name" value="{{ $employees->grandfather_name}}" name="grandfather_name" placeholder="" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="e_date_of_birth" class="col-sm-3 col-lg-2 col-form-label">Date of Birth</label>
            <div class="col-sm-9 col-lg-10">
                <input type="date" class="form-control" id="e_date_of_birth" name="date_of_birth" value="{{ $employees->date_of_birth}}" placeholder="" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="e_mobile_number" class="col-sm-3 col-lg-2 col-form-label">Mobile Number<span class="text-danger ml-1">*</span></label>
            <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                <input type="text" class="form-control" id="e_mobile_number" name="mobile_number" value="{{ $employees->mobile_number}}" placeholder="" required>
            </div>

            <label for="e_telephone" class="col-sm-3 col-lg-2 col-form-label">Telephone</label>
            <div class="col-sm-9 col-lg-4">
                <input type="text" class="form-control" id="e_telephone" name="telephone" value="{{ $employees->telephone}}" placeholder="" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="e_email" class="col-sm-3 col-lg-2 col-form-label">Email</label>
            <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                <input type="text" class="form-control" id="e_email" name="email" value="{{ $employees->email}}" placeholder="" required>
            </div>

            <label for="e_tin_number" class="col-sm-3 col-lg-2 col-form-label">Tin Number</label>
            <div class="col-sm-9 col-lg-4">
                <input type="text" class="form-control" id="e_tin_number" name="tin_number" value="{{ $employees->tin_number}}" placeholder="" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="e_type" class="col-sm-3 col-lg-2 col-form-label">Type<span class="text-danger ml-1">*</span></label>
            <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                <select class="form-control" id="e_type" name="type" value="{{ $employees->type}}" >
                    <option value="employee" >Employee</option>
                    <option value="commission_agent">Commission Agent</option>
                </select>
            </div>

            <label for="e_basic_salary" class="col-sm-3 col-lg-2 col-form-label">Basic Salary</label>
            <div class="col-sm-9 col-lg-4">
                <input type="text" class="form-control" id="e_basic_salary" name="basic_salary" value="{{ $employees->basic_salary}}" placeholder="" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="e_date_started_working" class="col-sm-3 col-lg-2  col-form-label">Date Started Working<span class="text-danger ml-1">*</span></label>
            <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                <input type="date" class="form-control" id="e_date_started_working" name="date_started_working" value="{{ $employees->date_started_working}}" placeholder="" required>
            </div>

            <label for="e_date_ended_working" class="col-sm-3 col-lg-2  col-form-label">Date Ended Working</label>
            <div class="col-sm-9 col-lg-4">
                <input type="date" class="form-control mb-2" id="e_date_ended_working" name="date_ended_working" value="{{ $employees->date_ended_working}}" placeholder="" required>
                <div class="form-check">
                    <input class="form-check-input" id="e_is_still_working" type="checkbox" value="" name="is_still_working">
                    <label class="form-check-label" for="e_is_still_working">Still Working</label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="e_emergency_contact_person" class="col-sm-3 col-lg-2  col-form-label">Emergency Contact Person</label>
            <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                <input type="text" class="form-control" id="e_emergency_contact_person" name="emergency_contact_person" value="{{ $employees->emergency_contact_person}}" placeholder="" required>
            </div>

            <label for="e_emergency_contact_number" class="col-sm-3 col-lg-2  col-form-label">Emergency Contact Number</label>
            <div class="col-sm-9 col-lg-4">
                <input type="text" class="form-control" id="e_emergency_contact_number" name="emergency_contact_number" value="{{ $employees->emergency_contact_number}}" placeholder="" required>
            </div>
        </div>
        
    </div> 
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="form-employee">Save Customer</button>
    </div>
</form>



@endsection