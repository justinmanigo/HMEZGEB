@extends('template.index')

@push('styles')
 {{-- <link rel="stylesheet" href="{{asset('css/.css')}}" /> --}}
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
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Bills</h6>
            <!----buttons----->
    <div class="d-flex justify-content-around">      
            <!--------add vendor modal---->
        <button type="button" class="btn btn-info btn mx-1" data-toggle="modal" data-target=".bd-example-modal-lg">Enter bill</button>
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header d-flex">
                            <h3>Add bill</h3>
                            <a class="close" data-dismiss="modal">×</a>
                        </div>
                        <form id="contactForm" name="contact" role="form">
                            <div class="modal-body h6">			
                                <div class="form-group">
                                    <label for="cars">Bill Status:</label>

                                    <select id="cars" class="form-control">
                                    <option value="#" selected disabled hidden>Choose</option>
                                    <option value="#">Paid Bill</option>
                                    <option value="#">Partially Paid Bill</option>
                                    <option value="#">Unpaid Bill</option>
                                    </select>
                                </div>	
                                <div class="form-group">
                                    <label for="name">Vendor name:</label>
                                    <input type="text" name="name" required class="form-control">
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label for="email">Date:</label>
                                        <input type="date" name="address" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="email">Due date:</label>
                                        <input type="date" name="city" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label for="email">Bill number:</label>
                                        <input type="text" name="country" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="email">Order number:</label>
                                        <input type="text" name="tinNum" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Item table:</label>
                                    <input type="text" name="fax" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="email">Bill note:</label>
                                    <textarea type="text" name="phone2" style="min-height: 2.5rem" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="cars">Bill type:</label>

                                    <select id="cars" class="form-control">
                                    <option value="#" selected disabled hidden>Choose here</option>
                                    <option value="#">Cash Bill</option>
                                    <option value="#">Credit Bill</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cars">Cash from:</label>

                                    <select id="cars" class="form-control">
                                    <option value="#">Cash on hand</option>
                                    <option value="#">sample1</option>
                                    <option value="#">Sample2</option>
                                    </select>
                                </div>
                                <label for="email">Attachment:</label>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input" id="inputGroupFile03">
                                      <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
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
                <!--------end of add vendor modal---->
            <div id="contact"><button type="button" class="btn btn-info btn mx-1" data-toggle="modal" data-target="#import">Import</button></div>
            <div id="contact"><button type="button" class="btn btn-info btn mx-1" data-toggle="modal" data-target="#import">Export</button></div>
            <div id="contact"><button type="button" class="btn btn-info btn mx-1" data-toggle="modal" data-target="#import">Download file</button></div>
        </div>  
                <!---- end buttons----->
    </div>

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