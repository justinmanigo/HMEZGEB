<div class="modal-body h6">
    <div class="form-group row">
        <label for="name" class="col-md-4 col-lg-2 col-form-label">Commission Agent:<span
                class="text-danger ml-1">*</span></label>
        <input class="form-control col-lg-4" id="c_employee" name='employee'>
        <input type="hidden" id="c_employee_id" name="employee_id" value="">

        <label for="email" class="col-md-4 col-lg-2 col-form-label">Date:</label>
        <input type="date" name="date" class="form-control col-lg-4">
    </div>

    <div class="form-group row">
        <div class="col-lg-6 d-flex">
            <label for="c_tin_number" class="text-lg-right col-3 pt-3">Tin number:</label>
            <input type="text" id="c_tin_number" class="form-control-plaintext ml-5" placeholder=""
                name="tin_number" disabled readonly>
        </div>
        <label for="email" class="col-md-4 col-lg-2 col-form-label">Cheque Number:</label>
        <input type="number" name="email" class="form-control col-lg-4">
    </div>
    <div class="row form-group">
        <div class="col-lg-6"></div>
        <label for="email" class="col-md-4 col-lg-2 col-form-label">Account:</label>
        <input type="text" name="phone1" class="form-control col-lg-4">
    </div>

    <div class="col-12 d-lg-flex justify-content-between row">
        <div class="col-lg-10">
            <input type="text" name="daterange" class="col-lg-4 form-control" />
            <table class="table table-bordered" cellspacing="0">
                <thead>
                    <tr>
                        <th>Receipt#</th>
                        <th>Date</th>
                        <th>Amount before TAX</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Bi1032</td>
                        <td>Dec 14, 2019</td>
                        <td>12,500.00</td>
                    </tr>
                    <tr>
                        <td>Bi1032</td>
                        <td>Dec 14, 2019</td>
                        <td>12,500.00</td>
                    </tr>
                    <tr>
                        <td>Bi1032</td>
                        <td>Dec 14, 2019</td>
                        <td>12,500.00</td>
                    </tr>


                </tbody>
            </table>
            {{-- end of table  --}}
        </div>
        <div class="col-lg-2 col">

            <div class="card border-left-primary  shadow pt-2">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                        Number of Sales
                    </div>
                </div>
                <div class="card-body">
                    <div class="row no-gutters d-flex align-items-center justify-content-around">
                        <div class="h6 mb-0">
                            <span class="font-weight-bold text-gray-800">$40,000</span><br>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-left-primary shadow pt-2 my-4">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                        Total Sales
                    </div>
                </div>
                <div class="card-body">
                    <div class="row no-gutters d-flex align-items-center justify-content-around">
                        <div class="h6 mb-0">
                            <span class="font-weight-bold text-gray-800">$40,000</span><br>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-12 row mb-4">
        <div class="col-lg-9 d-flex">
            <div class="col-md-3 mx-4">
                <!-- radio button -->
                <div class="custom-control custom-radio row">
                    <input type="radio" id="customRadio1" name="type" class="custom-control-input">
                    <label class="custom-control-label" for="customRadio1">By # of Sales</label>
                </div>
                <!-- Card -->
                <div class="card border-left-primary shadow pt-2 my-4 row">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                            Rate
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row no-gutters d-flex align-items-center justify-content-around">
                            <div class="h6 mb-0">
                                <span class="font-weight-bold text-gray-800">40,000</span><br>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-3 mx-4">
                <!-- radio button -->
                <div class="custom-control custom-radio row">
                    <input type="radio" id="customRadio2" name="type" class="custom-control-input">
                    <label class="custom-control-label" for="customRadio2">By Sales %</label>
                </div>
                <!-- Card -->
                <div class="card border-left-primary shadow pt-2 my-4 row">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                            Rate
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row no-gutters d-flex align-items-center justify-content-around">
                            <div class="h6 mb-0">
                                <span class="font-weight-bold text-gray-800">%4</span><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mx-4">
                <!-- radio button -->
                <div class="custom-control custom-radio row">
                    <input type="radio" id="customRadio3" name="type" class="custom-control-input">
                    <label class="custom-control-label" for="customRadio3">By Flat Rate</label>
                </div>
                <!-- Card -->
                <div class="card border-left-primary shadow pt-2 my-4 row">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                            Rate
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row no-gutters d-flex align-items-center justify-content-around">
                            <div class="h6 mb-0">
                                <span class="font-weight-bold text-gray-800">4000</span><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">

            <div class="card border-left-primary shadow pt-2 ">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                        Commission Tax Rate
                    </div>
                </div>
                <div class="card-body">
                    <div class="row no-gutters d-flex align-items-center justify-content-around">
                        <div class="h6 mb-0">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio2" name="commission_tax_rate"
                                    class="custom-control-input">
                                <label class="custom-control-label" for="customRadio2">0%</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio3" name="commission_tax_rate"
                                    class="custom-control-input">
                                <label class="custom-control-label" for="customRadio3">2</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio4" name="commission_tax_rate"
                                    class="custom-control-input">
                                <label class="custom-control-label" for="customRadio4">35%</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="col-12 d-md-flex justify-content-around">
        <div class="col-md-6">
            <label for="name" class="col-form-label">Remark:</label>
            <textarea name="remark" rows="4" class="form-control"></textarea>
        </div>
        <div class="col-md-6">
            <div class="row">
                <!-- input field -->
                <div class="col-md-12">
                    <label for="name" class="col-form-label">Total Commission Payment:</label>
                    <input type="text" name="total_commission_payment" class="form-control" placeholder="0.00">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="email" class="col-form-label ">Attachment:</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="col-3 custom-file-input" id="inputGroupFile03">
                            <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
                        </div>
                    </div>
                </div>
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
$(document).ready(function() {
    console.log("ready!");

    $('input[name="daterange"]').daterangepicker();
});
</script>