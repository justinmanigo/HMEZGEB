@extends('template.index')

@push('styles')

@endpush

@section('content')
<div class="card col-lg-9 col-xl-8 mb-3">
    <div class="card-body">
        <h1 class="mb-3">New Customer</h1>
        <form id="form-new-customer" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="inputCustomerName" class="col-sm-3 col-form-label">Customer Name<span class="text-danger ml-1">*</span></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="inputCustomerName" placeholder="" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputTinNumber" class="col-sm-3 col-form-label">Tin Number</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="inputTinNumber" placeholder="">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputAddress" class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="inputAddress" placeholder="">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputCity" class="col-sm-3 col-form-label">City</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="inputCity" placeholder="">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputCountry" class="col-sm-3 col-form-label">Country</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="inputCountry" placeholder="">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPhone1" class="col-sm-3 col-form-label">Phone 1</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="inputPhone1" placeholder="">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPhone2" class="col-sm-3 col-form-label">Phone 2</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="inputPhone2" placeholder="">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputFax" class="col-sm-3 col-form-label">Fax</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="inputFax" placeholder="">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputMobileNumber" class="col-sm-3 col-form-label">Mobile Number</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="inputMobileNumber" placeholder="">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputContactPerson" class="col-sm-3 col-form-label">Contact Person</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="inputContactPerson" placeholder="">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail" class="col-sm-3 col-form-label">E-mail</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="inputEmail" placeholder="">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputWebsite" class="col-sm-3 col-form-label">Website</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="inputWebsite" placeholder="">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPicture" class="col-sm-3 col-form-label">Picture</label>
                <div class="col-sm-9">
                    <input type="file" id="inputPicture">
                </div>
            </div>
            <div class="form-check">
                <input class="form-check-input" id="inputActive" type="checkbox" value="">
                <label class="form-check-label" for="inputActive">Mark Customer as Active</label>
            </div>
        </form>
    </div>
    <div class="card-footer bg-white">
        <button type="button" class="btn btn-primary">Save Customer</button>
        <a role="button" class="btn btn-secondary" href="{{ route('customer.index') }}">Cancel</a>
    </div>
</div>
@endsection