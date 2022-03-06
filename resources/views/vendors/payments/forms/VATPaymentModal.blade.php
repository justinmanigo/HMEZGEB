<div class="modal-body h6">				
    <div class="form-group row">
        <label for="name" class="col-md-4 col-lg-2 col-form-label">Vendor Name:<span class="text-danger ml-1">*</span></label>
        <input type="text" name="name" class="form-control col-lg-4">
        <label for="email" class="col-md-4 col-lg-2 col-form-label">Date:</label>
        <input type="date" name="address" class="form-control col-lg-4">
    </div>
    <div class="row form-group">
        <label for="email" class="col-md-4 col-lg-2 col-form-label">Address:</label>
        <input type="text" name="city" class="form-control col-lg-4">
        <label for="email" class="col-md-4 col-lg-2 col-form-label">Payment Ref:</label>
        <input type="text" name="country" class="form-control col-lg-4">
    </div>
    <div class="form-group row">
        <label for="email" class="col-md-4 col-lg-2 col-form-label">Contact Person:</label>
        <input type="text" name="tinNum" class="form-control col-lg-4">
        <label for="email" class="col-md-4 col-lg-2 col-form-label">Cheque Number:</label>
        <input type="number" name="email" class="form-control col-lg-4">
    </div>
    <div class="row form-group">
        <label for="email" class="col-md-4 col-lg-2 col-form-label">Telephone:</label>
        <input type="number" name="phone1" class="form-control col-lg-4">
        <label for="email" class="col-md-4 col-lg-2 col-form-label">Account:</label>
        <input type="text" name="phone1" class="form-control col-lg-4">
    </div>
    <hr>

    {{-- *TABLE* options - payment/receivable --}}
<div class="d-flex justify-content-between align-items-end">
    <ul class="nav nav-tabs d-flex" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="payment-tab" data-toggle="tab" href=".payment" role="tab" aria-controls="payment" aria-selected="true">Payment</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="receivable-tab" data-toggle="tab" href=".receivable" role="tab" aria-controls="receivable" aria-selected="false">Receivable</a>
        </li>
    </ul>
    <div class="row d-flex justify-content-end align-items-end w-50" style="margin-right:.05rem">
        <label class="col-sm-4 col-form-label">Accounting Period:</label>
        <input type="text" class="form-control col-lg-4">
    </div>
</div>
    {{-- nav/tabs contents --}}
    <div class="tab-content">
        <!--Payment content--->
        <div class="table-responsive tab-pane fade show active payment">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Previous Period VAT Receivable</th>
                        <th colspan="2">Current Period VAT Payable</th>
                        <th colspan="2">Current Period VAT Receivable</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1,000.00</td>
                        <td colspan="2">20,000.00</td>
                        <td colspan="2">10,000.00</td>
                    </tr>
                </tbody>
                <tfoot>
                    <td></td>
                    <th>Current Receivable</th>
                    <td>0.00</td>
                    <th>Total Paid</th>
                    <td>0.00</td>
                </tfoot>
            </table>
            <h5>Journal Entry Review</h5>
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead>
                        <th>Chart of Accounts # & Name</th>
                        <th>Debit</th>
                        <th>Credit</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="">VAT Payable (2104)</span></td>
                            <td class="text-right">20,000.00</td>
                            <td class="text-right"></td>
                        </tr>
                        <tr>
                            <td><span class="ml-3">VAT Receivable (1204)</span></td>
                            <td class="text-right"></td>
                            <td class="text-right">11,000.00</td>
                        </tr>
                        <tr>
                            <td><span class="ml-3">Cash at Bank (1030)</span></td>
                            <td class="text-right"></td>
                            <td class="text-right">9,000.00</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <th>Total</th>
                        <th class="text-right">20,000.00</th>
                        <th class="text-right">20,000.00</th>
                    </tfoot>
                </table>
            </div>
        </div>
        <!--receivable content--->
        <div class="table-responsive tab-pane fade receivable">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Previous Period VAT Receivable</th>
                            <th colspan="2">Current Period VAT Payable</th>
                            <th colspan="2">Current Period VAT Receivable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1,000.00</td>
                            <td colspan="2">20,000.00</td>
                            <td colspan="2">22,000.00</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <td></td>
                        <th>Current Receivable</th>
                        <td>3,000.00</td>
                        <th>Total Paid</th>
                        <td>0.00</td>
                    </tfoot>
                </table>
                <h5>Journal Entry Review</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <th>Chart of Accounts # & Name</th>
                            <th>Debit</th>
                            <th>Credit</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="">VAT Payable (2104)</span></td>
                                <td class="text-right">20,000.00</td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td><span class="ml-3">VAT Receivable (1204)</span></td>
                                <td class="text-right"></td>
                                <td class="text-right">20,000.00</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <th>Total</th>
                            <th class="text-right">20,000.00</th>
                            <th class="text-right">20,000.00</th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- end of table  --}}
    <div class="form-group row">
        <label for="name" class="col-md-4 col-lg-2 col-form-label">Remark:</label>
        <textarea name="remark" class="form-control col-lg-4"></textarea>
        <label for="email" class="col-form-label col-lg-2">Attachment:</label>
        <div class="input-group col-md-2 col-lg-4">
            <div class="custom-file">
            <input type="file" class="custom-file-input" id="inputGroupFile03">
            <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
            </div>
        </div>
    </div>

    
</div>