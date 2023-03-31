<form class="ajax-submit-updated" action="{{ url('/vendors/payments/bill') }}" id="form-bill-payment" method="post" enctype="multipart/form-data" data-message="Successfully saved bill payment." data-noreload="true" data-onsuccess="bill_payment_search" data-onsuccessparam="bill_payments_page_number_current" data-modal="modal-bill-payment">
    @csrf
    <div class="modal fade bill-payment-modal" id="modal-bill-payment" tabindex="-1" role="dialog"
        aria-labelledby="modal-bill-payment-label" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-bill-payment-label">New Bill Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row mb-0">
                                <h5 class="col-12">Select Vendor</h5>
                            </div>
                            <div class="form-group row">
                                <label for="b_vendor" class="col-4 col-form-label">Vendor<span class="text-danger ml-1">*</span> :</label>
                                <div class="col-8">
                                    <input class="form-control" id="b_vendor" name='vendor'>
                                    <p class="text-danger error-message error-message-vendor" style="display:none"></p>
                                    {{-- Contact Details --}}
                                    {{-- <div class="alert alert-info mt-3">
                                        <div class="form-group row m-0">
                                            <label for="b_tin_number" class="col-6 m-0 p-0 col-form-label text-lg-right">Tin # :</label>
                                            <p id="b_tin_number" class="m-0 p-0 col-6"></p>
                                        </div>
                                        <div class="form-group row m-0">
                                            <label for="b_contact_person" class="col-6 m-0 p-0 col-form-label text-lg-right">Contact Person :</label>
                                            <p id="b_contact_person" class="m-0 p-0 col-6"></p>
                                        </div>
                                        <div class="form-group row m-0">
                                            <label for="b_mobile_number" class="col-6 m-0 p-0 col-form-label text-lg-right">Contact # :</label>
                                            <p id="b_mobile_number" class="m-0 p-0 col-6"></p>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <input type="hidden" id="b_vendor_id" name="vendor_id" value="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row mb-0">
                                <h5 class="col-12">Payment Details</h5>
                            </div>
                            <div class="form-group row">
                                <label for="b_cash_account" class="col-4 col-form-label">Cash Account<span class="text-danger ml-1">*</span> :</label>
                                <div class="col-8">
                                    <input class="form-control" id="b_cash_account" name='cash_account'>
                                    <p class="text-danger error-message error-message-cash_account" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="b_date" class="col-4 col-form-label">Date<span class="text-danger ml-1">*</span> :</label>
                                <div class="col-8">
                                    <input type="date" class="form-control" id="b_date" name="date" placeholder="" value="{{date('Y-m-d')}}" required>
                                    <p class="text-danger error-message error-message-date" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="b_bill" class="col-4 col-form-label">Bill<span class="text-danger ml-1">*</span> :</label>
                                <div class="col-8">
                                    <input class="form-control" id="b_bill" name='bill'>
                                    <p class="text-danger error-message error-message-bill" style="display:none"></p>
                                    {{-- bill Details --}}
                                    <div class="alert alert-info mt-3">
                                        <div class="form-group row m-0">
                                            <label for="b_bill_due_date" class="col-6 m-0 p-0 col-form-label text-lg-right">Due Date :</label>
                                            <p id="b_bill_due_date" class="m-0 p-0 col-6"></p>
                                        </div>
                                        <div class="form-group row m-0">
                                            <label for="b_bill_to_pay" class="col-6 m-0 p-0 col-form-label text-lg-right">Amount To Pay :</label>
                                            <p id="b_bill_to_pay" class="m-0 p-0 col-6"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="b_date" class="col-4 col-form-label">Amount To Pay<span class="text-danger ml-1">*</span> :</label>
                                <div class="col-8">
                                    <input id="b_bill_amount_paid" type="number" step="0.01" min="0" class="form-control text-right inputPrice" name="amount_paid" placeholder="0.00">
                                    <p class="text-danger error-message error-message-amount_paid" style="display:none"></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="b_remark" class="col-4 col-form-label">Remark</label>
                                <div class="col-8">
                                    <textarea class="form-control" id="b_remark" name="remark"></textarea>
                                    <p class="text-danger error-message error-message-remark" style="display:none"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form-bill-payment">Save & Close</button>
                    <button type="submit" class="btn btn-primary" form="form-bill-payment" data-new="modal-bill-payment">Save & New</button>
                </div>
            </div>
        </div>
    </div>
</form>
