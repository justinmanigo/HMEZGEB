@extends('template.index')

@push('styles')
    <style>
        #content-card {
            border-radius:0px 0px 5px 5px;
        }
    </style>
@endpush

@section('content')
{{-- Button Group Navigation --}}
<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
    <div class="btn-group" role="group">
        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="icon text-white-50">
                <i class="fas fa-pen"></i>
            </span>
            <span class="text">New</span>
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="javascript:void(0)" type="button" data-toggle="modal" data-target="#modal-new-receipt">Receipt</a>
            <a class="dropdown-item" href="javascript:void(0)" type="button" data-toggle="modal" data-target="#modal-new-advance-revenue">Advance Revenue</a>
            <a class="dropdown-item" href="javascript:void(0)" type="button" data-toggle="modal" data-target="#modal-new-credit-receipt">Credit Receipt</a>
            <a class="dropdown-item" href="javascript:void(0)" type="button" data-toggle="modal" data-target="#modal-new-proforma">Proforma</a>
        </div>
    </div>
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

{{-- Tab Navigation --}}
<ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="transactions-tab" data-toggle="tab" href="#transactions" role="tab" aria-controls="transactions" aria-selected="true">Transactions</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="proforma-tab" data-toggle="tab" href="#proforma" role="tab" aria-controls="proforma" aria-selected="false">Proforma</a>
    </li>
</ul>

{{-- Tab Contents --}}
<div class="card" id="content-card">
    <div class="card-body tab-content" id="myTabContent">
        {{-- Transaction Contents --}}
        <div class="tab-pane fade show active" id="transactions" role="tabpanel" aria-labelledby="transactions-tab">
            <h1>Transaction Contents</h1>
        </div>
        {{-- Proforma Contents --}}
        <div class="tab-pane fade" id="proforma" role="tabpanel" aria-labelledby="proforma-tab">
            <h1>Proforma Contents</h1>
        </div>
    </div>
</div>

{{-- Modals --}}
{{-- New Receipt --}}
<div class="modal fade" id="modal-new-receipt" tabindex="-1" role="dialog" aria-labelledby="modal-new-receipt-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-new-receipt-label">New Receipt</h5>
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

{{-- New Advance Revenue --}}
<div class="modal fade" id="modal-new-advance-revenue" tabindex="-1" role="dialog" aria-labelledby="modal-new-advance-revenue-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-new-advance-revenue-label">New Advance Revenue</h5>
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

{{-- New Credit Receipt --}}
<div class="modal fade" id="modal-new-credit-receipt" tabindex="-1" role="dialog" aria-labelledby="modal-new-credit-receipt-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-new-credit-receipt-label">New Advance Revenue</h5>
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

{{-- New Proforma --}}
<div class="modal fade" id="modal-new-proforma" tabindex="-1" role="dialog" aria-labelledby="modal-new-proforma-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-new-proforma-label">New Advance Revenue</h5>
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