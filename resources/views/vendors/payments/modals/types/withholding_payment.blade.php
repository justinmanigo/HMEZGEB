<form class="ajax-submit-updated" action="{{ url('/vendors/payments/withholding') }}" id="form-withholding-payment" method="post" enctype="multipart/form-data" data-message="Successfully saved Withholding payment.">
    @csrf
    <div class="modal fade withholding-payment-modal" id="modal-withholding-payment" tabindex="-1" role="dialog"
        aria-labelledby="modal-withholding-payment-label" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-withholding-payment-label">New Withholding Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="wp_body_main" class="modal-body d-none">
                    <div class="row mb-3">
                        <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                            <div class="form-group row">
                                <label for="wp_cash_account" class="col-4 col-form-label text-left">Cash Account<span class="text-danger ml-1">*</span> :</label>
                                <input class="col-8 col-lg-7 form-control" id="wp_cash_account" name='cash_account'>
                                <p class="col-8 col-lg-5 text-danger error-message error-message-cash_account" style="display:none"></p>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group row">
                                <label for="wp_date" class="col-4 col-form-label text-lg-right">Date<span class="text-danger ml-1">*</span> :</label>
                                <div class="col-8">
                                    <input type="date" class="form-control" id="wp_date" name="date" placeholder="" value="{{date('Y-m-d')}}" required>
                                    <p class="text-danger error-message error-message-date" style="display:none"></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="wp_cheque_number" class="col-4 col-form-label text-lg-right">Cheque Number :</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" id="wp_cheque_number" name="cheque_number">
                                    <p class="text-danger error-message error-message-cheque_number" style="display:none"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <th>Period Number</th>
                                    <th>Date Range</th>
                                    <th>Status</th>
                                    <th class="text-right">Total Withholding</th>
                                </thead>
                                <tbody id="wp_periods">
                                    {{-- <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="wp_period_1" value="1">
                                                <label class="custom-control-label" for="wp_period_1">Period # 1</label>
                                            </div>
                                        </td>
                                        <td>
                                            2022-01-01 to 2022-01-31
                                        </td>
                                        <td>
                                            <span class="badge badge-success">Paid</span>
                                        </td>
                                        <td class="text-right">
                                            1000.00
                                        </td>
                                    </tr> --}}
                                </tbody>
                                <tfoot>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="wp_select_all" value="1">
                                            <label class="custom-control-label" for="wp_select_all">Select All</label>
                                        </div>
                                    </th>
                                    <th colspan="2" class="text-right">Total Withholding to Pay</th>
                                    <th class="text-right"><strong id="wp_total_withholding_payable">0.00</strong></th>
                                </tfoot>
                            </table>
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
                <div id="wp_body_loading" class="modal-body">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <div id="wp_footer" class="modal-footer d-none">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form-withholding-payment">Save & Close</button>
                    <button type="submit" class="btn btn-primary" form="form-withholding-payment" data-new="modal-withholding-payment">Save & New</button>
                </div>
            </div>
        </div>
    </div>
</form>
