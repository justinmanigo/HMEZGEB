<div class="modal-body h6">				
    <div class="form-group row">
        <div class="col-lg-6"></div>
        <label for="email" class="col-md-4 col-lg-2 col-form-label">Date:</label>
        <input type="date" name="address" class="form-control col-lg-4">
    </div>
    <div class="form-group row">
        <div class="col-lg-6"></div>
        <label for="email" class="col-md-4 col-lg-2 col-form-label">Cheque Number:</label>
        <input type="number" name="email" class="form-control col-lg-4">
    </div>
    <div class="row form-group">
        <div class="col-lg-6"></div>
        <label for="email" class="col-md-4 col-lg-2 col-form-label">Account:</label>
        <input type="text" name="phone1" class="form-control col-lg-4">
    </div>

    <div class="table-responsive mb-3">
        <table class="table table-sm table-bordered">
            <thead>
                <th>Employee</th>
                <th class="w-25">Month</th>
                <th>Note</th>
                <th>Amount</th>
                <th class="thead-actions">Pay</th>
            </thead>
            <tbody>
                <tr>
                    <td class="table-item-content"> {{-- Employee --}}
                        <label for="cr_invoices_1023" class="col-form-label">Lester Fong</label>
                    </td>
                    <td>  {{-- Month --}}
                        <input type="month" class="form-control" name="date_due[]" value="">
                    </td>
                    <td> {{-- Note --}}
                        <input type="text" class="form-control" name="amount_due[]" value="">
                    </td>
                    <td> {{-- Amount --}}
                        <input type="text" class="form-control" name="description[]" placeholder="">
                    </td>
                    <td class="table-item-content"> {{-- Pay--}}
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="cr_invoices_1024" name="invoices[]">
                        </div>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-right table-item-content" colspan="3"><strong>Total Paid: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="total_received" placeholder="0.00" disabled>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
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
                    <td><span class="">Salary Payable (2101)</span></td>
                    <td class="text-right">10,000.00</td>
                    <td class="text-right"></td>
                </tr>
                <tr>
                    <td><span class="ml-3">Cash at Bank (1030)</span></td>
                    <td class="text-right"></td>
                    <td class="text-right">10,000.00</td>
                </tr>
            </tbody>
            <tfoot>
                <th>Total</th>
                <th class="text-right">10,000.00</th>
                <th class="text-right">10,000.00</th>
            </tfoot>
        </table>
    </div>
</div>