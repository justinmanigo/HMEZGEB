@extends('template.index')

@push('styles')

@endpush

@section('content')
{{-- Button Group Navigation --}}
<div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-new-customer">
        <span class="icon text-white-50">
            <i class="fas fa-pen"></i>
        </span>
        <span class="text">New</span>
    </button>
    <button type="button" class="btn btn-secondary">
        <span class="icon text-white-50">
            <i class="fas fa-file-import"></i>
        </span>
        <span class="text">Import</span>
    </button>
    <button type="button" class="btn btn-secondary">
        <span class="icon text-white-50">
            <i class="fas fa-download"></i>
        </span>
        <span class="text">Export</span>
    </button>
    <button type="button" class="btn btn-secondary">
        <span class="icon text-white-50">
            <i class="fas fa-download"></i>
        </span>
        <span class="text">Download Excel Format</span>
    </button>    
</div>

{{-- Page Content --}}
<div class="card">
    <div class="card-body">
        <h1>Customers > Customer</h1>
    </div>
</div>

{{-- Modals --}}
{{-- New Receipt --}}
<div class="modal fade" id="modal-new-customer" tabindex="-1" role="dialog" aria-labelledby="modal-new-customer-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-new-customer-label">New Customer</h5>
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