@extends('template.index')

@push('styles')
<style>
    .table-item-content { 
        /** Equivalent to pt-3 */
        padding-top:1rem!important;
    }

    #thead-actions {
        /** Fixed width, increase if adding addt. buttons **/
        width:120px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> 
@endpush

@section('content')

<div class="row">

    {{-- Main Content Section --}}
    <div class="col-xl-10 col-lg-9 col-12">
        {{-- Button Group Navigation --}}
        <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
            <button type="button" class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-customer">
                <span class="icon text-white-50">
                    <i class="fas fa-pen"></i>
                </span>
                <span class="text">New</span>
            </button>
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

        {{-- Page Content --}}
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th id="thead-actions">Actions</th>
                            <th>Customer Name</th>
                            <th>Address</th>
                            <th>Telephone</th>
                            <th>Account Receivable</th>
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
                                <td class="table-item-content">PocketDevs</td>
                                <td class="table-item-content">Cebu City, Philippines</td>
                                <td class="table-item-content">+63 (012) 3456</td>
                                <td class="table-item-content">Birr 1,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar Content Section --}}
    <div class="col-xl-2 col-lg-3 d-none d-lg-block">
        <h4 class="">Account Receivable</h4>
        {{-- Account Receivable Active --}}
        <div class="mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Birr 40,000</div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                2 Active</div>
                        </div>
                        <div class="col-auto">
                            {{-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Account Receivable Overdue --}}
        <div class="mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Birr 215,000</div>
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                5 Over Due</div>
                        </div>
                        <div class="col-auto">
                            {{-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Customer Modal --}}
<div class="modal fade" id="modal-customer" tabindex="-1" role="dialog" aria-labelledby="modal-customer-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                        <label for="inputCustomerName" class="col-sm-3 col-form-label">Customer Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputCustomerName" name="name" placeholder="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputTinNumber" class="col-sm-3 col-form-label">Tin Number</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputTinNumber" name="tin_number" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputAddress" class="col-sm-3 col-form-label">Address</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputAddress" name="address" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputCity" class="col-sm-3 col-form-label">City</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputCity" name="city" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputCountry" class="col-sm-3 col-form-label">Country</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputCountry" name="country" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPhone1" class="col-sm-3 col-form-label">Phone 1</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputPhone1" name="phone_1" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPhone2" class="col-sm-3 col-form-label">Phone 2</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputPhone2" name="phone_2" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputFax" class="col-sm-3 col-form-label">Fax</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputFax" name="fax" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputMobileNumber" class="col-sm-3 col-form-label">Mobile Number</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputMobileNumber" name="mobile_number" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputContactPerson" class="col-sm-3 col-form-label">Contact Person</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputContactPerson" name="contact_person" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">E-mail</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail" name="email" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputWebsite" class="col-sm-3 col-form-label">Website</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputWebsite" name="website" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPicture" class="col-sm-3 col-form-label">Picture</label>
                        <div class="col-sm-9">
                            <input type="file" id="inputPicture" name="picture">
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" id="inputActive" type="checkbox" value="" name="is_active">
                        <label class="form-check-label" for="inputActive">Mark Customer as Active</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" form="modal-customer">Save Customer</button>
            </div>
        </div>
    </div>
</div>

{{-- Import --}}
<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="modal-import-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-import-label">Import Customers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-import" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="revenue_type" class="col-sm-4 col-form-label">File<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-8">
                            <input type="file" id="file" name="file" class="mt-1" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-import">Import Customers</button>
            </div>
        </div>
    </div>
</div>

{{-- Export --}}
<div class="modal fade" id="modal-export" tabindex="-1" role="dialog" aria-labelledby="modal-export-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-export-label">Export Customers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-export" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="file_type" class="col-sm-4 col-form-label">File Type<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" id="file_type" name="file_type" required>
                                <option>HTML</option>
                                <option>PDF</option>
                                <option>CSV</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-export">Export Customers</button>
            </div>
        </div>
    </div>
</div>
@endsection