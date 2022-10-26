<form class="ajax-submit-updated" action="{{route('receipts.creditReceipt.store')}} "id="form-credit-receipt" method="post" enctype="multipart/form-data" data-message="Successfully added credit receipt.">
    @csrf
    <div class="modal fade" id="modal-credit-receipt" tabindex="-1" role="dialog"
        aria-labelledby="modal-credit-receipt-label" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-credit-receipt-label">New Credit Receipt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row mb-0">
                                <h5 class="col-12">Select Customer</h5>
                            </div>
                            <div class="form-group row">
                                <label for="cr_customer" class="col-4 col-form-label">Customer<span class="text-danger ml-1">*</span> :</label>
                                <div class="col-8">
                                    <input class="form-control" id="cr_customer" name='customer'>
                                    <p class="text-danger error-message error-message-customer" style="display:none"></p>
                                    {{-- Contact Details --}}
                                    <div class="alert alert-info mt-3">
                                        <div class="form-group row m-0">
                                            <label for="cr_tin_number" class="col-6 m-0 p-0 col-form-label text-lg-right">Tin # :</label>
                                            <p id="cr_tin_number" class="m-0 p-0 col-6"></p>
                                        </div>
                                        <div class="form-group row m-0">
                                            <label for="cr_contact_person" class="col-6 m-0 p-0 col-form-label text-lg-right">Contact Person :</label>
                                            <p id="cr_contact_person" class="m-0 p-0 col-6"></p>
                                        </div>
                                        <div class="form-group row m-0">
                                            <label for="cr_mobile_number" class="col-6 m-0 p-0 col-form-label text-lg-right">Contact # :</label>
                                            <p id="cr_mobile_number" class="m-0 p-0 col-6"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="cr_customer_id" name="customer_id" value="">
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row mb-0">
                                <h5 class="col-12">Select Receipt to Pay</h5>
                            </div>
                            <div class="form-group row">
                                <label for="cr_date" class="col-4 col-form-label">Date<span class="text-danger ml-1">*</span> :</label>
                                <div class="col-8">
                                    <input type="date" class="form-control" id="cr_date" name="date" placeholder="" value="{{date('Y-m-d')}}" required>
                                    <p class="text-danger error-message error-message-date" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cr_receipt" class="col-4 col-form-label">Receipt<span class="text-danger ml-1">*</span> :</label>
                                <div class="col-8">
                                    <input class="form-control" id="cr_receipt" name='receipt'>
                                    <p class="text-danger error-message error-message-receipt" style="display:none"></p>
                                    {{-- Receipt Details --}}
                                    <div class="alert alert-info mt-3">
                                        <div class="form-group row m-0">
                                            <label for="cr_receipt_due_date" class="col-6 m-0 p-0 col-form-label text-lg-right">Due Date :</label>
                                            <p id="cr_receipt_due_date" class="m-0 p-0 col-6"></p>
                                        </div>
                                        <div class="form-group row m-0">
                                            <label for="cr_receipt_to_pay" class="col-6 m-0 p-0 col-form-label text-lg-right">Amount To Pay :</label>
                                            <p id="cr_receipt_to_pay" class="m-0 p-0 col-6"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                
                            <div class="form-group row">
                                <label for="cr_date" class="col-4 col-form-label">Amount To Pay<span class="text-danger ml-1">*</span> :</label>
                                <div class="col-8">
                                    <input id="cr_receipt_amount_paid" type="number" step="0.01" min="0" class="form-control text-right inputPrice" name="amount_paid" placeholder="0.00">
                                    <p class="text-danger error-message error-message-amount_paid" style="display:none"></p>
                                </div>
                            </div>
                
                            <div class="form-group row">
                                <label for="cr_remark" class="col-4 col-form-label">Remark</label>
                                <div class="col-8">
                                    <textarea class="form-control" id="cr_remark" name="remark"></textarea>
                                    <p class="text-danger error-message error-message-remark" style="display:none"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form-credit-receipt">Save Credit Receipt</button>
                </div>
            </div>
        </div>
    </div>
</form>