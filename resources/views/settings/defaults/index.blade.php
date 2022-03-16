@extends('template.index')

@section('content')

<div>
    
    <div class="d-flex justify-content-between align-items-end">
        {{-- Tab Navigation --}}
        <ul class="nav nav-tabs d-flex" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="receipt-tab" data-toggle="tab" href=".receipt" role="tab" aria-controls="receipt" aria-selected="true">Receipt</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="advance_receipt-tab" data-toggle="tab" href=".advance_receipt" role="tab" aria-controls="advance_receipt" aria-selected="false">Advance Receipt</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="credit_receipt-tab" data-toggle="tab" href=".credit_receipt" role="tab" aria-controls="credit_receipt" aria-selected="false">Credit Receipt</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="bill-tab" data-toggle="tab" href=".bill" role="tab" aria-controls="bill" aria-selected="false">Bill</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="payment-tab" data-toggle="tab" href=".payment" role="tab" aria-controls="payment" aria-selected="false">Payment</a>
            </li>
        </ul>
       
    </div>

    
        {{-- Tab Contents --}}
    <div class="card">
        <div class="card-body tab-content">
            <!--Receipt content--->
            <div class="tab-pane fade show active receipt">                
                <form>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Fs#-</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                </div>

                   <div class="form-group">
                        <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                    <div>
                </form>
                <form class="my-3">

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Cash on Hand:</label>
                            <div class="col-sm-10">
                                <select class="form-control" >
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                    </div>
                    <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">VAT Payable:</label>
                            <div class="col-sm-10">
                                <select class="form-control" >
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                    </div>
                    
                    <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Sales:</label>
                            <div class="col-sm-10">
                                <select class="form-control" >
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                    </div>
                    <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Account Receivable:</label>
                            <div class="col-sm-10">
                                <select class="form-control" >
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                    </div>
                    <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">Sales</label>
                            <div class="col-sm-10">
                                <select class="form-control" >
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                    </div>
                   

                   <div class="form-group">
                        <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                    <div>
                </form>
            </div>
            <!--Advance Receipt content--->
            <div class=" tab-pane fade advance_receipt">
                
            </div>
            <!--Credit Receipt content--->
            <div class=" tab-pane fade credit_Receipt">
                
            </div>
            <!--bill content--->
            <div class=" tab-pane fade bill">
                
            </div>
             <!--payment content--->
            <div class=" tab-pane fade payment">
                
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#dataTables').DataTable();
        $('#dataTables2').DataTable();
        $('.dataTables_filter').addClass('pull-right');
    });
</script>
@endsection
