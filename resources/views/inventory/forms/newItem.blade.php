
<form action="/inventory"  method="POST" enctype="multipart/form-data">
    @csrf
<div class="modal-body">
    <div class="row">
        <div class="col-12 col-lg-8">

            <h5>Item Information</h5>
            <div class="form-group row">
                <label for="#" class="col-form-label col-4">Code</label>
                <div class="col-8">
                    <input type="text" class="form-control" name="item_code" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="#" class="col-form-label col-4">Name</label>
                <div class="col-8">
                    <input type="text" class="form-control" name="item_name" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="#" class="col-form-label col-4">Description</label>
                <div class="col-8">
                    <textarea  id="" class="form-control" rows="8"  name="description" required></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="#" class="col-form-label col-4">Inventory Type</label>
                <div class="col-8">
                    <div class="form-check row ml-1">
                        <input class="form-check-input" type="radio" name="inventory_type" id="ar_paymentType_credit" value="inventory_item" checked="checked">
                        <label class="form-check-label" for="ar_paymentType_credit">
                        Inventory item
                        </label>
                    </div>
                    <div class="form-check row ml-1">
                        <input class="form-check-input" type="radio" name="inventory_type" id="ar_paymentType_cash" value="non_inventory_item">
                        <label class="form-check-label" for="ar_paymentType_cash">
                        Non-inventory item
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-form-label col-4">Photo</label>
                <div class="input-group mb-3 col-8">
                    <div class="custom-file">
                        <input type="file" accept="image/*" class="custom-file-input" id="inputGroupFile03" name="picture">
                        <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-12 col-lg-4">

            <h5>Item Price</h5>

            <div class="form-group row">
                <label for="#" class="col-4 col-form-label">Quantity</label>
                <div class="col-8">
                    <input type="number" class="form-control inputPrice text-right"  name="quantity" placeholder="0" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="#" class="col-4 col-form-label">Purchase Price</label>
                <div class="col-8">
                    <input type="number" class="form-control inputPrice text-right"  name="purchase_price" step=".01" placeholder="0.00" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="#" class="col-4 col-form-label">Sale Price</label>
                <div class="col-8">
                    <input type="number" class="form-control inputPrice text-right"  name="sale_price" step=".01" placeholder="0.00" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="#" class="col-4 col-form-label">Tax</label>
                <div class="col-8">
                    <select class="form-control" id="" name="tax_id">
                        <option value="" selected disabled hidden>Choose</option>
                        <option value="">No Tax</option>
                        @foreach($taxes as $tax)
                            <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="#" class="col-4 col-form-label">Critical Quantity</label>
                <div class="col-8">
                    <input type="number" class="form-control inputPrice text-right"  name="critical_quantity" placeholder="0" required>
                    <div class="form-check mt-2">
                        <input class="form-check-input" id="c_notify_critical_quantity" type="checkbox" value="Yes" name="notify_critical_quantity">
                        <label class="form-check-label" for="c_notify_critical_quantity">Notify me when stocks reach critical level</label>
                    </div>
                </div>
            </div>

            <h5>Default Accounts</h5>
            <div class="form-group row">
                <label for="#" class="col-4 col-form-label">Expense Account</label>
                <div class="col-8">
                    <select name="default_income_account" class="form-control" id="" disabled>
                        <option>Choose</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="#" class="col-4 col-form-label">Income Account</label>
                <div class="col-8">
                    <select name="default_expense_account" class="form-control" id="" disabled>
                        <option>Choose</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    {{-- <div class="form-check mr-3">
        <input class="form-check-input" id="c_is_active" type="checkbox" value="Notify" name="is_active">
        <label class="form-check-label" for="c_is_active">Notify me when Quantity below</label>
    </div> --}}
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" >Add Item</button>
</div>
</form>
