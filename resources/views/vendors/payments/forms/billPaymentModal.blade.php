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
    {{-- table  --}}
    <div class="table-responsive mb-3">
        <table class="table table-sm table-bordered">
            <thead>
                <th>Bill #</th>
                <th>Date Due</th>
                <th>Amount Due</th>
                <th class="w-25">Description</th>
                <th>Discount</th>
                <th>Amount Paid<span class="text-danger ml-1">*</span></th>
                <th class="thead-actions">Pay</th>
            </thead>
            <tbody>
                <tr>
                    <td class="table-item-content"> {{-- Invoice --}}
                        <label for="cr_invoices_1023">LL-15029684</label>
                    </td>
                    <td> {{-- Date Due --}}
                        <input type="number" class="form-control" name="date_due[]" value="04/02/2022" disabled>
                    </td>
                    <td> {{-- Amount Due --}}
                        <input type="text" class="form-control inputPrice text-right" name="amount_due[]" value="2,383.94" disabled>
                    </td>
                    <td> {{-- Description --}}
                        <input type="text" class="form-control" name="description[]" placeholder="">
                    </td>
                    <td> {{-- Discount --}}
                        <input type="text" class="form-control text-right" name="discount[]" placeholder="0.00">
                    </td>
                    <td> {{-- Amount Paid --}}
                        <input type="text" class="form-control text-right" name="amount_paid[]" placeholder="0.00" required>
                    </td>
                    <td class="table-item-content"> {{-- Actions --}}
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="cr_invoices_1023" name="invoices[]">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="table-item-content"> {{-- Invoice --}}
                        <label for="cr_invoices_1024">SG-01024</label>
                    </td>
                    <td> {{-- Date Due --}}
                        <input type="number" class="form-control" name="date_due[]" value="05/02/2022" disabled>
                    </td>
                    <td> {{-- Amount Due --}}
                        <input type="text" class="form-control inputPrice text-right" name="amount_due[]" value="9,645.26" disabled>
                    </td>
                    <td> {{-- Description --}}
                        <input type="text" class="form-control" name="description[]" placeholder="">
                    </td>
                    <td> {{-- Discount --}}
                        <input type="text" class="form-control text-right" name="discount[]" placeholder="0.00">
                    </td>
                    <td> {{-- Amount Paid --}}
                        <input type="text" class="form-control text-right" name="amount_paid[]" placeholder="0.00" required>
                    </td>
                    <td class="table-item-content"> {{-- Actions --}}
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="cr_invoices_1024" name="invoices[]">
                        </div>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-right table-item-content" colspan="5"><strong>Total Received: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="total_received" placeholder="0.00" disabled>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
    {{-- --end of table --}}

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
    <hr>
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
                    <td><span class="">Account Payable (2000)</span></td>
                    <td class="text-right">8,350.00</td>
                    <td class="text-right"></td>
                </tr>
                <tr>
                    <td><span class="ml-3">Cash at Bank (1030)</span></td>
                    <td class="text-right"></td>
                    <td class="text-right">8,350.00</td>
                </tr>
            </tbody>
            <tfoot>
                <th>Total</th>
                <th class="text-right">8,350.00</th>
                <th class="text-right">8,350.00</th>
            </tfoot>
        </table>
    </div>
</div>