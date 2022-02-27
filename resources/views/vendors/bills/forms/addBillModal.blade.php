<div class="modal-body h6">	
    <div class="row form-group">	
            <label for="cars" class="col-form-label col-lg-2">Bill Status:</label>

            <select id="cars" class="form-control col-lg-4">
            <option value="#" selected disabled hidden>Choose</option>
            <option value="#">Paid Bill</option>
            <option value="#">Partially Paid Bill</option>
            <option value="#">Unpaid Bill</option>
            </select>
            <label for="name" class="col-form-label col-lg-2">Vendor name:</label>
            <input type="text" name="name" required class="form-control col-lg-4">
    </div>	
    <div class="row form-group">
            <label for="email" class="col-form-label col-lg-2">Date:</label>
            <input type="date" name="address" class="form-control col-lg-4">
            <label for="email" class="col-form-label col-lg-2">Due date:</label>
            <input type="date" name="city" class="form-control col-lg-4">
    </div>
    <div class="row form-group">
            <label for="email" class="col-form-label col-lg-2">Bill number:</label>
            <input type="number" name="country" class="form-control col-lg-4">
            <label for="email" class="col-form-label col-lg-2">Order number:</label>
            <input type="number" name="tinNum" class="form-control col-lg-4">
    </div>
    <div class="form-group row">
            <label for="email" class="col-form-label col-lg-2">Item table:</label>
            <input type="text" name="fax" class="form-control col-lg-4">
            <label for="cars" class="col-form-label col-2">Cash from:</label>
    
            <select id="cars" class="form-control col-lg-4">
            <option value="#">Cash on hand</option>
            <option value="#">sample1</option>
            <option value="#">Sample2</option>
            </select>
    </div>
    <div class="row form-group">
            <label for="#" class="col-form-label col-lg-2">Bill Type:</label>
            <select id="cars" class="form-control col-lg-4">
                <option value="#" selected disabled hidden>Choose...</option>
                <option value="#">Cash Bill</option>
                <option value="#">Credit Bill</option>
                <option value="#">Other</option>
                </select>
            <label for="email" class="col-form-label col-lg-2">Attachment:</label>
            <div class="input-group col-md-2 col-lg-4">
                <div class="custom-file">
                <input type="file" class="custom-file-input" id="inputGroupFile03">
                <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
                </div>
            </div>
    </div>
    <div class="form-group">
        <label for="email">Bill note:</label>
        <textarea type="text" name="phone2" style="min-height: 2.5rem" class="form-control"></textarea>
    </div>
</div>
<div class="modal-footer">					
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <input type="submit" class="btn btn-success" id="submit">
</div>