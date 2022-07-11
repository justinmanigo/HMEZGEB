@extends('template.index')
@section('content')
<div class="container">
    <div class="mb-2">
        <div class="row">
            <div class="col-md-6">
                <h3>From Account</h3>
                <h2>{{$transfers->fromAccount->chartOfAccount->account_name}}</h2>
            </div>
            <div class="col-md-6">
                <h3>To Account</h3>
                <h2>{{$transfers->toAccount->chartOfAccount->account_name}}</h2>
            </div>
        </div>
    </div>

    <div class="container card shadow px-4 py-3">
            <form action="{{route('transfers.transfer.update', $transfers->id)}}" id="form-deposit" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label for="te_reason" class="col-sm-3 col-lg-4 col-form-label">Reason</label>
                    <div class="col-sm-9 col-lg-12 mb-3 mb-lg-0">
                        <textarea class="form-control" id="te_reason" name="reason" rows="3">{{$transfers->reason}}</textarea>
                    </div>
                </div>

            <div class="row  mt-3 d-flex justify-content-between">
                {{-- delete void--}}
                <div>
                    @if($transfers->status == 'completed')
                    <button class="btn btn-danger mr-3 " type="button" data-toggle="modal"
                    data-target="#voidConfirmationModel">Void</button>
                    @else
                    <button class="btn btn-danger mr-3 " type="button" data-toggle="modal"
                        data-target="#deleteConfirmationModel">Delete</button>
                    @endif
                    <a type="button" href="{{route('transfers.transfer.index')}}" class="btn btn-secondary">Back</a>
                </div>
                <button type="submit" class="btn btn-primary">Update Information</button>
        </form>
    </div>
</div>
</div>

{{-- Void --}}
<div class="modal fade" id="voidConfirmationModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-customer-label">Void Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">Are you sure to void this record?</div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
                <form id="void-frm" class="" action="{{route('transfers.transfer.void',$transfers->id)}}" method="POST">
                    @csrf
                    <button class="btn btn-danger">Void</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
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
                <form id="delete-frm" class="" action="{{route('transfers.transfer.destroy',$transfers->id)}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

