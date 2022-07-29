@extends('template.index')

@push('styles')

@endpush

@section('content')

<div class="row">
    <div class="col-xl-10 col-lg-9 col-12">
        <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
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

        <div class="card shadow mb-4">
            <div class="card-body">
                {{-- success error --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" id="dataTables" cellspacing="100">
                        <thead>
                            <tr>
                                <th>Vendor Name</th>
                                <th>TIN#</th>
                                <th>City</th>
                                <th>Contact Person</th>
                                <th>Mobile#</th>
                                <th>Label</th>
                                <th>Balance</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($vendors as $vendor)
                            <tr onclick="window.location='{{ route('vendors.vendors.edit', $vendor->id) }}'">
                                <td>{{$vendor->name}}</td>
                                <td>{{$vendor->tin_number}}</td>
                                <td>{{$vendor->city}}</td>
                                <td>{{$vendor->contact_person}}</td>
                                <td>{{$vendor->mobile_number}}</td>
                                <td>
                                    @if($vendor->label=='VIP')
                                    <span class="badge badge-primary">{{$vendor->label}}</span>
                                    @endif
                                    @if($vendor->label=='ISP')
                                    <span class="badge badge-info">{{$vendor->label}}</span>
                                    @endif
                                    @if($vendor->label=='New')
                                    <span class="badge badge-secondary">{{$vendor->label}}</span>
                                    @endif
                                </td>
                                <td>12,000.00</td>
                            </tr>
                            @endforeach
                            <!-- <tr onclick="window.location='/individualVendor'">
                            <td>Pocketteams</td>
                            <td>362162217</td>
                            <td>Cebu</td>
                            <td>John Doe</td>
                            <td>09208642910</td>
                            <td><span class="badge badge-info">ISP</span></td>
                            <td>1,000.00</td>
                        </tr>
                        <tr onclick="window.location='/individualVendor'">
                            <td>IKEA</td>
                            <td>521677826</td>
                            <td>Manila</td>
                            <td>Jane Doe</td>
                            <td>09084378189</td>
                            <td><span class="badge badge-secondary">New</span></td>
                            <td>8,000.00</td>
                        </tr> -->
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
                <form action="{{ route('vendors.vendors.store') }}" method="POST" enctype="multipart/form-data">
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
                <h5 class="modal-title" id="modal-customer-label">Import Vendor</h5>
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
                <h5 class="modal-title" id="modal-customer-label">Export Vendor</h5>
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

<script>
    $(document).ready(function () {
            $('#dataTables').DataTable();
            $('.dataTables_filter').addClass('pull-right');
        });

    // add the file name only in file input field
    $('.custom-file-input').on('change', function() {
    var fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

        //$('#details').trumbowyg();
        //$('#features').trumbowyg();

</script>
@endsection