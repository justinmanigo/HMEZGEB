@extends('template.index')
@section('content')

<div class="container">
    <div class="mb-2">
        <h1>{{$accounts->chartOfAccount->account_name}}</h1>
    </div>

    <div class="container card shadow px-4 py-3">
            {{-- success message --}}
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>

            </div>
        @endif
        {{-- error message --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
            </div>
        @endif
        <form id="form-customer" action="{{route('accounts.accounts.update',$accounts->id)}}" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <form action="{{route('accounts.accounts.store')}}" id="form-deposit" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label for="b_coa_number" class="col-sm-3 col-lg-2 col-form-label">Chart of Account Number<span class="text-danger ml-1">*</span></label>
                    <div class="col-sm-9 col-lg-6">
                        <input type="text" class="form-control" id="b_coa_number" name="coa_number" placeholder="XXXX" value="{{$accounts->chartOfAccount->chart_of_account_no}}"  required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="b_account_name" class="col-sm-3 col-lg-2 col-form-label">Bank Account Name<span class="text-danger ml-1">*</span></label>
                    <div class="col-sm-9 col-lg-6">
                        <input type="text" class="form-control" id="b_account_name" name="account_name" value="{{$accounts->chartOfAccount->account_name}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="b_account_number" class="col-sm-3 col-lg-2 col-form-label">Bank Account Number<span class="text-danger ml-1">*</span></label>
                    <div class="col-sm-9 col-lg-6">
                        <input type="text" class="form-control" id="b_account_number" name="bank_account_number" value="{{$accounts->bank_account_number}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="b_bank_branch" class="col-sm-3 col-lg-2 col-form-label">Bank Branch<span class="text-danger ml-1">*</span></label>
                    <div class="col-sm-9 col-lg-6">
                        <input type="text" class="form-control" id="b_bank_branch" name="bank_branch" value="{{$accounts->bank_branch}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="b_type" class="col-sm-3 col-lg-2 col-form-label">Bank Account Type<span class="text-danger ml-1">*</span></label>
                    <div class="col-sm-9 col-lg-6">
                        <select class="form-control" id="b_type" name="bank_account_type" required>
                            <option value='' selected disabled hidden>Choose Bank Account Type</option>
                            <option value="savings" {{$accounts->bank_account_type == 'savings' ? 'selected' : ''}}>Savings</option>
                            <option value="checking" {{$accounts->bank_account_type == 'checking' ? 'selected' : ''}}>Checking</option>
                        </select>
                    </div>
                </div>
        
        
            <div class="row  mt-3 d-flex justify-content-between">
                {{-- delete --}}
                <div>
                    <button class="btn btn-danger mr-3 " type="button" data-toggle="modal"
                        data-target="#deleteConfirmationModel">Delete</button>
                    <a type="button" href="{{route('accounts.accounts.index')}}" class="btn btn-secondary">Back</a>
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
                <form id="delete-frm" class="" action="{{route('accounts.accounts.destroy',$accounts->id)}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
