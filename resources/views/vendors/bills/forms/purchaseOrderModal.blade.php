<div class="modal-body h6">	
    <div class="row form-group">	
        {{-- <label for="cars" class="col-form-label col-lg-2">Bill Status:</label>

        <select id="cars" class="form-control col-lg-4">
        <option value="#" selected disabled hidden>Choose</option>
        <option value="#">Paid Bill</option>
        <option value="#">Partially Paid Bill</option>
        <option value="#">Unpaid Bill</option>
        </select> --}}
        <label for="name" class="col-form-label col-lg-2">Vendor name:</label>
        <input type="text" name="name" required class="form-control col-lg-4">
        <label for="email" class="col-form-label col-lg-2">Date:</label>
        <input type="date" name="address" class="form-control col-lg-4">
    </div>	
    <div class="row form-group">
        <label for="email" class="col-form-label col-lg-2">Address:</label>
        <input type="text" name="city" class="form-control col-lg-4">
        <label for="email" class="col-form-label col-lg-2">Due date:</label>
        <input type="date" name="city" class="form-control col-lg-4">
    </div>
    <div class="row form-group">
        <label for="email" class="col-form-label col-lg-2">Contact Person:</label>
        <input type="text" name="fax" class="form-control col-lg-4">
        <label for="email" class="col-form-label col-lg-2">Order number:</label>
        <input type="number" name="tinNum" class="form-control col-lg-4">
    </div>
    <div class="row form-group">
        <label for="email" class="col-form-label col-lg-2">Telephone:</label>
        <input type="number" name="fax" class="form-control col-lg-4">
        <label for="email" class="col-form-label col-lg-2">Attachment:</label>
        <div class="input-group col-md-2 col-lg-4">
            <div class="custom-file">
            <input type="file" class="custom-file-input" id="inputGroupFile03">
            <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
            </div>
        </div>
    </div>
{{-- Table --}}
<div class="table-responsive">
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
        </tfoot>
    </table>
</div>
<div class="form-group row">
    
</div>
</div>
<div class="modal-footer">					
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <input type="submit" class="btn btn-success" id="submit">
</div>