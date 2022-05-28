
{{-- <div class="form-group row">
        <label for="inputCustomerName" class="col-sm-3 col-form-label">Customer Name<span class="text-danger ml-1">*</span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="inputCustomerName" placeholder="" required>
        </div>
    </div> --}}

    {{-- Insert Customer, Date, Invoice Number, etc. --}}

    {{-- <div class="form-group row">
        <label for="ar_invoice_number" class="col-lg-2 col-form-label">Invoice Number</label>
        <div class="col-lg-4">
            <input type="text" class="form-control" id="ar_invoice_number" name="invoice_number" placeholder="1483681825" disabled>
        </div>
        <label for="ar_date" class="col-lg-2 col-form-label">Date<span class="text-danger ml-1">*</span></label>
        <div class="col-lg-4">
            <input type="date" class="form-control" id="ar_date" name="date" placeholder="" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="ar_customer" class="col-md-4 col-lg-2 col-form-label">Customer<span class="text-danger ml-1">*</span></label>
        <div class="input-group col-md-8 col-lg-10">
            <div class="input-group-prepend">
              <button class="btn btn-primary" type="button" id="ar_btn_customer_select" data-toggle="modal" data-target="#modal-select-customer">Select</button>
            </div>
            <input type="text" id="ar_customer" class="form-control" placeholder="Customer's Name" name="customer" disabled>
            <input type="hidden" name="customer_id" value="">
        </div>
    </div> --}}

    {{-- OLD VS NEW BOUNDARY --}}

    <div class="row">
    <div class="col-12 col-lg-6 mb-3 mb-lg-0">
            <h5>Customer Details:</h5>
            <div class="form-group row">
                <label for="ar_customer" class="col-4 col-form-label text-left">Customer<span class="text-danger ml-1">*</span> :</label>
                <input class="col-8 col-lg-7" id="ar_customer" name='customer' required>
                <input type="hidden" id="ar_customer_id" name="customer_id" value="">
                <p class="col-8 col-lg-5 text-danger error-message error-message-customer" style="display:none"></p>
            </div>
            {{-- Contact Details --}}
            <div class="form-group row mb-0">
                <label for="ar_tin_number" class="col-4 col-form-label text-lg-right">Tin # :</label>
                <input type="text" id="ar_tin_number" class="form-control-plaintext col-8 pl-3" placeholder="" name="tin_number" disabled readonly>
            </div>
            <div class="form-group row mb-0">
                <label for="ar_contact_person" class="col-4 col-form-label text-lg-right">Contact Person :</label>
                <input type="text" id="ar_contact_person" class="form-control-plaintext col-8 pl-3" placeholder="" name="contact_person" disabled readonly>
            </div>
            <div class="form-group row mb-0">
                <label for="ar_mobile_number" class="col-4 col-form-label text-lg-right">Contact # :</label>
                <input type="text" id="ar_mobile_number" class="form-control-plaintext col-8 pl-3" placeholder="" name="mobile_number" disabled readonly>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="form-group row">
                <label for="ar_date" class="col-4 col-form-label text-lg-right">Date<span class="text-danger ml-1">*</span> :</label>
                <div class="col-8">
                    <input type="date" class="form-control" id="ar_date" name="date" placeholder="" value="{{date('Y-m-d')}}" required>
                    <p class="text-danger error-message error-message-date" style="display:none"></p>
                </div>
            </div>

            <div class="form-group row">
                <label for="ar_account" class="col-4 col-form-label text-lg-right">Account :</label>
                <div class="col-8">
                    <input type="text" class="form-control" id="ar_account" name="account" placeholder="Change later to use either Tagify/Select2" required>
                    <p class="text-danger error-message error-message-account" style="display:none"></p>
                </div>
            </div>
        </div>
    </div>

    <hr>

    {{-- <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <th class="thead-actions">Actions</th>
                <th>Name<span class="text-danger ml-1">*</span></th>
                <th>Quantity<span class="text-danger ml-1">*</span></th>
                <th>Price</th>
                <th>Tax<span class="text-danger ml-1">*</span></th>
                <th>Total</th>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <button type="button" class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Edit">
                            <span class="icon text-white-50">
                                <i class="fas fa-trash"></i>
                            </span>
                        </button>
                    </td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-select-item">Select</button>
                            </div>
                            <input type="text" class="form-control" name="item_name[]" placeholder="Item Name" disabled>
                            <input type="hidden" name="item_id[]" value="">
                        </div>
                    </td>
                    <td>
                        <input type="number" class="form-control" name="quantity[]" placeholder="Enter Quantity" required>
                    </td>
                    <td>
                        <input type="text" class="form-control inputPrice text-right" name="price[]" placeholder="0.00" disabled>
                    </td>
                    <td>
                        <div class="form-group">
                            <select class="form-control" name="tax[]">
                              <option>Sales Tax (15%)</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control text-right" name="total[]" placeholder="0.00" disabled>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="tooltip" data-placement="bottom" title="Edit">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                        </button>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-right table-item-content" colspan="5">
                        <strong>Sub Total: </strong>
                    </td>
                    <td>
                        <input type="text" class="form-control text-right" name="subtotal" placeholder="0.00" disabled>
                    </td>
                </tr>
                <tr>
                    <td class="text-right table-item-content" colspan="5"><strong>Add Discount: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="discount" placeholder="0.00">
                    </td>
                </tr>
                <tr>
                    <td class="text-right table-item-content" colspan="5"><strong>Tax: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="tax" placeholder="0.00" disabled>
                    </td>
                </tr>
                <tr>
                    <td class="text-right table-item-content" colspan="5"><strong>Total: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="total" placeholder="0.00" disabled>
                    </td>
                </tr>
                <tr>
                    <td class="text-right table-item-content" colspan="5"><strong>Withholding: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="withholding" placeholder="0.00">
                    </td>
                </tr>
            </tfoot>
        </table>
    </div> --}}

    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label for="ar_remark" class="col-sm-3 col-form-label">Remark</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="ar_remark" name="remark"></textarea>
                    <p class="text-danger error-message error-message-remark" style="display:none"></p>
                </div>
            </div>
            <div class="form-group row">
                <label for="ar_attachment" class="col-sm-3 col-form-label">Attachment</label>
                <div class="col-sm-9">
                    <input type="file" id="ar_attachment" name="attachment">
                    <p class="text-danger error-message error-message-attachment" style="display:none"></p>
                </div>
            </div>
            {{-- <div class="form-group row">
                <label for="ar_commission" class="col-sm-3 col-form-label">Commission</label>
                <div class="input-group col-sm-9">
                    <div class="input-group-prepend">
                      <button class="btn btn-primary" type="button" id="ar_btn_commission_select">Select</button>
                    </div>
                    <input type="text" class="form-control" id="ar_commission" name="commission" placeholder="Select Commission" disabled>
                    <input type="hidden" id="ar_commission_employee_id" name="commission_employee_id" value="">
                </div>
            </div> --}}
        </div>
        <div class="col-md-6">
            {{-- <div class="form-group row">
                <label for="ar_revenue_type" class="col-sm-4 col-form-label">Revenue Type<span class="text-danger ml-1">*</span></label>
                <div class="col-sm-8">
                    <select class="form-control" id="ar_revenue_type" name="revenue_type">
                        <option>Sales</option>
                    </select>
                </div>
            </div> --}}
            {{-- <div class="form-group row">
                <label for="payment" class="col-sm-4 col-form-label">Payment Type<span class="text-danger ml-1">*</span></label>
                <div class="col-sm-8">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentType" id="ar_paymentType_credit" value="credit">
                        <label class="form-check-label" for="ar_paymentType_credit">
                        Credit
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentType" id="ar_paymentType_cash" value="cash">
                        <label class="form-check-label" for="ar_paymentType_cash">
                        Cash
                        </label>
                    </div>
                </div>
            </div> --}}
            <div class="form-group row">
                <label for="ar_amount_received" class="col-sm-4 col-form-label">Amount Received<span class="text-danger ml-1">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control text-right" id="ar_amount_received" name="amount_received" placeholder="0.00">
                    <p class="text-danger error-message error-message-amount_received" style="display:none"></p>
                </div>
            </div>
            <div class="form-group row">
                <label for="ar_reason" class="col-sm-4 col-form-label">Reason</label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="ar_reason" name="reason"></textarea>
                    <p class="text-danger error-message error-message-reason" style="display:none"></p>
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
                    <td><span class="ml-3">Other Current Liability (2600)</span></td>
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
