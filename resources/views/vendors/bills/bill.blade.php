@extends('template.index')

@push('styles')
 <style>
     @media (max-width: 576px) {
        .responsive-btn {
            font-size:.5rem;
        }
    }
 </style>

@endpush

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-start justify-content-between">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Bills</h1>
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
    <!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary col-md-2 my-2">Bills</h6>
            <!----buttons----->
        <div class="d-flex">      
                <!--------add vendor modal---->
            <div class="row">
                <button type="button" class="btn btn-primary btn ml-2 mr-1 responsive-btn" data-toggle="modal" data-target=".bd-example-modal-xl">Enter bill</button>
                <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header d-flex">
                                    <h3>Add bill</h3>
                                    <a class="close" data-dismiss="modal">×</a>
                                </div>
                                <form id="contactForm" name="contact" role="form">
                                     @include('vendors.bills.forms.addBillModal')
                                </form>
                            </div>
                        </div>
                    </div>
                        <!--------end of add vendor modal---->
                    <div id="contact"><button type="button" class="btn btn-info btn mx-1 responsive-btn" data-toggle="modal" data-target="#import">Import</button></div>
                    <div id="contact"><button type="button" class="btn btn-info btn mx-1 responsive-btn" data-toggle="modal" data-target="#import">Export</button></div>
                    <div id="contact"><button type="button" class="btn btn-info btn mr-2 ml-1 responsive-btn" data-toggle="modal" data-target="#import">Download file</button></div>
                </div>  
                    <!---- end buttons----->
            </div>
        </div>
    </div>
                    <!---------Table--------->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Vendor Name</th>
                                <th>Date</th>
                                <th>Due Date</th>
                                <th>Bill No.</th>
                                <th>Bill Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <tr onclick="window.location='/individualBill'">
                                <td>Anna Clean</td>
                                <td>December 20, 2021</td>
                                <td>February 14, 2022</td>
                                <td>000293</td>
                                <td>Credit Invoice</td>
                                <td>Paid</td>
                            </tr>
                            <tr>
                                <td>Bonifacio Marciano</td>
                                <td>December 11, 2021</td>
                                <td>March 14, 2022</td>
                                <td>002593</td>
                                <td>Credit Invoice</td>
                                <td>Unpaid</td>
                            </tr>
                            <tr>
                                <td>Cookie Monster</td>
                                <td>October 10, 2021</td>
                                <td>April 19, 2022</td>
                                <td>000012</td>
                                <td>Credit Invoice</td>
                                <td>Partially Paid</td>
                            </tr>
                            <tr>
                                <td>Deborah Aira</td>
                                <td>December 22, 2021</td>
                                <td>February 10, 2022</td>
                                <td>000293</td>
                                <td>Credit Invoice</td>
                                <td>Partially Paid</td>
                            </tr>
                            <tr>
                                <td>Naelia Devorah</td>
                                <td>January 11, 2021</td>
                                <td>February 15, 2022</td>
                                <td>000255</td>
                                <td>Credit Invoice</td>
                                <td>Paid</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

</div>
<!-- /.container-fluid -->


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