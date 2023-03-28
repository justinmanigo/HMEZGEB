@extends('template.index')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between mb-3">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <button type="button" class="btn btn-primary" href="javascript:void(0)" data-toggle="modal"
                    data-target="#new_vendor_modal">
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
            </div>
            <div class="mt-2 mb-0 pb-0">
                <h5 class="pb-0 mb-0">
                    Account Payable:
                    <span class="badge badge-warning pb-1">Active: {{$count}}</span>
                    <span class="badge badge-warning mr-2 pb-1">{{number_format($total_balance,2)}}</span>
                    <span class="badge badge-danger pb-1">Overdue: {{$count_overdue}}</span>
                    <span class="badge badge-danger pb-1">{{number_format($total_balance_overdue,2)}}</span>
                </h5>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <!-- add search input group -->
                <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                    <form id="vendors-search-form">
                        <div class="input-group mr-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="search-addon"><i class="fas fa-search"></i></span>
                            </div>
                            <input id="vendors-search-input" type="text" class="form-control" placeholder="Search" aria-label="Search"
                                aria-describedby="search-addon">
                            <button id="vendors-search-submit" type="submit" class="btn btn-primary" disabled style="border-radius:0px 5px 5px 0px">
                                <span class="icon text-white-50">
                                    <i class="fas fa-search"></i>
                                </span>
                                <span class="text">Submit</span>
                            </button>
                        </div>
                    </form>
                    <div class="btn-group" role="group" aria-label="Second group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="vendors-page-number-label">Page 0 of 0</span>
                        </div>
                        <button id="vendors-prev" type="button" class="btn btn-secondary" disabled=true>Prev</button>
                        <button id="vendors-next" type="button" class="btn btn-secondary" disabled=true>Next</button>
                    </div>
                </div>

                {{-- Transaction Contents --}}
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <th>ID</th>
                            <th>Vendor Name</th>
                            <th>Tin #</th>
                            <th class="text-right">Balance</th>
                            <th width="160px">Actions</th>
                        </thead>
                        <tbody id="vendors-list">
                            <!-- JS will populate this -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- MODALS --}}

{{-- New Vendor --}}
<div class="modal fade" id="new_vendor_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <img class="mr-5"
                        src="https://user-images.githubusercontent.com/75387615/156304203-f98fe8db-d7a4-409f-a83c-8221c88e6e80.jpg">
                    <p class="h3 pl-4 m-auto">Add New Vendor</p>
                    <a class="close" data-dismiss="modal">×</a>
                </div>
                <form  class="ajax-submit-updated" id="form-vendor" action="{{ route('vendors.vendors.store') }}" method="POST" enctype="multipart/form-data" data-message="Successfully created vendor." data-noreload="true" data-onsuccess="vendors_search" data-onsuccessparam="vendors_page_number_current" data-modal="new_vendor_modal">
                    @csrf
                    @include('vendors.vendors.forms.addVendorModal')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Vendor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- Import Modal --}}
<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="Modal Import Vendor">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-vendor-label">Import Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-import-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form-import" method="post" action="{{ route('vendors.import') }}" enctype="multipart/form-data">
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
                <button type="submit" class="btn btn-primary" id="i_submit_btn" form="form-import">Import Vendor</button>
            </div>
        </div>
    </div>
</div>

{{-- Export --}}

<div class="modal fade" id="modal-export" tabindex="-1" role="dialog" aria-labelledby="Modal Export Vendor">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-vendor-label">Export Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-export-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form-export" method="post" action="{{ route('vendors.export') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="e_type" class="col-12 col-lg-6 col-form-label">Type<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <select class="form-control" id="e_type" name="type" required>
                                <option value="csv">CSV</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="e_submit_btn" form="form-export">Export Vendor</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>


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
                <p>Are you sure you want to mail statements to this vendor?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a id="specificStatement" class="btn btn-primary">Send Mail</a>
            </div>
        </div>
    </div>
</div>



{{-- Vendor Delete Modal --}}
<div class="modal fade" id="deleteConfirmationModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-vendor-label">Delete Vendor</h5>
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

{{-- Print confirmation modal --}}
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
                <p>Are you sure you want to print deposit?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="" id="print-deposit" class="btn btn-primary" target="_blank">Print</a>
            </div>
        </div>
    </div>
</div>


<script>
    function deleteVendor(id) {

        $('#delete-frm').attr('action', "/vendors/vendors/" + id);
    }

    // add the file name only in file input field
    $('.custom-file-input').on('change', function() {
    var fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

</script>
<script src="/js/hoverable.js"></script>
<script src="/js/vendors/vendor/vendors_table.js"></script>
<script src="/js/vendors/vendor/table_actions.js"></script>
@endsection
