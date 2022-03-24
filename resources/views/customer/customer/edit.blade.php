
@extends('template.index')
@section('content')

            <div class="modal-header ">
                <h5 class="modal-title" id="modal-customer-label">Edit Customer</h5>
            </div>
            <br/>
            
            <form id="form-customer" action="{{ url('customer/'.$customers->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')


                <div class="form-group row">
                    <label for="c_name" class="col-sm-3 col-lg-2 col-form-label">Name<span class="text-danger ml-1">*</span> :</label>
                    <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                        <input type="text" class="form-control" id="c_name" name="name" placeholder="" value="{{ $customers->name }}" required>
                    </div>

                    <label for="c_tin_number" class="col-sm-3 col-lg-2 col-form-label">Tin Number :</label>
                    <div class="col-sm-9 col-lg-4">
                        <input type="text" class="form-control" id="c_tin_number" name="tin_number" value="{{ $customers->tin_number }}" placeholder="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="c_address" class="col-sm-3 col-lg-2 col-form-label">Address :</label>
                    <div class="col-sm-9 col-lg-10">
                        <input type="text" class="form-control" id="c_address" name="address" placeholder="" value="{{ $customers->address }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="c_city" class="col-sm-3 col-lg-2 col-form-label">City :</label>
                    <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                        <input type="text" class="form-control" id="c_city" name="city" placeholder="" value="{{ $customers->city }}">
                    </div>

                    <label for="c_country" class="col-sm-3 col-lg-2 col-form-label">Country :</label>
                    <div class="col-sm-9 col-lg-4">
                        <input type="text" class="form-control" id="c_country" name="country" placeholder="" value="{{ $customers->country }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="c_phone_1" class="col-sm-3 col-lg-2 col-form-label">Phone 1 :</label>
                    <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                        <input type="text" class="form-control" id="c_phone_1" name="telephone_one" placeholder="" value="{{ $customers->telephone_one }}">
                    </div>

                    <label for="c_phone_2" class="col-sm-3 col-lg-2 col-form-label">Phone 2 :</label>
                    <div class="col-sm-9 col-lg-4">
                        <input type="text" class="form-control" id="c_phone_2" name="telephone_two" placeholder="" value="{{ $customers->telephone_two }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="c_fax" class="col-sm-3 col-lg-2 col-form-label">Fax :</label>
                    <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                        <input type="text" class="form-control" id="c_fax" name="fax" placeholder="" value="{{ $customers->fax }}">
                    </div>

                    <label for="c_mobile_number" class="col-sm-3 col-lg-2 col-form-label">Mobile Number :</label>
                    <div class="col-sm-9 col-lg-4">
                        <input type="text" class="form-control" id="c_mobile_number" name="mobile_number" placeholder="" value="{{ $customers->mobile_number }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="c_contact_person" class="col-sm-2 col-form-label">Contact Person :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="c_contact_person" name="contact_person" placeholder="" value="{{ $customers->contact_person }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="c_email" class="col-sm-2 col-form-label">E-mail :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="c_email" name="email" placeholder="" value="{{ $customers->email }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="c_website" class="col-sm-2 col-form-label">Website :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="c_website" name="website" placeholder="" value="{{ $customers->website }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="c_picture" class="col-sm-3 col-lg-2 col-form-label">Picture :</label >
                    <div class="col-sm-9 col-lg-4">
                        <input type="file" id="c_picture" name="image" value="{{ $customers->image }}">
                    </div>

                    <label for="c_label" class="col-sm-3 col-lg-2 col-form-label">Label :</label>
                    <div class="col-sm-9 col-lg-4">
                        <input type="text" class="form-control" id="c_label" name="label" placeholder="New" value="{{ $customers->label }}">
                    </div>
                </div> 
            </div>
            <div class="modal-footer">
                <div class="form-check mr-3">
                    <input class="form-check-input" id="c_is_active" type="checkbox" value="" name="is_active">
                    <label class="form-check-label" for="c_is_active">Mark Customer as Active</label>
                </div>
                <a type="button" href="/customer" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary" >Save Customer</button>

            </form>

@endsection