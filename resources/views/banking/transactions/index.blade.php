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
            {{-- <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-import">
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
            </button> --}}
           

           
                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="icon text-white-50">
                        <i class="fas fa-download"></i>
                    </span>
                    <span class="text">Download</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-receipt">Excel</a>
                    <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-advance-revenue">PDF</a>
                    
                </div>
            
        </div>

        {{-- Page Content --}}
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                        <thead>
                          
                            <th>Deposit Date</th>
                            <th>Deposit ID</th>
                            <th>Account</th>
                            <th>Label</th>
                            <th>Amount</th>
                            <th id="thead-actions">Actions</th>
                        </thead>
                        <tbody>
                            <tr>  	 	 	 	 
                                <td class="table-item-content">01/31/2022</td>
                                <td class="table-item-content">DS003</td>
                                <td class="table-item-content">Commercial Bank</td>
                                <td class="table-item-content">Self</td>
                                <td class="table-item-content">20,000.00</td>
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
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-customer-label">New Bank ACcount</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-customer" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="c_name" class="col-sm-3 col-lg-2 col-form-label">Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="c_name" name="name" placeholder="" required>
                        </div>

                        <label for="c_tin_number" class="col-sm-3 col-lg-2 col-form-label">Tin Number</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="text" class="form-control" id="c_tin_number" name="tin_number" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="c_address" class="col-sm-3 col-lg-2 col-form-label">Address</label>
                        <div class="col-sm-9 col-lg-10">
                            <input type="text" class="form-control" id="c_address" name="address" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="c_city" class="col-sm-3 col-lg-2 col-form-label">City</label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="c_city" name="city" placeholder="">
                        </div>

                        <label for="c_country" class="col-sm-3 col-lg-2 col-form-label">Country</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="text" class="form-control" id="c_country" name="country" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="c_phone_1" class="col-sm-3 col-lg-2 col-form-label">Phone 1</label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="c_phone_1" name="phone_1" placeholder="">
                        </div>

                        <label for="c_phone_2" class="col-sm-3 col-lg-2 col-form-label">Phone 2</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="text" class="form-control" id="c_phone_2" name="phone_2" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="c_fax" class="col-sm-3 col-lg-2 col-form-label">Fax</label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="c_fax" name="fax" placeholder="">
                        </div>

                        <label for="c_mobile_number" class="col-sm-3 col-lg-2 col-form-label">Mobile Number</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="text" class="form-control" id="c_mobile_number" name="mobile_number" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="c_contact_person" class="col-sm-2 col-form-label">Contact Person</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="c_contact_person" name="contact_person" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="c_email" class="col-sm-2 col-form-label">E-mail</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="c_email" name="email" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="c_website" class="col-sm-2 col-form-label">Website</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="c_website" name="website" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="c_picture" class="col-sm-2 col-form-label">Picture</label>
                        <div class="col-sm-10">
                            <input type="file" id="c_picture" name="picture">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="form-check mr-3">
                    <input class="form-check-input" id="c_is_active" type="checkbox" value="" name="is_active">
                    <label class="form-check-label" for="c_is_active">Mark Customer as Active</label>
                </div>
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
                        <label for="i_file" class="col-sm-4 col-form-label">File<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-8">
                            <input type="file" id="i_file" name="file" class="mt-1" required>
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
                        <label for="e_file_type" class="col-sm-4 col-form-label">File Type<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" id="e_file_type" name="file_type" required>
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
<script>
    $(document).ready(function () {
        $('#dataTables').DataTable();
        $('.dataTables_filter').addClass('pull-right');
    });
</script>
@endsection