@extends('template.index')

@push('styles')
 {{-- <link rel="stylesheet" href="{{asset('css/.css')}}" /> --}}
 
@endpush

@section('content')

<div class="wrapper">

<div class="d-sm-flex align-items-start justify-content-between mb-2">
    <h1 class="h3 mb-0 text-gray-800">Vendors</h1>
    <!--- card for account payable--->

    <div class="col-xl-3 col-md-6 mb-4 border-1">
        <div class="card border-left-primary shadow h-100 pt-2">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                Account Payable 
                </div>
            </div>
            <div class="card-body">
                <div class="row no-gutters d-flex align-items-center justify-content-around">
                    <div class="h6 mb-0">
                    <span class="font-weight-bold text-gray-800">$40,000</span><br>
                    <small>Active</small>
                    </div>
                    <div class="h6 mb-0">
                    <span class="font-weight-bold text-danger">$3,500</span><br>
                    <small>Over Due</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center  justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary pr-3">List of Vendors</h6>

    <!--------BUTTONS---->
    <div class="d-flex justify-content-around">
    <!--------add vendor modal---->
    <button type="button" class="btn btn-info mx-1" data-toggle="modal" data-target=".bd-example-modal-xl">Add vendor</button>
    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header d-flex">
                        <h3>Add Vendor</h3>
                        <a class="close" data-dismiss="modal">×</a>
                    </div>
                    <form id="contactForm" name="contact" role="form">
                        <div class="modal-body h6">				
                            <div class="form-group">
                                <label for="name">Vendor name:</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Address:</label>
                                <input type="text" name="address" class="form-control">
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label for="email">City:</label>
                                    <input type="text" name="city" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="email">Country:</label>
                                    <input type="text" name="country" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="email">Email:</label>
                                    <input type="email" name="email" class="form-control">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label for="email">Phone number 1:</label>
                                    <input type="text" name="phone1" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="email">Phone number 2:</label>
                                    <input type="text" name="phone1" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="email">TIN number:</label>
                                    <input type="text" name="tinNum" class="form-control">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label for="email">FAX:</label>
                                    <input type="text" name="fax" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="email">Mobile number:</label>
                                    <input type="text" name="mobile_num" class="form-control">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <label for="email">Contact Person:</label>
                                    <input type="text" name="contact_person" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="email">Website:</label>
                                    <input type="text" name="website" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">					
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-success" id="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
      
    <!--------end of add vendor modal---->
    <div id="contact"><button type="button" class="btn btn-info btn mx-1" data-toggle="modal" data-target="#import">Import</button></div>
    <div id="contact"><button type="button" class="btn btn-info btn mx-1" data-toggle="modal" data-target="#import">Export</button></div>
    <div id="contact"><button type="button" class="btn btn-info btn mx-1" data-toggle="modal" data-target="#import">Download file</button></div>
    </div>         
</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="width: 100%" id="dataTables" cellspacing="100">
                    <thead>
                        <tr>
                            <th>VendorID</th>
                            <th>Vendor Name</th>
                            <th>TIN No.</th>
                            <th>Address</th>
                            <th>Contact Person</th>
                            <th>Phone No.</th>
                        </tr>
                    </thead>
                   
                    <tbody>
                        <tr onclick="window.location='/individualVendor'">
                            <td>0001</td>
                            <td>PocketDevs</td>
                            <td>123523765</td>
                            <td>Cebu City, Philippines</td>
                            <td>Justin Manigo</td>
                            <td>09208765910</td>
                        </tr>
                        <tr onclick="window.location='/individualVendor'">
                            <td>0002</td>
                            <td>Pocketteams</td>
                            <td>053678123</td>
                            <td>Brgy. Langkiwa, Binan City, Laguna</td>
                            <td>Lester Fong</td>
                            <td>09124561120</td>
                        </tr>
                    </tbody>
                </table>
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