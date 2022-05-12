<div class="modal-body h6">
    <h5>Vendor</h5>
    <div class="form-group row">
        <label for="name" class="col-md-4 col-lg-2 col-form-label">Vendor Name:<span
                class="text-danger ml-1">*</span></label>
        <input type="text" name="name" class="form-control col-lg-4" required>
        <label for="address" class="col-md-4 col-lg-2 col-form-label">Address:</label>
        <input type="text" name="address" class="form-control col-lg-4">
    </div>
    <div class="row form-group">
        <label for="city" class="col-md-4 col-lg-2 col-form-label">City:</label>
        <input type="text" name="city" class="form-control col-lg-4">
        <label for="country" class="col-md-4 col-lg-2 col-form-label">Country:</label>
        <input type="text" name="country" class="form-control col-lg-4">
    </div>
    <div class="row form-group">
        <label for="telephone_one" class="col-md-4 col-lg-2 col-form-label">Phone number 1:</label>
        <input type="text" name="telephone_one" class="form-control col-lg-4">
        <label for="telephone_two" class="col-md-4 col-lg-2 col-form-label">Phone number 2:</label>
        <input type="text" name="telephone_two" class="form-control col-lg-4">
    </div>
    <div class="row form-group">
        <label for="fax" class="col-md-4 col-lg-2 col-form-label">FAX:</label>
        <input type="text" name="fax" class="form-control col-lg-4">
        <label for="tin_number" class="col-md-4 col-lg-2 col-form-label">TIN number:<span
                class="text-danger ml-1">**</span></label>
        <input type="text" name="tin_number" class="form-control col-lg-4">
    </div>
    <h5>Contact Person</h5>
    <div class="row form-group">
        <label for="contact_person" class="col-md-4 col-lg-2 col-form-label">Name:</label>
        <input type="text" name="contact_person" class="form-control col-lg-4">
        <label for="mobile_number" class="col-md-4 col-lg-2 col-form-label">Mobile number:</label>
        <input type="text" name="mobile_number" class="form-control col-lg-4">
    </div>
    <div class="row form-group">
        <label for="website" class="col-md-4 col-lg-2 col-form-label">Website:</label>
        <input type="text" name="website" class="form-control col-md-4 col-lg-4">
        <label for="email" class="col-md-4 col-lg-2 col-form-label">Email:</label>
        <input type="email" name="email" class="form-control col-lg-4">
    </div>
    <div class="row form-group">
        <label for="label" class="col-md-4 col-lg-2 col-form-label">Label:</label>
        <select name="label" class="form-control col-md-2 col-lg-2">
            <option value="New" default>New</option>
            <option value="VIP">VIP</option>
            <option value="ISP">ISP</option>
        </select>
        <label for="image" class="mx-3 col-form-label">Image:</label>
        <div class="input-group col-md-4 col-lg-4">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="inputGroupFile03" name="image">
                <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
            </div>
        </div>
        <label for="is_active" class="col-form-label">Status:</label>
        <div class="form-check ml-5">
            <div class="row">
                <input class="form-check-input" type="radio" name="is_active" id="r_paymentType_credit" value="Yes">
                <label class="form-check-label" for="r_paymentType_credit">
                    Active
                </label>
            </div>
            <div class="row">
                <input class="form-check-input" type="radio" name="is_active" id="r_paymentType_cash" value="No">
                <label class="form-check-label" for="r_paymentType_cash">
                    Inactive
                </label>
            </div>
        </div>
    </div>
</div>