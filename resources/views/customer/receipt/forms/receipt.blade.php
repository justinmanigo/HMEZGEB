<form id="form-receipt" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-12 col-lg-6 mb-3 mb-lg-0">
            <h5>Customer Details:</h5>
            <div class="form-group row">
                <label for="r_customer" class="col-4 col-form-label text-left">Customer<span class="text-danger ml-1">*</span> :</label>
                <div class="input-group col-8">
                    <div class="input-group-prepend">
                        <button class="btn btn-primary" type="button" id="r_btn_customer_select" data-toggle="modal" data-target="#modal-select-customer">Select</button>
                    </div>
                    <div class="input-group-append">
                        <input type="text" id="r_customer" class="form-control" placeholder="Customer's Name" name="customer" disabled>
                    </div>
                    
                    <input type="hidden" name="customer_id" value="">
                </div>

            </div>
            {{-- Contact Details --}}
            <div class="form-group row mb-0">
                <label for="r_tin_number" class="col-4 col-form-label text-lg-right">Tin # :</label>
                <input type="text" id="r_tin_number" class="form-control-plaintext col-8 pl-3" placeholder="0042101026" name="tin_number" disabled readonly>
            </div>
            <div class="form-group row mb-0">
                <label for="r_contact_person" class="col-4 col-form-label text-lg-right">Contact Person :</label>
                <input type="text" id="r_contact_person" class="form-control-plaintext col-8 pl-3" placeholder="Example Key Person" name="contact_person" disabled readonly>
            </div>
            <div class="form-group row mb-0">
                <label for="r_contact_number" class="col-4 col-form-label text-lg-right">Contact # :</label>
                <input type="text" id="r_contact_number" class="form-control-plaintext col-8 pl-3" placeholder="0911223344" name="contact_number" disabled readonly>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="form-group row">
                <label for="r_date" class="col-4 col-form-label text-lg-right">Date<span class="text-danger ml-1">*</span> :</label>
                <div class="col-8">
                    <input type="date" class="form-control" id="r_date" name="date" placeholder="" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="r_reference_number" class="col-4 col-form-label text-lg-right">Reference #<span class="text-danger ml-1">*</span> :</label>
                <div class="col-8">
                    <input type="text" class="form-control" id="r_reference_number" name="reference_number" placeholder="" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="r_proforma_number" class="col-4 col-form-label text-lg-right">Proforma # :</label>
                <div class="col-8">
                    <input type="text" class="form-control" id="r_proforma_number" name="proforma_number" placeholder="" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="r_due_date" class="col-4 col-form-label text-lg-right">Due Date :</label>
                <div class="col-8">
                    <input type="date" class="form-control" id="r_due_date" name="due_date" placeholder="" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="r_account" class="col-4 col-form-label text-lg-right">Account :</label>
                <div class="col-8">
                    <input type="text" class="form-control" id="r_account" name="account" placeholder="Change later to use either Tagify/Select2" required>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <th>Name<span class="text-danger ml-1">*</span></th>
                <th>Quantity<span class="text-danger ml-1">*</span></th>
                <th>Price</th>
                <th>Tax<span class="text-danger ml-1">*</span></th>
                <th>Total</th>
                <th class="thead-actions">Actions</th>
            </thead>
            <tbody>
                <tr>
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
                        <select class="form-control" name="tax[]">
                            <option>Sales Tax (15%)</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control text-right" name="total[]" placeholder="0.00" disabled>
                    </td>
                    <td>
                        <button type="button" class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Edit">
                            <span class="icon text-white-50">
                                <i class="fas fa-trash"></i>
                            </span>
                        </button>
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
                    <td class="text-right table-item-content" colspan="4">
                        <strong>Sub Total: </strong>
                    </td>
                    <td>
                        <input type="text" class="form-control text-right" name="subtotal" placeholder="0.00" disabled>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right"><span class="text-muted">Add toggle here</span></td>
                    <td class="text-right table-item-content"><strong>Discount: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="discount" placeholder="0.00">
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right"><span class="text-muted">Add toggle here</span></td>
                    <td class="text-right table-item-content"><strong>Withholding: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="withholding" placeholder="0.00">
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-right table-item-content" colspan="4"><strong>Non-Taxable: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="tax" placeholder="0.00" disabled>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-right table-item-content" colspan="4"><strong>Tax: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="tax" placeholder="0.00" disabled>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-right table-item-content" colspan="4"><strong>Total: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="total" placeholder="0.00" disabled>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label for="r_remark" class="col-sm-3 col-form-label">Remark</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="r_remark" name="remark"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="r_attachment" class="col-sm-3 col-form-label">Attachment</label>
                <div class="col-sm-9">
                    <input type="file" id="r_attachment" name="attachment">
                </div>
            </div>
            {{-- <div class="form-group row">
                <label for="r_commission" class="col-sm-3 col-form-label">Commission</label>
                <div class="input-group col-sm-9">
                    <div class="input-group-prepend">
                      <button class="btn btn-primary" type="button" id="r_btn_commission_select">Select</button>
                    </div>
                    <input type="text" class="form-control" id="r_commission" name="commission" placeholder="Select Commission" disabled>
                    <input type="hidden" id="r_commission_employee_id" name="commission_employee_id" value="">
                </div>
            </div> --}}
        </div>
        <div class="col-md-6">
            {{-- <div class="form-group row">
                <label for="r_revenue_type" class="col-sm-4 col-form-label">Revenue Type<span class="text-danger ml-1">*</span></label>
                <div class="col-sm-8">
                    <select class="form-control" id="r_revenue_type" name="revenue_type">
                        <option>Sales</option>
                    </select>
                </div>
            </div> --}}
            <div class="form-group row">
                <label for="payment" class="col-sm-4 col-form-label">Payment Type<span class="text-danger ml-1">*</span></label>
                <div class="col-sm-8">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentType" id="r_paymentType_credit" value="credit">
                        <label class="form-check-label" for="r_paymentType_credit">
                        Credit
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentType" id="r_paymentType_cash" value="cash">
                        <label class="form-check-label" for="r_paymentType_cash">
                        Cash
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="r_payment" class="col-sm-4 col-form-label">Payment<span class="text-danger ml-1">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control text-right" id="r_payment" name="payment" placeholder="0.00">
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
                    <td><span class="">1010 - Cash on Hand</span></td>
                    <td class="text-right">1,150.00</td>
                    <td class="text-right"></td>
                </tr>
                <tr>
                    <td><span class="ml-3">2104 - VAT Payable</span></td>
                    <td class="text-right"></td>
                    <td class="text-right">150.00</td>
                </tr>
                <tr>
                    <td><span class="ml-3">4100 - Sales</span></td>
                    <td class="text-right"></td>
                    <td class="text-right">1,000.00</td>
                </tr>
            </tbody>
            <tfoot>
                <th>Total</th>
                <th class="text-right">1,150.00</th>
                <th class="text-right">1,150.00</th>
            </tfoot>
        </table>
    </div>
</form>