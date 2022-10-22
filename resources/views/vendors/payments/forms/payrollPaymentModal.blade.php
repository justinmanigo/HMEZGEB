<div class="modal-body h6">		
    <div class="row mb-3">
        <div class="col-12 col-lg-6 mb-3 mb-lg-0">
            <div class="form-group row">
                <label for="pp_cash_account" class="col-4 col-form-label text-left">Cash Account<span class="text-danger ml-1">*</span> :</label>
                <input class="col-8 col-lg-7 form-control" id="pp_cash_account" name='cash_account'>
                <p class="col-8 col-lg-5 text-danger error-message error-message-cash_account" style="display:none"></p>
            </div>
            <div class="form-group row">
                <label for="pp_payroll_period" class="col-4 col-form-label text-left">Payroll Period<span class="text-danger ml-1">*</span> :</label>
                <input class="col-8 col-lg-7 form-control" id="pp_payroll_period" name='payroll_period'>
                <p class="col-8 col-lg-5 text-danger error-message error-message-payroll_period" style="display:none"></p>
            </div>
            {{-- Contact Details --}}
            <div class="table-responsive">
                <table class="table-sm">
                    <tr>
                        <td width="200px">Current Balance:</td>
                        <td width="150px" class="text-right" id="pp_cash_account_current_balance">0.00</td>
                    </tr>
                    <tr>
                        <td>Payroll Amount:</td>
                        <td width="150px" class="text-right" id="pp_payroll_amount">0.00</td>
                    </tr>
                    <tr>
                        <td>Balance After:</td>
                        <td width="150px" class="text-right" id="pp_cash_account_balance_after_transaction">0.00</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="form-group row">
                <label for="pp_date" class="col-4 col-form-label text-lg-right">Date<span class="text-danger ml-1">*</span> :</label>
                <div class="col-8">
                    <input type="date" class="form-control" id="pp_date" name="date" placeholder="" value="{{date('Y-m-d')}}" required>
                    <p class="text-danger error-message error-message-date" style="display:none"></p>
                </div>
            </div>

            <div class="form-group row">
                <label for="pp_cheque_number" class="col-4 col-form-label text-lg-right">Cheque Number :</label>
                <div class="col-8">
                    <input class="form-control" type="text" id="pp_cheque_number" name="cheque_number">
                    <p class="text-danger error-message error-message-cheque_number" style="display:none"></p>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="table-responsive mb-3">
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
                    <td class="table-item-content">
                        <label for="cr_invoices_1023" class="col-form-label">Lester Fong</label>
                    </td>
                    <td>
                        <input type="month" class="form-control" name="date_due[]" value="">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="amount_due[]" value="">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="description[]" placeholder="">
                    </td>
                    <td class="table-item-content">
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
    </div> --}}
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

    {{-- <hr>
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
    </div> --}}
</div>