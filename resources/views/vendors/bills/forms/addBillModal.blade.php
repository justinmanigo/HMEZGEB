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
                <label for="b_mobile_number" class="col-4 col-form-label text-lg-right">Telephone # :</label>
                <input type="text" id="b_mobile_number" class="form-control-plaintext col-8 pl-3" placeholder="" name="mobile_number" disabled readonly>
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
                <label for="b_due_date" class="col-4 col-form-label text-lg-right">Due Date :</label>
                <div class="col-8">
                    <input type="date" class="form-control" id="b_due_date" name="due_date" placeholder="" value="{{date('Y-m-d', strtotime('+7 days'))}}" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="b_ordeb_number" class="col-4 col-form-label text-lg-right">Order #<span class="text-danger ml-1">*</span> :</label>
                <div class="col-8">
                    <input type="text" class="form-control" id="b_ordeb_number" name="ordeb_number" placeholder="" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="b_bill_number" class="col-4 col-form-label text-lg-right">Bill # :</label>
                <div class="col-8">
                    <input type="text" class="form-control" id="b_bill_number" name="bill_number" placeholder="">
                </div>
            </div>

        </div>
    </div> <div class="table-responsive">
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
                        <input type="text" class="form-control text-right" name="sub_total" id="b_sub_total" placeholder="0.00" value="0.00" readonly>
                    </td>
                    <td></td>
                </tr>
                {{-- <tr>
                    <td colspan="3" class="text-right"><span class="text-muted">Add toggle here</span></td>
                    <td class="text-right table-item-content"><strong>Discount: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="discount" placeholder="0.00">
                    </td>
                    <td></td>
                </tr> --}}
                {{-- <tr>
                    <td colspan="3" class="text-right"><span class="text-muted">Add toggle here</span></td>
                    <td class="text-right table-item-content"><strong>Withholding: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="withholding" placeholder="0.00">
                    </td>
                    <td></td>
                </tr> --}}
                {{-- <tr>
                    <td class="text-right table-item-content" colspan="4"><strong>Non-Taxable: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="tax" placeholder="0.00" disabled>
                    </td>
                    <td></td>
                </tr> --}}
                {{-- <tr>
                    <td class="text-right table-item-content" colspan="4"><strong>Tax: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="tax" placeholder="0.00" disabled>
                    </td>
                    <td></td>
                </tr> --}}
                <tr>
                    <td class="text-right table-item-content" colspan="4"><strong>Total: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="grand_total" id="b_grand_total" placeholder="0.00" value="0.00" readonly>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

<div class="row form-group">
    <label for="cars" class="col-form-label col-2">Cash from:</label>

    <select id="cars" class="form-control col-lg-4">
    <option value="#">Cash on hand</option>
    <option value="#">sample1</option>
    <option value="#">Sample2</option>
    </select>
    <label for="cars" class="col-form-label col-2">Bill type:</label>
</div>

<div class="form-group row">
    <label for="b_note" class="col-lg-2 col-form-label">Note:</label>
    <textarea class="form-control col-lg-4" id="b_note" name="note"></textarea>
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
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <input type="submit" class="btn btn-success" id="submit">
</div>