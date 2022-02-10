@extends('template.index')

@push('styles')
 {{-- <link rel="stylesheet" href="{{asset('css/.css')}}" /> --}}
@endpush

@section('content')

<div class="container">
    <div class="d-sm-flex align-items-start justify-content-between mb-2">
        <h1>Pocketdevs</h1>
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
        <form action="">
            <div class="row my-2">
                <div class="col">
                    <label for="#">Vendor Name</label>
                    <input type="text" class="form-control" value="Pocketdevs">
                </div>
                <div class="col">
                    <label for="#">Address</label>
                    <input type="text" class="form-control" value="Cebu City">
                </div>
            </div>
            <div class="row my-2">
                <div class="col">
                    <label for="#">City</label>
                    <input type="text" value="Cebu" class="form-control">
                </div>
                <div class="col">
                    <label for="#">Country</label>
                    <input type="text" value="Philippines" class="form-control">
                </div>
                <div class="col">
                    <label for="#">Mobile number</label>
                    <input type="number" value="09123851225" class="form-control">
                </div>
            </div>
            <div class="row my-2">
                <div class="col">
                    <label for="#">Contact Person</label>
                    <input type="text" class="form-control" value="Justin Manigo">
                </div>
                <div class="col-3">
                    <label for="#">Phone one</label>
                    <input type="number" class="form-control" value="092173640">
                </div>
                <div class="col-3">
                    <label for="#">Phone two</label>
                    <input type="number" class="form-control" value="0003571479">
                </div>
            </div>
            <div class="row my-2">
                <div class="col">
                    <label for="#">TIN number</label>
                    <input type="number" class="form-control" value="092173640">
                </div>
                <div class="col">
                    <label for="#">FAX</label>
                    <input type="number" class="form-control" value="0003571479">
                </div>
            </div>
            <div class="row my-2">
                <div class="col">
                    <label for="#">Email</label>
                    <input type="email" class="form-control" value="pocketdevs@example.com.ph">
                </div>
                <div class="col">
                    <label for="#">Website</label>
                    <input type="text" class="form-control" value="pocketdevs.ph">
                </div>
            </div>
            <div class="row d-flex justify-content-end mt-3">
                <div>
                    <button class="btn btn-secondary mx-1">Edit</button>
                    <button class="btn btn-danger mr-3">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection