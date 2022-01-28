@extends('template.index')

@push('styles')
    <style>
        #content-card {
            border-radius:0px 0px 5px 5px;
        }
    </style>
@endpush

@section('content')
<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
    <div class="btn-group" role="group">
        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="icon text-white-50">
                <i class="fas fa-pen"></i>
            </span>
            <span class="text">New</span>
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="#">Receipt</a>
            <a class="dropdown-item" href="#">Advance Revenue</a>
            <a class="dropdown-item" href="#">Credit Receipt</a>
            <a class="dropdown-item" href="#">Proformat</a>
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

<ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="transactions-tab" data-toggle="tab" href="#transactions" role="tab" aria-controls="transactions" aria-selected="true">Transactions</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="proforma-tab" data-toggle="tab" href="#proforma" role="tab" aria-controls="proforma" aria-selected="false">Proforma</a>
    </li>
</ul>
<div class="card" id="content-card">
    <div class="card-body tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="transactions" role="tabpanel" aria-labelledby="transactions-tab">
            <h1>Transaction Contents</h1>
        </div>
        <div class="tab-pane fade" id="proforma" role="tabpanel" aria-labelledby="proforma-tab">
            <h1>Proforma Contents</h1>
        </div>
    </div>
</div>
@endsection