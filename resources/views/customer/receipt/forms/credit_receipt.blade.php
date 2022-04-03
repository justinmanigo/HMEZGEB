<form id="form-credit-receipt" action="{{route('receipts.creditReceipt.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <div class="col-lg-6">
            {{-- Deposit Ticket ID --}}
            {{-- <div class="row mb-2">
                <label for="cr_deposit_ticket_id" class="col-md-4 col-form-label">Deposit Ticket ID</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" placeholder="" id="cr_deposit_ticket_id" name="deposit_ticket_id">
                </div>
            </div> --}}

            {{-- Customer --}}
            {{-- <div class="row mb-2">
                <label for="cr_customer" class="col-md-4 col-form-label">Customer<span class="text-danger ml-1">*</span></label>
                <div class="input-group col-md-8">
                    <div class="input-group-prepend">
                        <button class="btn btn-primary" type="button" id="btn_customer_select" data-toggle="modal" data-target="#modal-select-customer">Select</button>
                    </div>
                    <input type="text" class="form-control" placeholder="ARMSTRONG" id="cr_customer" name="customer" disabled>
                    <input type="hidden" name="customer_id" value="">
                </div>
            </div> --}}

            {{-- Customer Details --}}
            {{-- <div class="row mb-2">
                <div class="col-md-4">
                    
                </div>
                <div class="col-md-8">
                    <p>
                        Armstrong Landscaping<br>
                        2300 Club Drive<br>
                        Suite A<br>
                        Nocross, GA 30093
                    </p>
                </div>
            </div> --}}
        </div>
        <div class="col-lg-6">
            {{-- Reference --}}
            {{-- <div class="row mb-2">
                <label for="cr_reference" class="col-md-4 col-form-label">Reference</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="cr_reference" name="reference" placeholder="">
                </div>
            </div> --}}

            {{-- Receipt Number --}}
            {{-- <div class="row mb-2">
                <label for="cr_receipt_number" class="col-md-4 col-form-label">Receipt Number</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="cr_receipt_number" name="receipt_number" placeholder="">
                </div>
            </div> --}}

            {{-- Date --}}
            {{-- <div class="row mb-2">
                <label for="cr_date" class="col-md-4 col-form-label">Date<span class="text-danger ml-1">*</span></label>
                <div class="col-md-8">
                    <input type="date" class="form-control" id="cr_date" name="date" placeholder="" required>
                </div>
            </div> --}}

            {{-- Payment Method --}}
            {{-- <div class="row mb-2">
                <label for="cr_payment_method" class="col-md-4 col-form-label">Payment Method<span class="text-danger ml-1">*</span></label>
                <div class="col-md-8">
                    <select class="form-control" id="cr_payment_method" name="payment_method" required>
                        <option>Cash</option>
                        <option>Check</option>
                    </select>
                </div>
            </div> --}}
        </div>
    </div>

    {{-- <div class="form-group row">
        
    </div> --}}

    {{-- BOUNDARY --}}

    <div class="row">
        <div class="col-12 col-lg-6 mb-3 mb-lg-0">
            <h5>Customer Details:</h5>
            <div class="form-group row">
                <label for="cr_customer" class="col-4 col-form-label text-left">Customer<span class="text-danger ml-1">*</span> :</label>
                <input class="col-8 col-lg-7" id="cr_customer" name='customer'>
                <input type="hidden" id="cr_customer_id" name="customer_id" value="">

            </div>
            {{-- Contact Details --}}
            <div class="form-group row mb-0">
                <label for="cr_tin_number" class="col-4 col-form-label text-lg-right">Tin # :</label>
                <input type="text" id="cr_tin_number" class="form-control-plaintext col-8 pl-3" placeholder="" name="tin_number" disabled readonly>
            </div>
            <div class="form-group row mb-0">
                <label for="cr_contact_person" class="col-4 col-form-label text-lg-right">Contact Person :</label>
                <input type="text" id="cr_contact_person" class="form-control-plaintext col-8 pl-3" placeholder="" name="contact_person" disabled readonly>
            </div>
            <div class="form-group row mb-0">
                <label for="cr_mobile_number" class="col-4 col-form-label text-lg-right">Contact # :</label>
                <input type="text" id="cr_mobile_number" class="form-control-plaintext col-8 pl-3" placeholder="" name="mobile_number" disabled readonly>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="form-group row">
                <label for="cr_date" class="col-4 col-form-label text-lg-right">Date<span class="text-danger ml-1">*</span> :</label>
                <div class="col-8">
                    <input type="date" class="form-control" id="cr_date" name="date" placeholder="" value="{{date('Y-m-d')}}" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="cr_credit_receipt_number" class="col-4 col-form-label text-lg-right">Credit Receipt #<span class="text-danger ml-1">*</span> :</label>
                <div class="col-8">
                    <input type="text" class="form-control" id="cr_credit_receipt_number" name="credit_receipt_number" placeholder="" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="cr_account" class="col-4 col-form-label text-lg-right">Account :</label>
                <div class="col-8">
                    <input type="text" class="form-control" id="cr_account" name="account" placeholder="Change later to use either Tagify/Select2" required>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="table-responsive mb-3">
        <table class="table table-sm table-bordered">
            <thead>
                <th>Receipt #</th>
                <th>Date Due</th>
                <th>Amount Due</th>
                <th>Description</th>
                <th>Discount</th>
                <th>Amount Paid<span class="text-danger ml-1">*</span></th>
                <th class="thead-actions">Pay</th>
            </thead>
            <tbody id="cr_receipts_to_pay">
            
                <tr>
                    {{-- <td class="table-item-content">
                        <label for="cr_invoices_1023">Fs#1023</label>
                    </td>
                    <td>
                        <input type="number" class="form-control" name="date_due[]" value="04/02/2022" disabled>
                    </td>
                    <td>
                        <input type="text" class="form-control inputPrice text-right" name="amount_due[]" value="2,383.94" disabled>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="description[]" placeholder="">
                    </td>
                    <td>
                        <input type="text" class="form-control text-right" name="discount[]" placeholder="0.00">
                    </td>
                    <td>
                        <input type="text" class="form-control text-right" name="amount_paid[]" placeholder="0.00" required>
                    </td>
                    <td class="table-item-content">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="cr_invoices_1023" name="invoices[]">
                        </div>
                    </td> --}}
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

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group row">
                <label for="cr_remark" class="col-sm-3 col-form-label">Remark</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="cr_remark" name="remark"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="cr_attachment" class="col-sm-3 col-form-label">Attachment</label>
                <div class="col-sm-9">
                    <input type="file" id="cr_attachment" name="attachment">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            {{-- Discount Account --}}
            <div class="row">
                <label for="cr_discount_account" class="col-md-4 col-form-label">Discount Account</label>
                <div class="input-group col-md-8">
                    <div class="input-group-prepend">
                        <button class="btn btn-primary" type="button" id="btn_discount_account_select">Select</button>
                    </div>
                    <div class="input-group-append">
                        <input type="text" class="form-control" placeholder="Discount Account" id="cr_discount_account" name="discount_account" disabled>
                    </div>
                    <input type="hidden" id="cr_discount_account_id" name="discount_account_id" value="">
                </div>
            </div>
        </div>
    </div>

    <hr>

    <h5>Journal Entry Review</h5>
    {{-- Double Entry Review --}}
    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <th>Chart of Accounts # & Name</th>
                <th>Debit</th>
                <th>Credit</th>
            </thead>
            <tbody>
                <tr>
                    <td><span class="">Cash on Hand (1010)</span></td>
                    <td class="text-right">2,000.00</td>
                    <td class="text-right"></td>
                </tr>
                <tr>
                    <td><span class="ml-3">Account Receivable (1110)</span></td>
                    <td class="text-right"></td>
                    <td class="text-right">2,000.00</td>
                </tr>
            </tbody>
            <tfoot>
                <th>Total</th>
                <th class="text-right">2,000.00</th>
                <th class="text-right">2,000.00</th>
            </tfoot>
        </table>
    </div>
</form>