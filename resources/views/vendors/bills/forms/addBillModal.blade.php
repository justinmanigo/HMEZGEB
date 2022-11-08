<div class="modal-body h6">
    <div class="row form-group">
        <div class="col-12 col-lg-6 mb-3 mb-lg-0">
            <h5>Vendor Details:</h5>
            <div class="form-group row">
                <label for="b_vendor" class="col-4 col-form-label text-left">Vendor<span
                        class="text-danger ml-1">*</span> :</label>
                <input class="col-8 col-lg-7" id="b_vendor" name='vendor'>
                <input type="hidden" id="b_vendor_id" name="vendor_id" value="">
                <p class="col-8 col-lg-5 text-danger error-message error-message-vendor" style="display:none"></p>
            </div>
            {{-- Contact Details --}}
            <div class="form-group row mb-0">
                <label for="b_address" class="col-4 col-form-label text-lg-right">Address</label>
                <input type="text" id="b_address" class="form-control-plaintext col-8 pl-3" placeholder=""
                    name="address" disabled readonly>
            </div>
            <div class="form-group row mb-0">
                <label for="b_contact_person" class="col-4 col-form-label text-lg-right">Contact Person :</label>
                <input type="text" id="b_contact_person" class="form-control-plaintext col-8 pl-3" placeholder=""
                    name="contact_person" disabled readonly>
            </div>
            <div class="form-group row mb-0">
                <label for="b_telephone_number" class="col-4 col-form-label text-lg-right">Telephone # :</label>
                <input type="text" id="b_telephone_number" class="form-control-plaintext col-8 pl-3" placeholder=""
                    name="telephone_number" disabled readonly>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="form-group row">
                <label for="b_date" class="col-4 col-form-label text-lg-right">Date<span
                        class="text-danger ml-1">*</span> :</label>
                <div class="col-8">
                    <input type="date" class="form-control" id="b_date" name="date" placeholder=""
                        value="{{date('Y-m-d')}}" required>
                    <p class="text-danger error-message error-message-date" style="display:none"></p>
                </div>
            </div>
            <div class="form-group row">
                <label for="b_due_date" class="col-4 col-form-label text-lg-right">Due Date :</label>
                <div class="col-8">
                    <input type="date" class="form-control" id="b_due_date" name="due_date" placeholder=""
                        value="{{date('Y-m-d', strtotime('+7 days'))}}" required>
                    <p class="text-danger error-message error-message-due_date" style="display:none"></p>
                </div>
            </div>
            <div class="form-group row">
                <label for="b_purchase_order" class="col-4 col-form-label text-lg-right">Purchase Order # :</label>
                <div class="col-8">
                    <input type="text" id="b_purchase_order" name="purchase_order">
                    <p class="text-danger error-message error-message-purchase_order" style="display:none"></p>
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
            <tbody id="b_items">
                {{-- <tr>
                    <td>
                        <div class="input-group">
                            <input id="b_item" class="b_item" name='item[]'>
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
                        <button type="button" class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete">
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
                </tr> --}}
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-right table-item-content" colspan="4">
                        <strong>Sub Total: </strong>
                    </td>
                    <td>
                        <input type="text" class="form-control text-right" name="sub_total" id="b_sub_total"
                            placeholder="0.00" value="0.00" readonly>
                        <p class="text-danger error-message error-message-sub_total" style="display:none"></p>
                    </td>
                    <td></td>
                </tr>
                {{-- <tr>
                    <td colspan="3" class="text-right"><span class="text-muted">Add toggle here</span></td>
                    <td class="text-right table-item-content"><strong>Discount: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="discount" placeholder="0.00">
                        <p class="text-danger error-message error-message-discount" style="display:none"></p>
                    </td>
                    <td></td>
                </tr> --}}
                <tr>
                    <td colspan="3" class="text-right">
                        <div class="form-check">
                            <label class="form-check-label mr-5" for="b_withholding_toggle">Withholding</label>
                            <input class="form-check-input" id="b_withholding_toggle" type="checkbox" value="on" name="withholding_check">
                        </div>
                    </td>
                    <td class="text-right table-item-content"><strong>Withholding: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="withholding" id="b_withholding" value="0.00" readonly>
                        <p class="text-danger error-message error-message-withholding" style="display:none"></p>
                    </td>
                    <td></td>
                </tr>
                {{-- <tr>
                    <td class="text-right table-item-content" colspan="4"><strong>Non-Taxable: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="tax" placeholder="0.00" disabled>
                        <p class="text-danger error-message error-message-tax" style="display:none"></p>
                    </td>
                    <td></td>
                </tr> --}}
                <tr>
                    <td class="text-right table-item-content" colspan="4"><strong>Tax: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right b_tax_total" name="tax_total" value="0.00" readonly>
                        <p class="text-danger error-message error-message-tax" style="display:none"></p>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-right table-item-content" colspan="4"><strong>Total: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="grand_total" id="b_grand_total"
                            placeholder="0.00" value="0.00" readonly>
                        <p class="text-danger error-message error-message-grand_total" style="display:none"></p>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row">
        <div class="form-group col-lg-7 row">
            <label for="b_remark" class="col-form-label col-lg-2">Remark:</label>
            <textarea class="form-control col-lg-10" id="b_remark" name="remark"></textarea>
            <p class="text-danger error-message error-message-remark" style="display:none"></p>
        </div>
        <div class="form-group col-lg-5 row">
            <label for="payment" class="col-form-label col-lg-3">Payment<span class="text-danger ml-1">*</span></label>
            <input type="text" class="form-control text-right  col-lg-9" id="total_amount_received"
            name="total_amount_received" placeholder="0.00" required>
            <p class="text-danger error-message error-message-total_amount_received" style="display:none"></p>
        </div>
    </div>

    <div class="form-group row">
        <label for="attachment" class="col-form-label col-lg-2">Attachment:</label>
        <div class="input-group col-md-2 col-lg-5">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="inputGroupFile03">
                <label class="custom-file-label" for="inputGroupFile03" name="attachment">Choose file</label>
            </div>
            <p class="text-danger error-message error-message-attachment" style="display:none"></p>
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
                    <td><span class="">Telephone Expense (6117)</span></td>
                    <td class="text-right">1,000.00</td>
                    <td class="text-right"></td>
                </tr>
                <tr>
                    <td><span class="ml-3">VAT receivable (1204)</span></td>
                    <td class="text-right">150.00</td>
                    <td class="text-right"></td>
                </tr>
                <tr>
                    <td><span class="ml-3">Cash on Hand (1010)</span></td>
                    <td class="text-right"></td>
                    <td class="text-right">1,150.00</td>
                </tr>
            </tbody>
            <tfoot>
                <th>Total</th>
                <th class="text-right">1,150.00</th>
                <th class="text-right">1,150.00</th>
            </tfoot>
        </table>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" form="form-new-bill">Save & Close</button>
    <button type="submit" class="btn btn-primary" form="form-new-bill" data-new="modal-bill">Save & New</button>
</div>
