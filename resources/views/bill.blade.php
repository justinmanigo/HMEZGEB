@extends('template.index')

@push('styles')
 {{-- <link rel="stylesheet" href="{{asset('css/.css')}}" /> --}}
@endpush

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Bills</h1>

    <!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Bills</h6>
            <!----buttons----->
    <div class="d-flex justify-content-around">      
            <!--------add vendor modal---->
        <div id="contact"><button type="button" class="btn btn-info btn mx-1" data-toggle="modal" data-target="#contact-modal">Enter bill</button></div>
            <div id="contact-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
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
                                <div class="form-group">
                                    <label for="email">Date:</label>
                                    <input type="text" name="address" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="email">Due date:</label>
                                    <input type="text" name="city" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="email">Bill number:</label>
                                    <input type="text" name="country" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="email">Order number:</label>
                                    <input type="text" name="tinNum" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="email">Item table:</label>
                                    <input type="text" name="fax" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="email">Bill note:</label>
                                    <input type="text" name="phone2" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="email">Attachment:</label>
                                    <input type="text" name="mobile_num" class="form-control">
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
                    <tfoot>
                        <tr>
                            <th>Vendor Name</th>
                            <th>Date</th>
                            <th>Due Date</th>
                            <th>Bill No.</th>
                            <th>Bill Type</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td>A mr. Clean</td>
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
                        <tr>
                            <td>Jovi Lee</td>
                            <td>August 10, 2021</td>
                            <td>February 10, 2022</td>
                            <td>000631</td>
                            <td>Credit Invoice</td>
                            <td>Unpaid</td>
                        </tr>
                        <tr>
                            <td>Rookie Monster</td>
                            <td>October 10, 2021</td>
                            <td>April 19, 2022</td>
                            <td>000012</td>
                            <td>Credit Invoice</td>
                            <td>Partially Paid</td>
                        </tr>
                        <tr>
                            <td>Sovi Lee</td>
                            <td>August 10, 2021</td>
                            <td>February 10, 2022</td>
                            <td>000631</td>
                            <td>Credit Invoice</td>
                            <td>Paid</td>
                        </tr>
                        <tr>
                            <td>Xookie Monster</td>
                            <td>October 10, 2021</td>
                            <td>April 19, 2022</td>
                            <td>000012</td>
                            <td>Credit Invoice</td>
                            <td>Partially Paid</td>
                        </tr>
                        <tr>
                            <td>Povi Lee</td>
                            <td>August 10, 2021</td>
                            <td>February 10, 2022</td>
                            <td>000631</td>
                            <td>Credit Invoice</td>
                            <td>Unpaid</td>
                        </tr>
                        <tr>
                            <td>Kookie Monster</td>
                            <td>October 10, 2021</td>
                            <td>April 19, 2022</td>
                            <td>000012</td>
                            <td>Credit Invoice</td>
                            <td>Partially Paid</td>
                        </tr>
                        <tr>
                            <td>Covi Lee</td>
                            <td>August 10, 2021</td>
                            <td>February 10, 2022</td>
                            <td>000631</td>
                            <td>Credit Invoice</td>
                            <td>Paid</td>
                        </tr>
                        <tr>
                            <td>Tookie Monster</td>
                            <td>October 10, 2021</td>
                            <td>April 19, 2022</td>
                            <td>000012</td>
                            <td>Credit Invoice</td>
                            <td>Paid</td>
                        </tr>
                        <tr>
                            <td>Movi Lee</td>
                            <td>August 10, 2021</td>
                            <td>February 10, 2022</td>
                            <td>000631</td>
                            <td>Credit Invoice</td>
                            <td>Paid</td>
                        </tr>
                        <tr>
                            <td>Lookie Monster</td>
                            <td>October 10, 2021</td>
                            <td>April 19, 2022</td>
                            <td>000012</td>
                            <td>Credit Invoice</td>
                            <td>Partially Paid</td>
                        </tr>
                        <tr>
                            <td>Dookie Monster</td>
                            <td>October 10, 2021</td>
                            <td>April 19, 2022</td>
                            <td>000012</td>
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
@endsection