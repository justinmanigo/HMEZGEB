
<form action="/inventory"  method="POST" enctype="multipart/form-data">
    @csrf
<div class="modal-body">
    <div class="row mb-3">
        <label for="#" class="col-lg-2 col-form-label">Item Code:</label>
        <div class="col-lg-4">
            <input type="number" class="form-control" name="item_code" required>
        </div>
        <label for="#" class="col-lg-2 col-form-label">Item Name:</label>
        <div class="col-lg-4">
            <input type="text" class="form-control" name="item_name" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for="#" class="col-lg-2 col-form-label">Sale Price:</label>
        <div class="col-lg-4">
            <input type="number" class="form-control"  name="sale_price" required >
        </div>
        <label for="#" class="col-lg-2 col-form-label">Purchase Price:</label>
        <div class="col-lg-4">
            <input type="text" class="form-control"  name="purchase_price" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for=""class="col-lg-2 col-form-label">Sold Quantity:</label>
        <div class="col-lg-4">
            <input type="number" class="form-control"  name="sold_quantity" required>
        </div>
         <label for="#" class="col-lg-2 col-form-label">Purchase Quantity:</label>
        <div class="col-lg-4">
            <input type="text" class="form-control"  name="purchase_quantity" required>
        </div>
        
    </div>
    <div class="row mb-3">
        
        <label for="" class="col-sm-2 mt-2">Default Expense Account:</label>
        <div class="col">
            <select name="default_income_account" class="form-control" id="" >
                <option>Choose</option>
            </select>
        </div>
        <label for="" class="col-sm-2 mt-2">Default Income Account:</label>
        <div class="col">
            <select name="default_expense_account" class="form-control" id="">
                <option>Choose</option>
            </select>
        </div>
        <label for="" class="col-sm-2">Tax:</label>
            <div class="col">
                <select  class="form-control" id="" name="tax">
                    <option selected disabled hidden>Choose</option>
                    <option name="tax" value="0%">0%</option>
                    <option name="tax" value="2%">2%</option>
                    <option name="tax" value="15%">15%</option>
                </select>
            </div>
    </div>
    <div class="row mb-3">
        <label for="#" class="col-sm-2 col-form-label">Inventory Type:</label>
        <div class="form-check mx-2 mt-2">
            <input class="form-check-input" type="radio" name="inventory_type" id="ar_paymentType_credit" value="inventory_item">
            <label class="form-check-label" for="ar_paymentType_credit">
            Inventory item
            </label>
        </div>
        <div class="form-check col-md-2 ml-3 mr-4 mt-2">
            <input class="form-check-input" type="radio" name="inventory_type" id="ar_paymentType_cash" value="non_inventory_item">
            <label class="form-check-label" for="ar_paymentType_cash">
            Non-inventory item
            </label>
        </div>
        <label for="email" class="col ml-2 mt-2">Item Picture:</label>
        <div class="input-group mb-3 col-lg-4">
            <div class="custom-file">
                <input type="file" accept="image/*" class="custom-file-input" id="inputGroupFile03" name="picture">
                <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg">
            <label for="">Description:</label>
            <textarea  id="" class="form-control" style="min-height: 2.5rem"  name="description" required></textarea>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="form-check mr-3">
        <input class="form-check-input" id="c_is_active" type="checkbox" value="Notify" name="is_active">
        <label class="form-check-label" for="c_is_active">Notify me when Quantity below</label>
    </div>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" >Add Item</button>
</div>
</form>
