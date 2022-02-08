@extends('template.index')

@push('styles')
    <style>
        .table-item-content { 
        /** Equivalent to pt-3 */
        padding-top:1rem!important;
        }

        .thead-actions {
            /** Fixed width, increase if adding addt. buttons **/
            width:120px;
        }
        .content-card {
            border-radius:0px 0px 5px 5px;
        }

        .inputPrice::-webkit-inner-spin-button, .inputTax::-webkit-inner-spin-button,
        .inputPrice::-webkit-outer-spin-button, .inputTax::-webkit-outer-spin-button {
            -webkit-appearance: none; 
            margin: 0; 
        }

        input[type="checkbox"], label {
            cursor: pointer;
        }
    </style>
@endpush

@section('content')

<div class="row">

    {{-- Main Content Section --}}
    <div class="col-xl-12 col-lg-12 col-12">
     {{-- Button Group Navigation --}}
        <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
            <button type="button" class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-customer">
                <span class="icon text-white-50">
                    <i class="fas fa-pen"></i>
                </span>
                <span class="text">New</span>
            </button>
          
        </div>
        {{-- Button Group Navigation --}}
        {{-- <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="icon text-white-50">
                        <i class="fas fa-pen"></i>
                    </span>
                    <span class="text">New</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-receipt">Receipt</a>
                    <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-advance-revenue">Advance Revenue</a>
                    <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-credit-receipt">Credit Receipt</a>
                    <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-proforma">Proforma</a>
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
        </div> --}}

        {{-- Tab Navigation --}}
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="transactions-tab" data-toggle="tab" href="#transactions" role="tab" aria-controls="transactions" aria-selected="true">Transfer History</a>
            </li>
            {{-- <li class="nav-item" role="presentation">
                <a class="nav-link" id="proforma-tab" data-toggle="tab" href="#proforma" role="tab" aria-controls="proforma" aria-selected="false">Proforma</a>
            </li> --}}
        </ul>

        {{-- Tab Contents --}}
        <div class="card" class="content-card">
            <div class="card-body tab-content" id="myTabContent">
                {{-- Transaction Contents --}}
                <div class="tab-pane fade show active" id="transactions" role="tabpanel" aria-labelledby="transactions-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th class="thead-actions">Actions</th>
                                <th>Date</th>
                                <th>Transfer Id</th>
                                <th>Transfer From</th>
                                <th>Transfer To</th>
                                <th>Amount</th>
                                 
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-small btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button>
                                    </td>
                                    <td class="table-item-content">February 2, 2021</td>
                                    <td class="table-item-content">00001</td>
                                    <td class="table-item-content">PocketDevs</td>
                                    <td class="table-item-content">PocketDevs</td>
                                    <td class="table-item-content">Birr 1,000</td>
                                  
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Proforma Contents --}}
                <div class="tab-pane fade" id="proforma" role="tabpanel" aria-labelledby="proforma-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th class="thead-actions">Actions</th>
                                <th>Invoice Number</th>
                                <th>Customer Name</th>
                                <th>Date</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-small btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button>
                                    </td>
                                    <td class="table-item-content">1483681825</td>
                                    <td class="table-item-content">PocketDevs</td>
                                    <td class="table-item-content">01/31/2022</td>
                                    <td class="table-item-content">Birr 1,000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

   

</div>



{{-- Modals --}}

{{-- 
    KNOWN POTENTIAL PROBLEMS:
    > Modal Contents have similar IDs for its contents.
    POTENTIAL SOLUTIONS:
    > Update form on button click via JS.
--}}


{{-- Transfer Modal --}}
<div class="modal fade" id="modal-customer" tabindex="-1" role="dialog" aria-labelledby="modal-customer-label" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-customer-label">New Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-customer" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="c_name" class="col-sm-3 col-lg-4 col-form-label">Send From<span class="text-danger ml-1"></span></label>
                        <div class="col-sm-9 col-lg-12 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="c_name" name="name" placeholder="" required>
                        </div>

                        {{-- <label for="c_tin_number" class="col-sm-3 col-lg-2 col-form-label">Destination</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="text" class="form-control" id="c_tin_number" name="tin_number" placeholder="">
                        </div> --}}
                    </div>
                    <div class="form-group row">
                        <label for="c_address" class="col-sm-3 col-lg-4 col-form-label">Amount</label>
                        <div class="col-sm-9 col-lg-12 mb-3 mb-lg-0">
                            <input type="number" class="form-control" id="c_address" name="address" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="c_city" class="col-sm-3 col-lg-6 col-form-label">Destination Account</label>
                        <div class="col-sm-9 col-lg-12 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="c_city" name="city" placeholder="">
                        </div>

                       
                </form>
            </div>
            <div class="modal-footer">
                {{-- <div class="form-check mr-3">
                    <input class="form-check-input" id="c_is_active" type="checkbox" value="" name="is_active">
                    <label class="form-check-label" for="c_is_active">Mark Customer as Active</label>
                </div> --}}
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" form="modal-customer">Submit</button>
            </div>
        </div>
    </div>
</div>


{{-- STACK 2 > Select Customer --}}
{{-- To be planned carefully on how can this be implemented across 4 receipt types/modals. --}}
<div class="modal fade" id="modal-select-customer" tabindex="-1" role="dialog" aria-labelledby="modal-receipt-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-receipt-label">Select Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('receipt.forms.select_customer')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="sc_btn_select_customer">Select Customer</button>
            </div>
        </div>
    </div>
</div>

{{-- STACK 2 > Select Item (Inventory) --}}
{{-- To be planned carefully on how can this be implemented across 3 receipt types/modals. --}}
<div class="modal fade" id="modal-select-item" tabindex="-1" role="dialog" aria-labelledby="modal-receipt-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-receipt-label">Select Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('receipt.forms.select_item')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="si_btn_select_item">Select Item</button>
            </div>
        </div>
    </div>
</div>

@endsection