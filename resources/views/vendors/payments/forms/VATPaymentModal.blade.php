<div class="modal-body h6">				
    <div class="row form-group">	
            <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                <h5>Vendor Details:</h5>
                <div class="form-group row">
                    <label for="v_vendor" class="col-4 col-form-label text-left">Vendor<span class="text-danger ml-1">*</span> :</label>
                    <input class="col-8 col-lg-7" id="v_vendor" name='vendor'>
                    <input type="hidden" id="v_vendor_id" name="vendor_id" value="">
                </div>
                {{-- Contact Details --}}
                <div class="form-group row mb-0">
                    <label for="v_address" class="col-4 col-form-label text-lg-right">Address</label>
                    <input type="text" id="v_address" class="form-control-plaintext col-8 pl-3" placeholder="" name="address" disabled readonly>
                </div>
                <div class="form-group row mb-0">
                    <label for="v_contact_person" class="col-4 col-form-label text-lg-right">Contact Person :</label>
                    <input type="text" id="v_contact_person" class="form-control-plaintext col-8 pl-3" placeholder="" name="contact_person" disabled readonly>
                </div>
                <div class="form-group row mb-0">
                    <label for="v_telephone_number" class="col-4 col-form-label text-lg-right">Telephone # :</label>
                    <input type="text" id="v_telephone_number" class="form-control-plaintext col-8 pl-3" placeholder="" name="telephone_number" disabled readonly>
                </div>
            </div>
            
            <div class="col-12 col-lg-6">
                <div class="form-group row">
                    <label for="v_date" class="col-4 col-form-label text-lg-right">Date<span class="text-danger ml-1">*</span> :</label>
                    <div class="col-8">
                        <input type="date" class="form-control" id="v_date" name="date" placeholder="" value="{{date('Y-m-d')}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="v_payment_reference" class="col-4 col-form-label text-lg-right">Payment Reference:</label>
                    <div class="col-8">
                        <input type="date" class="form-control" id="v_payment_reference" name="payment_reference" placeholder="" value="" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="v_cheque_number" class="col-4 col-form-label text-lg-right">Cheque #:<span class="text-danger ml-1">*</span> :</label>
                    <div class="col-8">
                        <input type="text" class="form-control" id="v_cheque_number" name="cheque_number" placeholder="" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="v_account_number" class="col-4 col-form-label text-lg-right">Account #:</label>
                    <div class="col-8">
                        <input type="text" class="form-control" id="v_account_number" name="account_number" placeholder="">
                    </div>
                </div>
            </div>
    </div>


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