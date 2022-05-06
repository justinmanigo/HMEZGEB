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
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(session()->has('danger'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session()->get('danger') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
       
        {{-- Page Content --}}
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                        <thead>
                            <th id="thead-actions">Actions</th>
                            <th>Customer Name</th>
                            <th>Tin #</th>
                            <th>City</th>
                            <th>Contact Person</th>
                            <th>Mobile #</th>
                            <th>Label</th>
                            <th>Balance</th>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                            <tr>
                                <td>
                                    
                                    <a type="button" class="btn btn-primary" href="{{ url('customer/'.$customer->id) }}">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-pen"></i>
                                        </span>
                                    </a>
                                    <button type="button" class="btn btn-danger "
                                    onClick='showModel({!! $customer->id !!})'>
                                    <span class="icon text-white-50">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    </button>
                                </td>
                                <td class="table-item-content"> {{$customer->name}} </td>
                                <td class="table-item-content"> {{$customer->tin_number}}</td>
                                <td class="table-item-content"> {{$customer->city}}</td>
                                <td class="table-item-content"> {{$customer->contact_person}}</td>
                                <td class="table-item-content"> {{$customer->mobile_number}}</td>
                                <td class="table-item-content"><span class="badge badge-primary"> {{$customer->label}}</span></td>
                                <td class="table-item-content"> </td>
                            </tr>
                            @endforeach
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

{{-- Customer new Modal --}}
<div class="modal fade" id="modal-customer" tabindex="-1" role="dialog" aria-labelledby="modal-customer-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-customer-label">New Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
                <form id="form-customer" action="/customer" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                    <h5>Customer</h5>
                    <div class="form-group row">
                        <label for="c_name" class="col-sm-3 col-lg-2 col-form-label">Name<span class="text-danger ml-1">*</span> :</label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="c_name" name="name" placeholder="" required>
                        </div>

                        <label for="c_tin_number" class="col-sm-3 col-lg-2 col-form-label">Tin Number :</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="text" class="form-control" id="c_tin_number" name="tin_number" placeholder="" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="c_address" class="col-sm-3 col-lg-2 col-form-label">Address :</label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="c_address" name="address" placeholder="" required>
                        </div>
                        <label for="c_city" class="col-sm-3 col-lg-2 col-form-label">City :</label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="c_city" name="city" placeholder="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="c_country" class="col-sm-3 col-lg-2 col-form-label">Country :</label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="c_country" name="country" placeholder="" required>
                        </div>
                        <label for="c_fax" class="col-sm-3 col-lg-2 col-form-label">Fax :</label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="c_fax" name="fax" placeholder="">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="c_phone_1" class="col-sm-3 col-lg-2 col-form-label">Phone # 1 :</label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="c_phone_1" name="telephone_one" placeholder="" required>
                        </div>

                        <label for="c_phone_2" class="col-sm-3 col-lg-2 col-form-label">Phone # 2 :</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="text" class="form-control" id="c_phone_2" name="telephone_two" placeholder="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="c_picture" class="col-sm-3 col-lg-2 col-form-label">Picture :</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="file" id="c_picture" name="image">
                        </div>

                        <label for="c_label" class="col-sm-3 col-lg-2 col-form-label">Label :</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="text" class="form-control" id="c_label" name="label" placeholder="Label" required>
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="c_email" class="col-sm-3 col-lg-2 col-form-label">E-mail :</label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="c_email" name="email" placeholder="" required>
                        </div>
                        <label for="c_website" class="col-sm-3 col-lg-2 col-form-label">Website :</label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="c_website" name="website" placeholder="">
                        </div>
                    </div>

                    <h5>Contact Person</h5>
                    <div class="form-group row">
                        <label for="c_contact_person" class="col-sm-3 col-lg-2 col-form-label">Name :</label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="c_contact_person" name="contact_person" placeholder=" " required>
                        </div>
                        <label for="c_mobile_number" class="col-sm-3 col-lg-2 col-form-label">Mobile # :</label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="c_mobile_number" name="mobile_number" placeholder="" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-check mr-3">
                        <input class="form-check-input" id="c_is_active" type="checkbox" value="" name="is_active">
                        <label class="form-check-label" for="c_is_active">Mark Customer as Active</label>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" >Save Customer</button>
                </div>
                </form>
        </div>
    </div>
</div>
{{-- Customer Delete Modal --}}
<div class="modal fade" id="deleteConfirmationModel" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel">
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
				<button type="button" class="btn btn-default" onClick="dismissModel()">Cancel</button>
				<form id="delete-frm" class="" action="" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger">Delete</button>
                </form>
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

 <script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

 <script>
    function showModel(id) {
        var frmDelete = document.getElementById("delete-frm");
        frmDelete.action = 'customer/'+id;
        var confirmationModal = document.getElementById("deleteConfirmationModel");
        confirmationModal.style.display = 'block';
        confirmationModal.classList.remove('fade');
        confirmationModal.classList.add('show');
    }
    
    function dismissModel() {
        var confirmationModal = document.getElementById("deleteConfirmationModel");
        confirmationModal.style.display = 'none';
        confirmationModal.classList.remove('show');
        confirmationModal.classList.add('fade');
    }
    </script>
@endsection