<div class="modal-body h6">				
    <div class="row form-group">	
            <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                <h5>Vendor Details:</h5>
                <div class="form-group row">
                    <label for="p_vendor" class="col-4 col-form-label text-left">Vendor<span class="text-danger ml-1">*</span> :</label>
                    <input class="col-8 col-lg-7" id="p_vendor" name='vendor'>
                    <input type="hidden" id="p_vendor_id" name="vendor_id" value="">
                </div>
                {{-- Contact Details --}}
                <div class="form-group row mb-0">
                    <label for="p_address" class="col-4 col-form-label text-lg-right">Address</label>
                    <input type="text" id="p_address" class="form-control-plaintext col-8 pl-3" placeholder="" name="address" disabled readonly>
                </div>
                <div class="form-group row mb-0">
                    <label for="p_contact_person" class="col-4 col-form-label text-lg-right">Contact Person :</label>
                    <input type="text" id="p_contact_person" class="form-control-plaintext col-8 pl-3" placeholder="" name="contact_person" disabled readonly>
                </div>
                <div class="form-group row mb-0">
                    <label for="p_telephone_number" class="col-4 col-form-label text-lg-right">Telephone # :</label>
                    <input type="text" id="p_telephone_number" class="form-control-plaintext col-8 pl-3" placeholder="" name="telephone_number" disabled readonly>
                </div>
            </div>
            
            <div class="col-12 col-lg-6">
                <div class="form-group row">
                    <label for="p_date" class="col-4 col-form-label text-lg-right">Date<span class="text-danger ml-1">*</span> :</label>
                    <div class="col-8">
                        <input type="date" class="form-control" id="p_date" name="date" placeholder="" value="{{date('Y-m-d')}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="p_cheque_number" class="col-4 col-form-label text-lg-right">Cheque #:<span class="text-danger ml-1">*</span> :</label>
                    <div class="col-8">
                        <input type="text" class="form-control" id="p_cheque_number" name="cheque_number" placeholder="" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="p_bill_number" class="col-4 col-form-label text-lg-right">Account:</label>
                    <div class="col-8">
                        <input type="text" class="form-control" id="p_bill_number" name="account" placeholder="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="p_bill_number" class="col-4 col-form-label text-lg-right">Accounting Period:</label>
                    <div class="col-8">
                        <input type="text" class="form-control" id="p_bill_number" name="period" placeholder="">
                    </div>
                </div>
            </div>
    </div>

    {{-- Body --}}
    <div class="form-group row">
        <label for="amount" class="col-lg-2 col-md-4 col-form-label ">Amount<span class="text-danger ml-1">*</span> :</label>
        <div class="col-lg-10 col-md-8 ">
            <input type="text" class="form-control" id="p_amount" name="amount" placeholder="">
        </div>
    </div>
    <div class="form-group row">
        <label for="amount_word" class="col-lg-2 col-md-4 col-form-label ">Amount in Word<span class="text-danger ml-1">*</span> :</label>
        <div class="col-lg-10 col-md-8 ">
            <input type="text" class="form-control" id="p_amount_word" name="amount_word" placeholder="">
        </div>
    </div>
 
    {{-- --end of table --}}

    <div class="form-group row">
        <label for="remark" class="col-md-4 col-lg-2 col-form-label">Remark:</label>
        <textarea name="remark" class="form-control col-lg-4"></textarea>
        <label for="attachment" class="col-form-label col-lg-2">Attachment:</label>
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