<form class="ajax-submit-updated" action="{{route('receipts.advance_revenues.store')}}" id="form-advance-revenue" method="post" enctype="multipart/form-data" data-message="Successfully created advance revenue.">
    @csrf
    <div class="modal fade" id="modal-advance-revenue" tabindex="-1" role="dialog"
        aria-labelledby="modal-advance-revenue-label" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-advance-revenue-label">New Advance Revenue</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                            <h5>Customer Details:</h5>
                            <div class="form-group row">
                                <label for="ar_customer" class="col-4 col-form-label text-left">Customer<span class="text-danger ml-1">*</span> :</label>
                                <input class="col-8 col-lg-7" id="ar_customer" name='customer' required>
                                <input type="hidden" id="ar_customer_id" name="customer_id" value="">
                                <p class="col-8 col-lg-5 text-danger error-message error-message-customer" style="display:none"></p>
                            </div>
                            {{-- Contact Details --}}
                            <div class="form-group row mb-0">
                                <label for="ar_tin_number" class="col-4 col-form-label text-lg-right">Tin # :</label>
                                <input type="text" id="ar_tin_number" class="form-control-plaintext col-8 pl-3" placeholder="" name="tin_number" disabled readonly>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="ar_contact_person" class="col-4 col-form-label text-lg-right">Contact Person :</label>
                                <input type="text" id="ar_contact_person" class="form-control-plaintext col-8 pl-3" placeholder="" name="contact_person" disabled readonly>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="ar_mobile_number" class="col-4 col-form-label text-lg-right">Contact # :</label>
                                <input type="text" id="ar_mobile_number" class="form-control-plaintext col-8 pl-3" placeholder="" name="mobile_number" disabled readonly>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group row">
                                <label for="ar_date" class="col-4 col-form-label text-lg-right">Date<span class="text-danger ml-1">*</span> :</label>
                                <div class="col-8">
                                    <input type="date" class="form-control" id="ar_date" name="date" placeholder="" value="{{date('Y-m-d')}}" required>
                                    <p class="text-danger error-message error-message-date" style="display:none"></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="ar_account" class="col-4 col-form-label text-lg-right">Account :</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="ar_account" name="account" placeholder="Change later to use either Tagify/Select2" required>
                                    <p class="text-danger error-message error-message-account" style="display:none"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="ar_remark" class="col-sm-3 col-form-label">Remark</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="ar_remark" name="remark"></textarea>
                                    <p class="text-danger error-message error-message-remark" style="display:none"></p>
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <label for="ar_attachment" class="col-sm-3 col-form-label">Attachment</label>
                                <div class="col-sm-9">
                                    <input type="file" id="ar_attachment" name="attachment">
                                    <p class="text-danger error-message error-message-attachment" style="display:none"></p>
                                </div>
                            </div> --}}
                            {{-- <div class="form-group row">
                                <label for="ar_commission" class="col-sm-3 col-form-label">Commission</label>
                                <div class="input-group col-sm-9">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-primary" type="button" id="ar_btn_commission_select">Select</button>
                                    </div>
                                    <input type="text" class="form-control" id="ar_commission" name="commission" placeholder="Select Commission" disabled>
                                    <input type="hidden" id="ar_commission_employee_id" name="commission_employee_id" value="">
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-md-6">
                            {{-- <div class="form-group row">
                                <label for="ar_revenue_type" class="col-sm-4 col-form-label">Revenue Type<span class="text-danger ml-1">*</span></label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="ar_revenue_type" name="revenue_type">
                                        <option>Sales</option>
                                    </select>
                                </div>
                            </div> --}}
                            {{-- <div class="form-group row">
                                <label for="payment" class="col-sm-4 col-form-label">Payment Type<span class="text-danger ml-1">*</span></label>
                                <div class="col-sm-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentType" id="ar_paymentType_credit" value="credit">
                                        <label class="form-check-label" for="ar_paymentType_credit">
                                        Credit
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentType" id="ar_paymentType_cash" value="cash">
                                        <label class="form-check-label" for="ar_paymentType_cash">
                                        Cash
                                        </label>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="form-group row">
                                <label for="ar_amount_received" class="col-sm-4 col-form-label">Amount Received<span class="text-danger ml-1">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control text-right" id="ar_amount_received" name="amount_received" placeholder="0.00">
                                    <p class="text-danger error-message error-message-amount_received" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ar_reason" class="col-sm-4 col-form-label">Reason</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="ar_reason" name="reason"></textarea>
                                    <p class="text-danger error-message error-message-reason" style="display:none"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form-advance-revenue">Save & Close</button>
                    <button type="submit" class="btn btn-primary" form="form-advance-revenue" data-new="modal-advance-revenue">Save & New</button>
                </div>
            </div>
        </div>
    </div>
</form>
