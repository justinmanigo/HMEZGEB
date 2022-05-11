<div class="modal-body h6">				
    <div class="row form-group">	
            <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                <h5>Vendor Details:</h5>
                <div class="form-group row">
                    <label for="w_vendor" class="col-4 col-form-label text-left">Vendor<span class="text-danger ml-1">*</span> :</label>
                    <input class="col-8 col-lg-7" id="w_vendor" name='vendor'>
                    <input type="hidden" id="w_vendor_id" name="vendor_id" value="">
                </div>
                {{-- Contact Details --}}
                <div class="form-group row mb-0">
                    <label for="w_address" class="col-4 col-form-label text-lg-right">Address</label>
                    <input type="text" id="w_address" class="form-control-plaintext col-8 pl-3" placeholder="" name="address" disabled readonly>
                </div>
                <div class="form-group row mb-0">
                    <label for="w_contact_person" class="col-4 col-form-label text-lg-right">Contact Person :</label>
                    <input type="text" id="w_contact_person" class="form-control-plaintext col-8 pl-3" placeholder="" name="contact_person" disabled readonly>
                </div>
                <div class="form-group row mb-0">
                    <label for="w_telephone_number" class="col-4 col-form-label text-lg-right">Telephone # :</label>
                    <input type="text" id="w_telephone_number" class="form-control-plaintext col-8 pl-3" placeholder="" name="telephone_number" disabled readonly>
                </div>
            </div>
            
            <div class="col-12 col-lg-6">
                <div class="form-group row">
                    <label for="w_date" class="col-4 col-form-label text-lg-right">Date<span class="text-danger ml-1">*</span> :</label>
                    <div class="col-8">
                        <input type="date" class="form-control" id="w_date" name="date" placeholder="" value="{{date('Y-m-d')}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="w_cheque_number" class="col-4 col-form-label text-lg-right">Cheque #:<span class="text-danger ml-1">*</span> :</label>
                    <div class="col-8">
                        <input type="text" class="form-control" id="w_cheque_number" name="cheque_number" placeholder="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="w_bill_number" class="col-4 col-form-label text-lg-right">Account:</label>
                    <div class="col-8">
                        <input type="text" class="form-control" id="w_bill_number" name="account_number" placeholder="">
                    </div>
                </div>
            </div>
    </div>
    {{-- start of the table  --}}
    <table class="table table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Bill#</th>
                <th>Date</th>
                <th>Withholding Amount</th>
                <th>Pay</th>
            </tr>
        </thead>
        <tbody id="w_withholdings_to_pay">

            {{--
            <tr>
                <td>Bi1032</td>
                <td>Dec 14, 2019</td>
                <td>12,500.00</td>
                <td colspan="2">217.39</td>
                <td>
                    <button type="button" class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Edit">
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
            </tr>
            <tr>
                <td>Bi1032</td>
                <td>Dec 14, 2019</td>
                <td>12,500.00</td>
                <td colspan="2">217.39</td>
                <td>
                    <button type="button" class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Edit">
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
            </tr>
            <tr>
                <td>Bi1130</td>
                <td>Dec 17, 2019</td>
                <td>11,500.00</td>
                <td colspan="2">200.00</td>
                <td>
                    <button type="button" class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Edit">
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
            </tr>
            <tr>
                <td>Bi1213</td>
                <td>Dec 25, 2019</td>
                <td>23,000.00</td>
                <td colspan="2">400.00</td>
                <td>
                    <button type="button" class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Edit">
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
            </tr>--}}
        </tbody>
        <tfoot>
            <td></td>
            <td></td>
            <th>Total Paid</th>
            <td>817.39</td>
        </tfoot>
    </table>
    {{-- end of the table  --}}

    <div class="form-group row">
        <label for="name" class="col-md-4 col-lg-2 col-form-label">Remark:</label>
        <textarea name="remark" class="form-control col-lg-4"></textarea>
        <label for="email" class="col-form-label col-lg-2">Attachment:</label>
        <div class="input-group col-md-2 col-lg-4">
            <div class="custom-file">
            <input type="file" class="custom-file-input" id="inputGroupFile03">
            <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
            </div>
        </div>
    </div>
    <hr>
    {{-- Chart of accounts  --}}
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
                    <td><span class="">Withholding Payable (2105)</span></td>
                    <td class="text-right">817.39</td>
                    <td class="text-right"></td>
                </tr>
                <tr>
                    <td><span class="ml-3">CAsh at Bank (1030)</span></td>
                    <td class="text-right"></td>
                    <td class="text-right">817.39</td>
                </tr>
            </tbody>
            <tfoot>
                <th>Total</th>
                <th class="text-right">817.39</th>
                <th class="text-right">817.39</th>
            </tfoot>
        </table>
    </div>
</div>