@extends('template.index')

@push('styles')
 {{-- <link rel="stylesheet" href="{{asset('css/.css')}}" /> --}}
@endpush

@section('content')

@foreach($individualVendors as $vendor):
<div class="container">
    <div class="d-sm-flex align-items-start justify-content-between mb-2">
        <h1>{{$vendor->name}}</h1>
        <!--- card for account payable--->
        <div class="col-xl-3 col-md-6 mb-4 border-1">
            <div class="card border-left-primary shadow h-100 pt-2">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                    Account Payable 
                    </div>
                </div>
                <div class="card-body">
                    <div class="row no-gutters d-flex align-items-center justify-content-around">
                        <div class="h6 mb-0">
                        <span class="font-weight-bold text-gray-800">$15,000</span><br>
                        <small>Active</small>
                        </div>
                        <div class="h6 mb-0">
                        <span class="font-weight-bold text-danger">$1,500</span><br>
                        <small>Over Due</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
    <div class="container card shadow px-4 py-3">
        <form action='{{ url("/individualVendor/$vendor->id") }}' method="POST" enctype="multipart/form-data">
        @CSRF    
        <div class="row my-2">
                <div class="col">
                    <label for="#">Vendor Name</label>
                    <input type="text" class="form-control" name="name" value="{{$vendor->name}}">
                </div>
                <div class="col">
                    <label for="#">Address</label>
                    <input type="text" class="form-control" name="address" value="{{$vendor->address}}">
                </div>
            </div>
            <div class="row my-2">
                <div class="col">
                    <label for="#">City</label>
                    <input type="text" value="{{$vendor->city}}" name="city" class="form-control">
                </div>
                <div class="col">
                    <label for="#">Country</label>
                    <input type="text" value="{{$vendor->country}}" name="country" class="form-control">
                </div>
                <div class="col">
                    <label for="#">Mobile number</label>
                    <input type="number" value="{{$vendor->mobile_number}}" name="mobile_number" class="form-control">
                </div>
            </div>
            <div class="row my-2">
                <div class="col">
                    <label for="#">Contact Person</label>
                    <input type="text" class="form-control" name="contact_person" value="{{$vendor->contact_person}}">
                </div>
                <div class="col-3">
                    <label for="#">Phone one</label>
                    <input type="number" class="form-control" name="telephone_one" value="{{$vendor->telephone_one}}">
                </div>
                <div class="col-3">
                    <label for="#">Phone two</label>
                    <input type="number" class="form-control" name="telephone_two" value="{{$vendor->telephone_two}}">
                </div>
            </div>
            <div class="row my-2">
                <div class="col">
                    <label for="#">TIN number</label>
                    <input type="number" class="form-control" name="tin_number" value="{{$vendor->tin_number}}">
                </div>
                <div class="col">
                    <label for="#">FAX</label>
                    <input type="number" class="form-control" name="fax" value="{{$vendor->fax}}">
                </div>
            </div>
            <div class="row my-2">
                <div class="col">
                    <label for="#">Email</label>
                    <input type="email" class="form-control" name="email" value="{{$vendor->email}}">
                </div>
                <div class="col">
                    <label for="#">Website</label>
                    <input type="text" class="form-control" name="website" value="{{$vendor->website}}">
                </div>
            </div>    
            <div class="row form-group mt-4">
                <label for="label" class="col-md-4 col-lg-2 col-form-label">Label:</label>
                <select name="label" class="form-control col-md-2 col-lg-2">
                    <option value="New" {{ $vendor->label == 'New' ? 'selected' : '' }}>New</option>
                    <option value="VIP"  {{ $vendor->label == 'VIP' ? 'selected' : '' }}>VIP</option>
                    <option value="ISP"  {{ $vendor->label == 'ISP' ? 'selected' : '' }}>ISP</option>
                </select>
                <label for="image" class="mx-3 col-form-label">Image:</label>
                <div class="input-group col-md-4 col-lg-4">
                    <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile03" name="image">
                    <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
                    </div>
                </div>
                <label for="is_active" class="col-form-label">Status:</label>
                <div class="form-check ml-5">
                    <div class="row">
                        <input class="form-check-input" type="radio" name="is_active" id="r_paymentType_credit" value="Yes" {{ $vendor->is_active == 'Yes' ? 'checked' : '' }}>
                        <label class="form-check-label" for="r_paymentType_credit">
                        Active
                        </label>
                    </div>
                    <div class="row">
                        <input class="form-check-input" type="radio" name="is_active" id="r_paymentType_cash" value="No" {{ $vendor->is_active == 'No' ? 'checked' : '' }}>
                        <label class="form-check-label" for="r_paymentType_cash">
                        Inactive
                        </label>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-end mt-3">
                <div>
                    <button class="btn btn-secondary mx-1" type="submit">Edit</button>
                    <button class="btn btn-danger mr-3 " type="button" data-toggle="modal" data-target="#deleteModal">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Warning Delete message -->
<form action="{{route('vendors.vendors.destroy' , $vendor->id) }}" method="post" enctype="multipart/form-data">
<div class="modal" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
@method('delete')
@CSRF  
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>Are you sure you want to this record?</h4>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Delete</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</form>
@endforeach
@endsection