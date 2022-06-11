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
                <section>
                    {{-- <form>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Fs#-</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Receipt Reference Number" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="form-group">
                                <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button>
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                            <div>
                    </form>    --}}
                    <form class="my-3">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Cash on Hand:</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>1010-Cash on Hand</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">VAT Payable:</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>2100 - VAT Payable</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Sales:</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>4100 - Sales</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Account Receivable:</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>1110 - Account Receivable</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Sales Discount:</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>4102 - Sales Discount</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Withholding:</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>1400 - Prepaid Tax</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                    <div class="form-group">
                            <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button>
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                        <div>
                    </form>
                </section>
            </div>
            
            <!--Advance Receipt content--->
            <div class=" tab-pane fade advance_receipt">
                <section>
                    {{-- <form>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">AdvRec#-</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Advance Receipt Reference Number" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="form-group">
                                <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button>
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                            <div>
                    </form>    --}}
                    <form class="my-3">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Cash on Hand:</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>1010-Cash on Hand</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Advance Payment:</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>2109-Other Current Liability</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                    <div class="form-group">
                            <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button>
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                        <div>
                    </form>
                </section>
            </div>
            <!--Credit Receipt content--->
            <div class=" tab-pane fade credit_receipt">
                <section>
                    {{-- <form>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">CrR#-</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Credit Receipt Reference Number" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="form-group">
                                <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button>
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                            <div>
                    </form>    --}}
                    <form class="my-3">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Cash on Hand:</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>1010-Cash on Hand</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Account Receivable</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>1110 - Account Receivable</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                    <div class="form-group">
                            <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button>
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                        <div>
                    </form>
                </section>
            </div>
            <!--bill content--->
            <div class=" tab-pane fade bill">
            <section>
                    {{-- <form>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Bill#-</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Bill Reference Number" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="form-group">
                                <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button>
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                            <div>
                    </form>    --}}
                    <form class="my-3">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Cash on Hand:</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>1010-Cash on Hand</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Items for Sale</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>5100 - Cost of Goods Sold</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Freight Charge Expense:</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>5110 - Freight Charge</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">VAT Receivable:</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>1204 - VAT Receivable</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Account Payable:</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>2000 - Account Payable</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Withholding:</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>2105 - Withholding Tax Payable</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                    <div class="form-group">
                            <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button>
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                        <div>
                    </form>
                </section>
            </div>
             <!--payment content--->
            <div class=" tab-pane fade payment">
            <section>
                    {{-- <form>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">PV#-</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Receipt Reference Number" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="form-group">
                                <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button>
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                            <div>
                    </form>    --}}
                    <form class="my-3">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Cash on Hand:</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>1010-Cash on Hand</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">VAT Receivable:</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>2100 - VAT Receivable</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Account Payable</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>4100 - Account Payable</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Withholding</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>1110 - Withholding Tax Payable</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Salary Payable</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>4102 - Salary Payable</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Commission Payment</label>
                                <div class="col-md-10">
                                    <select class="form-control" >
                                        <option value="1" Selected>1400 - Commission Expense</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                        </div>
                    <div class="form-group">
                            <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button>
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                        <div>
                    </form>
                </section>
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
