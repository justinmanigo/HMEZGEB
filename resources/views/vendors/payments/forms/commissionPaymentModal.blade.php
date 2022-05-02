<div class="modal-body h6">				
    <div class="form-group row">
        <label for="name" class="col-md-4 col-lg-2 col-form-label">Commission Agent:<span class="text-danger ml-1">*</span></label>
        <input type="text" name="name" class="form-control col-lg-4">
        <label for="email" class="col-md-4 col-lg-2 col-form-label">Date:</label>
        <input type="date" name="address" class="form-control col-lg-4">
    </div>
    <div class="form-group row">
        <div class="col-lg-6"></div>
        <label for="email" class="col-md-4 col-lg-2 col-form-label">Cheque Number:</label>
        <input type="number" name="email" class="form-control col-lg-4">
    </div>
    <div class="row form-group">
        <div class="col-lg-6"></div>
        <label for="email" class="col-md-4 col-lg-2 col-form-label">Account:</label>
        <input type="text" name="phone1" class="form-control col-lg-4">
    </div>

    <input type="text" name="daterange" class="col-lg-4 form-control"/>
    <table class="table table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Bill#</th>
                <th>Date</th>
                <th>Bill Amount</th>
                <th colspan="2">Withholding Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
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
            </tr>
        </tbody>
        <tfoot>
            <td></td>
            <td></td>
            <td></td>
            <th>Total Paid</th>
            <td>817.39</td>
        </tfoot>
    </table>
    {{-- end of table  --}}

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





<script>
    $( document ).ready(function() {
       console.log( "ready!" );
       
    $('input[name="daterange"]').daterangepicker();
    });
     
</script>