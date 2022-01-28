@extends('template.index')

@push('styles')

@endpush

@section('content')
{{-- Button Group Navigation --}}
<div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-new-deposit">
        <span class="icon text-white-50">
            <i class="fas fa-pen"></i>
        </span>
        <span class="text">New</span>
    </button>   
</div>

{{-- Page Content --}}
<div class="card">
    <div class="card-body">
        <h1>Customers > Deposit</h1>
    </div>
</div>

{{-- Modals --}}
{{-- New Receipt --}}
<div class="modal fade" id="modal-new-deposit" tabindex="-1" role="dialog" aria-labelledby="modal-new-deposit-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-new-deposit-label">New Deposit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection