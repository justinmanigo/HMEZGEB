@extends('template.index')

@section('content')

<div class="row">

    {{-- Main Content Section --}}
    <div class="col-12">
        <!-- create flex that allows two columns that aligns against each other -->
        <div class="d-flex justify-content-between mb-3">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <button type="button" class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-customer">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">New Customer</span>
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
                {{-- <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-statements" >
                    <span class="icon text-white-50">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <span class="text">Mail Statements</span>
                </button> --}}
            </div>
            <div class="mt-2 mb-0 pb-0">
                <h5 class="pb-0 mb-0">
                    Account Receivable:
                    <span class="badge badge-warning pb-1">Active: 0</span>
                    <span class="badge badge-warning mr-2 pb-1">0.00</span>
                    <span class="badge badge-danger pb-1">Overdue: 0</span>
                    <span class="badge badge-danger pb-1">0.00 </span>
                </h5>
            </div>
            {{-- <h1 class="h3 text-gray-800">Customers</h1> --}}
        </div>

        {{-- Page Content --}}
        <div class="card mb-4">
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
            <!-- add search input group -->
            <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                <form id="customers-search-form">
                    <div class="input-group mr-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="search-addon"><i class="fas fa-search"></i></span>
                        </div>
                        <input id="customers-search-input" type="text" class="form-control" placeholder="Search" aria-label="Search"
                            aria-describedby="search-addon">
                        <button id="customers-search-submit" type="submit" class="btn btn-primary" disabled style="border-radius:0px 5px 5px 0px">
                            <span class="icon text-white-50">
                                <i class="fas fa-search"></i>
                            </span>
                            <span class="text">Submit</span>
                        </button>
                    </div>
                </form>
                <div class="btn-group" role="group" aria-label="Second group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="customers-page-number-label">Page 0 of 0</span>
                    </div>
                    <button id="customers-prev" type="button" class="btn btn-secondary" disabled=true>Prev</button>
                    <button id="customers-next" type="button" class="btn btn-secondary" disabled=true>Next</button>
                </div>
            </div>

            {{-- Transaction Contents --}}
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <th>ID</th>
                        <th>Customer Name</th>
                        <th>Tin #</th>
                        <th class="text-right">Balance</th>
                        <th width="160px">Actions</th>
                    </thead>
                    <tbody id="customers-list">
                        <!-- JS will populate this -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- <form class="ajax-submit-updated" action="{{ url('/customers/receipts/sales') }}" id="form-sale" method="post" enctype="multipart/form-data" data-message="Successfully created sale." data-noreload="true" data-onsuccess="sale_search" data-onsuccessparam="sales_page_number_current" data-modal="modal-sale"> --}}

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

                <form class="ajax-submit-updated" id="form-customer" action="{{route('customers.customers.store')}}" method="post" enctype="multipart/form-data" data-message="Successfully created customer." data-noreload="true" data-onsuccess="customers_search" data-onsuccessparam="customers_page_number_current" data-modal="modal-customer">
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
                            {{-- <label for="c_picture" class="col-sm-3 col-lg-2 col-form-label">Picture :</label>
                            <div class="col-sm-9 col-lg-4">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="file" name="image">
                                    <label class="custom-file-label" for="file">Choose file</label>
                                </div>
                            </div> --}}

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
                            <input class="form-check-input" id="c_is_active" type="checkbox" name="is_active">
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

{{-- Print confirmation Modal --}}
<div class="modal fade" id="modal-print" tabindex="-1" role="dialog" aria-labelledby="modal-print-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-print-label">Confirm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to print customer statement?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a id="print-statement" class="btn btn-primary" target="_blank">Print</a>
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



{{-- Customer Delete Modal --}}
<div class="modal fade" id="deleteConfirmationModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
                <form id="delete-frm" class="" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>



 <script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

 <script>
        function deleteCustomer(id) {

            $('#delete-frm').attr('action', "/customers/customers/" + id);
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
    </script>

    <script src="/js/hoverable.js"></script>
    <script src="/js/customer/customer/customers_table.js"></script>
    <script src="/js/customer/customer/table_actions.js"></script>
@endsection
