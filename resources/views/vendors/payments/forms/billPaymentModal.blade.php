<div class="modal-body h6">				
    <div class="row form-group">	
            <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                <h5>Vendor Details:</h5>
                <div class="form-group row">
                    <label for="b_vendor" class="col-4 col-form-label text-left">Vendor<span class="text-danger ml-1">*</span> :</label>
                    <input class="col-8 col-lg-7" id="b_vendor" name='vendor'>
                    <input type="hidden" id="b_vendob_id" name="vendob_id" value="">
                </div>
                {{-- Contact Details --}}
                <div class="form-group row mb-0">
                    <label for="b_address" class="col-4 col-form-label text-lg-right">Address</label>
                    <input type="text" id="b_address" class="form-control-plaintext col-8 pl-3" placeholder="" name="address" disabled readonly>
                </div>
                <div class="form-group row mb-0">
                    <label for="b_contact_person" class="col-4 col-form-label text-lg-right">Contact Person :</label>
                    <input type="text" id="b_contact_person" class="form-control-plaintext col-8 pl-3" placeholder="" name="contact_person" disabled readonly>
                </div>
                <div class="form-group row mb-0">
                    <label for="b_telephone_number" class="col-4 col-form-label text-lg-right">Telephone # :</label>
                    <input type="text" id="b_telephone_number" class="form-control-plaintext col-8 pl-3" placeholder="" name="telephone_number" disabled readonly>
                </div>
            </div>
            
            <div class="col-12 col-lg-6">
                <div class="form-group row">
                    <label for="b_date" class="col-4 col-form-label text-lg-right">Date<span class="text-danger ml-1">*</span> :</label>
                    <div class="col-8">
                        <input type="date" class="form-control" id="b_date" name="date" placeholder="" value="{{date('Y-m-d')}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="b_payment_reference" class="col-4 col-form-label text-lg-right">Payment Reference:</label>
                    <div class="col-8">
                        <input type="date" class="form-control" id="b_payment_reference" name="payment_reference" placeholder="" value="" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="b_cheque_number" class="col-4 col-form-label text-lg-right">Cheque #:<span class="text-danger ml-1">*</span> :</label>
                    <div class="col-8">
                        <input type="text" class="form-control" id="b_cheque_number" name="cheque_number" placeholder="" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="b_bill_number" class="col-4 col-form-label text-lg-right">Account #:</label>
                    <div class="col-8">
                        <input type="text" class="form-control" id="b_bill_number" name="account_number" placeholder="">
                    </div>
                </div>
            </div>
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