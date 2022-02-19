<div class="modal-body h6">	
    <div class="row form-group">	
        <div class="col-lg-6">
            <label for="cars">Bill Status:</label>

            <select id="cars" class="form-control">
            <option value="#" selected disabled hidden>Choose</option>
            <option value="#">Paid Bill</option>
            <option value="#">Partially Paid Bill</option>
            <option value="#">Unpaid Bill</option>
            </select>
        </div>	
        <div class="col-lg-6">
            <label for="name">Vendor name:</label>
            <input type="text" name="name" required class="form-control">
        </div>
    </div>	
    <div class="row form-group">
        <div class="col">
            <label for="email">Date:</label>
            <input type="date" name="address" class="form-control">
        </div>
        <div class="col">
            <label for="email">Due date:</label>
            <input type="date" name="city" class="form-control">
        </div>
    </div>
    <div class="row form-group">
        <div class="col">
            <label for="email">Bill number:</label>
            <input type="number" name="country" class="form-control">
        </div>
        <div class="col">
            <label for="email">Order number:</label>
            <input type="number" name="tinNum" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-6">
            <label for="email">Item table:</label>
            <input type="text" name="fax" class="form-control">
        </div>
        <div class="col-lg-6">
            <label for="cars">Cash from:</label>
    
            <select id="cars" class="form-control">
            <option value="#">Cash on hand</option>
            <option value="#">sample1</option>
            <option value="#">Sample2</option>
            </select>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-lg-6">
            <label for="#">Bill Type:</label>
            <select id="cars" class="form-control">
                <option value="#" selected disabled hidden>Choose...</option>
                <option value="#">Cash Bill</option>
                <option value="#">Credit Bill</option>
                </select>
        </div>
        <div class="col">
            <label for="email">Attachment:</label>
            <div class="input-group mb-3">
                <div class="custom-file">
                <input type="file" class="custom-file-input" id="inputGroupFile03">
                <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
                </div>
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