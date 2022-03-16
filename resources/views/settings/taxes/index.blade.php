@extends('template.index')

@push('styles')

@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
@endpush

@section('content')
<div class="d-sm-flex align-items-start justify-content-between mb-2">
    <h1>Taxes</h1>
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
        <div class="btn-group" role="group" >
            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="icon text-white-50">
                    <i class="fas fa-pen"></i>
                </span>
                <span class="text">New</span>
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <a role="button" class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-xl">Bill</a>
                <a role="button" class="dropdown-item" data-toggle="modal" data-target=".bd-purchaseOrder-modal-xl">Purchase Order</a>
            </div>
        </div>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-import">
            <span class="icon text-white-50">
                <i class="fas fa-file-import"></i>
            </span>
            <span class="text">Import</span>
        </button>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-export">
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
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered"  width="100%" cellspacing="0">
                <thead>
                    <th>S. No</th>
                    <th>Description</th>
                    <th>Tax Amount in %</th>
                </thead>
                <tbody>
                    <tr>
                        <td>1.</th></td>
                        <td>Tax Amount in %</td>
                        <td> 0.00%</td>
                    </tr>
                    <tr>
                        <td>2.</th></td>
                        <td>TOT</td>
                        <td> 2.00%</td>
                    </tr>
                    <tr>
                        <td>3.</th></td>
                        <td>VAT</td>
                        <td> 15.00%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
