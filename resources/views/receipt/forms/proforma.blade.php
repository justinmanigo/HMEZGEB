<form id="form-proforma" method="post" enctype="multipart/form-data">
    {{-- <div class="form-group row">
        <label for="inputCustomerName" class="col-sm-3 col-form-label">Customer Name<span class="text-danger ml-1">*</span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="inputCustomerName" placeholder="" required>
        </div>
    </div> --}}

    {{-- Insert Customer, Date, Invoice Number, etc. --}}

    <div class="form-group row">
        <label for="invoice_number" class="col-lg-2 col-form-label">Invoice Number</label>
        <div class="col-lg-4">
            <input type="text" class="form-control" id="invoice_number" name="invoice_number" placeholder="1483681825" disabled>
        </div>
        <label for="date" class="col-lg-2 col-form-label">Date<span class="text-danger ml-1">*</span></label>
        <div class="col-lg-4">
            <input type="date" class="form-control" id="date" name="date" placeholder="" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="customer" class="col-md-4 col-lg-2 col-form-label">Customer<span class="text-danger ml-1">*</span></label>
        <div class="input-group col-md-8 col-lg-10">
            <div class="input-group-prepend">
              <button class="btn btn-primary" type="button" id="btn_customer_select">Select</button>
            </div>
            <input type="text" class="form-control" placeholder="Customer's Name" name="customer" disabled>
            <input type="hidden" name="customer_id" value="">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <th id="thead-actions">Actions</th>
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
                              <button class="btn btn-primary" type="button">Select</button>
                            </div>
                            <input type="text" class="form-control" name="name[]" placeholder="Item Name" disabled>
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
                    <td class="text-right table-item-content" colspan="5"><strong>Sub Total: </strong></td>
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
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label for="attachment" class="col-sm-3 col-form-label">Picture</label>
                <div class="col-sm-9">
                    <input type="file" id="attachment" name="attachment">
                </div>
            </div>
            <div class="form-group row">
                <label for="note" class="col-sm-3 col-form-label">Note</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="note" name="note"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="commission" class="col-sm-3 col-form-label">Commission</label>
                <div class="input-group col-sm-9">
                    <div class="input-group-prepend">
                      <button class="btn btn-primary" type="button" id="btn_commission_select">Select</button>
                    </div>
                    <input type="text" class="form-control" id="commission" name="commission" placeholder="Select Commission" disabled>
                    <input type="hidden" name="commission_employee_id" value="">
                </div>
            </div>
        </div>
    </div>
</form>