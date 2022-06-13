@extends('template.index')
@section('content')

<div class="container">
    <div class="mb-2">
        <h1>{{$customers->name}}</h1>
    </div>

    <div class="container card shadow px-4 py-3">
        <form id="form-customer" action="{{ url('/customers/customers/'.$customers->id) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group row">
                <label for="c_name" class="col-sm-3 col-lg-2 col-form-label">Name<span class="text-danger ml-1">*</span>
                    :</label>
                <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                    <input type="text" class="form-control" id="c_name" name="name" value="{{ $customers->name }}"
                        required>
                </div>

                <label for="c_tin_number" class="col-sm-3 col-lg-2 col-form-label">Tin Number :</label>
                <div class="col-sm-9 col-lg-4">
                    <input type="text" class="form-control" id="c_tin_number" name="tin_number"
                        value="{{ $customers->tin_number }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="c_address" class="col-sm-3 col-lg-2 col-form-label">Address :</label>
                <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                    <input type="text" class="form-control" id="c_address" name="address"
                        value="{{ $customers->address }}" required>
                </div>
                <label for="c_city" class="col-sm-3 col-lg-2 col-form-label">City :</label>
                <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                    <input type="text" class="form-control" id="c_city" name="city" value="{{ $customers->city }}"
                        required>
                </div>
            </div>
            <div class="form-group row">
                <label for="c_country" class="col-sm-3 col-lg-2 col-form-label">Country :</label>
                <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                    <input type="text" class="form-control" id="c_country" name="country"
                        value="{{ $customers->country }}" required>
                </div>
                <label for="c_fax" class="col-sm-3 col-lg-2 col-form-label">Fax :</label>
                <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                    <input type="text" class="form-control" id="c_fax" name="fax" value="{{ $customers->fax }}">
                </div>

            </div>
            <div class="form-group row">
                <label for="c_phone_1" class="col-sm-3 col-lg-2 col-form-label">Phone # 1 :</label>
                <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                    <input type="text" class="form-control" id="c_phone_1" name="telephone_one"
                        value="{{ $customers->telephone_one }}" required>
                </div>

                <label for="c_phone_2" class="col-sm-3 col-lg-2 col-form-label">Phone # 2 :</label>
                <div class="col-sm-9 col-lg-4">
                    <input type="text" class="form-control" id="c_phone_2" name="telephone_two"
                        value="{{ $customers->telephone_two }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="c_picture" class="col-sm-3 col-lg-2 col-form-label">Picture :</label>
                <div class="col-sm-9 col-lg-4">
                    <input type="file" id="c_picture" name="image">
                </div>

                <label for="c_label" class="col-sm-3 col-lg-2 col-form-label">Label :</label>
                <div class="col-sm-9 col-lg-4">
                    <input type="text" class="form-control" id="c_label" name="label"
                        value="{{ $customers->label }}Label" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="c_email" class="col-sm-3 col-lg-2 col-form-label">E-mail :</label>
                <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                    <input type="email" class="form-control" id="c_email" name="email" value="{{ $customers->email }}"
                        required>
                </div>
                <label for="c_website" class="col-sm-3 col-lg-2 col-form-label">Website :</label>
                <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                    <input type="text" class="form-control" id="c_website" name="website"
                        value="{{ $customers->website }}">
                </div>
            </div>

            <h5>Contact Person</h5>
            <div class="form-group row">
                <label for="c_contact_person" class="col-sm-3 col-lg-2 col-form-label">Name :</label>
                <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                    <input type="text" class="form-control" id="c_contact_person" name="contact_person"
                        value="{{ $customers->contact_person }} " required>
                </div>
                <label for="c_mobile_number" class="col-sm-3 col-lg-2 col-form-label">Mobile # :</label>
                <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                    <input type="text" class="form-control" id="c_mobile_number" name="mobile_number"
                        value="{{ $customers->mobile_number }}" required>
                </div>
            </div>

            <div class="form-group row d-flex justify-content-end">
                <div class="form-check mr-3">
                    {{-- check if is_active is checked --}}
                    @if ($customers->is_active == "Yes")
                    <input class="form-check-input" type="checkbox" name="is_active" id="c_is_active" checked>
                    @else
                    <input class="form-check-input" type="checkbox" name="is_active" id="c_is_active">
                    @endif
                    <label class="form-check-label" for="c_is_active">Mark Customer as Active</label>
                </div>
            </div>
            <div class="row  mt-3 d-flex justify-content-between">
                {{-- delete --}}
                <div>
                    <button class="btn btn-danger mr-3 " type="button" data-toggle="modal"
                        data-target="#deleteConfirmationModel">Delete</button>
                    <a type="button" href="{{route('customers.')}}" class="btn btn-secondary">Back</a>
                </div>
                <button type="submit" class="btn btn-primary">Update Customer</button>
        </form>
    </div>
</div>
</div>


{{-- Customer Delete Modal --}}
<div class="modal fade" id="deleteConfirmationModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-customer-label">Delete Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">Are you sure to delete this record?</div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
                <form id="delete-frm" class="" action="" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
