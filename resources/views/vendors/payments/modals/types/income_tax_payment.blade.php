<form class="ajax-submit-updated" action="{{ url('/vendors/payments/income-tax') }}" id="form-income-tax-payment" method="post" enctype="multipart/form-data" data-message="Successfully saved income-tax payment.">
    @csrf
    <div class="modal fade income-tax-payment-modal" id="modal-income-tax-payment" tabindex="-1" role="dialog"
        aria-labelledby="modal-income-tax-payment-label" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-income-tax-payment-label">New Income Tax Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                            <div class="form-group row">
                                <label for="itp_cash_account" class="col-4 col-form-label text-left">Cash Account<span class="text-danger ml-1">*</span> :</label>
                                <input class="col-8 col-lg-7 form-control" id="itp_cash_account" name='cash_account'>
                                <p class="col-8 col-lg-5 text-danger error-message error-message-cash_account" style="display:none"></p>
                            </div>
                            <div class="form-group row">
                                <label for="itp_payroll_period" class="col-4 col-form-label text-left">Payroll Period<span class="text-danger ml-1">*</span> :</label>
                                <input class="col-8 col-lg-7 form-control" id="itp_payroll_period" name='payroll_period'>
                                <p class="col-8 col-lg-5 text-danger error-message error-message-payroll_period" style="display:none"></p>
                            </div>
                            {{-- Contact Details --}}
                            <div class="table-responsive">
                                <table class="table-sm">
                                    <tr>
                                        <td width="200px">Current Balance:</td>
                                        <td width="150px" class="text-right" id="itp_cash_account_current_balance">0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Income Tax Amount:</td>
                                        <td width="150px" class="text-right" id="itp_income_tax_amount">0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Balance After:</td>
                                        <td width="150px" class="text-right" id="itp_cash_account_balance_after_transaction">0.00</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group row">
                                <label for="itp_date" class="col-4 col-form-label text-lg-right">Date<span class="text-danger ml-1">*</span> :</label>
                                <div class="col-8">
                                    <input type="date" class="form-control" id="itp_date" name="date" placeholder="" value="{{date('Y-m-d')}}" required>
                                    <p class="text-danger error-message error-message-date" style="display:none"></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="itp_cheque_number" class="col-4 col-form-label text-lg-right">Cheque Number :</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" id="itp_cheque_number" name="cheque_number">
                                    <p class="text-danger error-message error-message-cheque_number" style="display:none"></p>
                                </div>
                            </div>
                        </div>
                    </div>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form-income-tax-payment">Save & Close</button>
                    <button type="submit" class="btn btn-primary" form="form-income-tax-payment" data-new="modal-income-tax-payment">Save & New</button>
                </div>
            </div>
        </div>
    </div>
</form>
