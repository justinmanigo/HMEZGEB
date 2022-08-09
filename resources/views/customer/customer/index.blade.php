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
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-statements" >
                <span class="icon text-white-50">
                    <i class="fas fa-envelope"></i>
                </span>
                <span class="text">Mail Statements</span>
            </button>
        </div>
        
            {{-- Page Content --}}
            <div class="card shadow mb-4">
                <div class="card-body">
                    @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session()->get('error') }}
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
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                        <thead>
                            <th>Customer Name</th>
                            <th>Tin #</th>
                            <th>City</th>
                            <th>Contact Person</th>
                            <th>Mobile #</th>
                            <th>Label</th>
                            <th>Balance</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                            <tr>
                                    <td> {{$customer->name}} </td>
                                    <td> {{$customer->tin_number}}</td>
                                    <td> {{$customer->city}}</td>
                                    <td> {{$customer->contact_person}}</td>
                                    <td> {{$customer->mobile_number}}</td>
                                    <td><span class="badge badge-primary"> {{$customer->label}}</span></td>
                                    <td></td>
                                    <td>
                                        <a href="{{ route('customers.customers.edit', $customer->id) }}" class="btn btn-sm btn-icon btn-primary mb-1">
                                            <!-- edit -->
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </a>
                                        <button class="btn btn-sm btn-icon btn-secondary mb-1" disabled>
                                            <!-- print -->
                                            <span class="icon text-white-50">
                                                <i class="fas fa-print"></i>
                                            </span>
                                        </button>
                                        <button class="btn btn-sm btn-icon btn-secondary mb-1" id="individualMailStatement" data-toggle="modal" data-target="#modal-statement" onclick="addCustomerIdModal({{$customer->id}})">
                                            <!-- email -->
                                            <span class="icon text-white-50">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                        </button>
                                        <button class="btn btn-sm btn-icon btn-danger mb-1" disabled>
                                            <!-- delete -->
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button>
                                    </td>
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
            
                <form id="form-customer" action="{{route('customers.customers.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                    <h5>Customer</h5>
                    <div class="form-group row">
                        <label for="c_name" class="col-sm-3 col-lg-2 col-form-label">Name:</label>
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
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file" name="image">
                                <label class="custom-file-label" for="file">Choose file</label>
                            </div>
                        </div>

                        <label for="c_label" class="col-sm-3 col-lg-2 col-form-label">Label :</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="text" class="form-control" id="c_label" name="label" required>
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
                <form id="form-import" action="{{route('customers.import')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row container">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" name="file" required>
                            <label class="custom-file-label" for="file">Choose file</label>
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
                <form id="form-export" action="{{route('customers.export')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="e_file_type" class="col-sm-4 col-form-label">File Type<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" id="e_file_type" name="file_type" required>
                                <option value="csv">CSV</option>
                                <option value="pdf">PDF</option>
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

{{-- statement confirmation modal --}}

<div class="modal fade" id="modal-statements" tabindex="-1" role="dialog" aria-labelledby="modal-statements-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-statements-label">Confirm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to mail statements to customers?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="{{route('customers.statements.mail')}}" class="btn btn-primary">Send Mail</a>
            </div>
        </div>
    </div>
</div>

{{-- specific statement modal --}}

<div class="modal fade" id="modal-statement" tabindex="-1" role="dialog" aria-labelledby="modal-statement-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-statement-label">Confirm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to mail statements to this customer?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a id="specificStatement" class="btn btn-primary">Send Mail</a>
            </div>
        </div>
    </div>
</div>




 <script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

 <script>
        function addCustomerIdModal(id) {
            $('#specificStatement').attr('href', "/customers/mail/statement/" + id);
        }
        // add <span class="text-danger ml-1">*</span> after the label of required input
        $('label').each(function(){
            if($(this).attr('for') != ''){
                if($('#'+$(this).attr('for')).prop('required')){
                    $(this).append(' <span class="text-danger ml-1">*</span>');
                }
            }
        });
        // add the file name only in file input field
        $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    

      $(document).ready(function () {
            $('#dataTables').DataTable();
            $('.dataTables_filter').addClass('pull-right');
        });
    </script>
@endsection