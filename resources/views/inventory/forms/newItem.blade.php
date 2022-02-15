<form action="">

    <div class="row mb-3">
        <label for="#" class="col-lg-2 col-form-label">Item Code:</label>
        <div class="col-lg-4">
            <input type="number" class="form-control">
        </div>
        <label for="#" class="col-lg-2 col-form-label">Item Name:</label>
        <div class="col-lg-4">
            <input type="text" class="form-control">
        </div>
    </div>
    <div class="row mb-3">
        <label for="#" class="col-lg-2 col-form-label">Sale Price:</label>
        <div class="col-lg-4">
            <input type="number" class="form-control">
        </div>
        <label for="#" class="col-lg-2 col-form-label">Purchase Price:</label>
        <div class="col-lg-4">
            <input type="text" class="form-control">
        </div>
    </div>
    <div class="row mb-3">
        <label for=""class="col-lg-2 col-form-label">Quantity:</label>
        <div class="col-lg-4">
            <input type="number" class="form-control">
        </div>
        <label for="" class="col-sm-2">Tax:</label>
        <div class="col-lg-4">
            <select name="" class="form-control" id="">
                <option selected disabled hidden>Choose</option>
                <option>0%</option>
                <option>2%</option>
                <option>15%</option>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="" class="col-sm-3 mt-2">Default Expense Account:</label>
        <div class="col">
            <select name="" class="form-control" id="">
                <option>Choose</option>
            </select>
        </div>
        <label for="" class="col-sm-3 mt-2">Default Income Account:</label>
        <div class="col">
            <select name="" class="form-control" id="">
                <option>Choose</option>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="#" class="col-sm-2 col-form-label">Inventory Type:</label>
        <div class="form-check mx-2 mt-2">
            <input class="form-check-input" type="radio" name="paymentType" id="ar_paymentType_credit" value="inventory_item">
            <label class="form-check-label" for="ar_paymentType_credit">
            Inventory item
            </label>
        </div>
        <div class="form-check col-md-2 ml-3 mr-4 mt-2">
            <input class="form-check-input" type="radio" name="paymentType" id="ar_paymentType_cash" value="non_inventory_item">
            <label class="form-check-label" for="ar_paymentType_cash">
            Non-inventory item
            </label>
        </div>
        <label for="email" class="col ml-2 mt-2">Item Picture:</label>
        <div class="input-group mb-3 col-lg-4">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="inputGroupFile03">
                <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg">
            <label for="">Description:</label>
            <textarea name="" id="" class="form-control" style="min-height: 2.5rem"></textarea>
        </div>
    </div>

</form>