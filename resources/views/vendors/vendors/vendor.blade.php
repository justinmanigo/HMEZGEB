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
            <a href="{{route('vendors.vendors.export.csv')}}" class="btn btn-secondary">
                <span class="icon text-white-50">
                    <i class="fas fa-download"></i>
                </span>
                <span class="text">Export</span>
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
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
                            <tr onclick="window.location='{{ route('vendors.vendors.edit',$vendor->id) }}'">
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
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
            $('#dataTables').DataTable();
            $('.dataTables_filter').addClass('pull-right');
        });

        //$('#details').trumbowyg();
        //$('#features').trumbowyg();

</script>
@endsection