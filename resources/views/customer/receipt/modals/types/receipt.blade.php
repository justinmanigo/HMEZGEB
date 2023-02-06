<form class="ajax-submit-updated" action="{{route('receipts.receipt.store') }}" id="form-receipt" method="post" enctype="multipart/form-data" data-message="Successfully created receipt.">
    @csrf
    <div class="modal fade" id="modal-receipt" tabindex="-1" role="dialog" aria-labelledby="modal-receipt-label"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-receipt-label">New Receipt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                            <h5>Customer Details:</h5>
                            <div class="form-group row">
                                <label for="r_customer" class="col-4 col-form-label text-left">Customer<span class="text-danger ml-1">*</span> :</label>
                                <input class="col-8 col-lg-7 form-control" id="r_customer" name='customer'>
                                <input type="hidden" id="r_customer_id" name="customer_id" value="">
                                <p class="col-8 col-lg-5 text-danger error-message error-message-customer" style="display:none"></p>
                            </div>
                            {{-- Contact Details --}}
                            <div class="form-group row m-0">
                                <p class="col-4 text-lg-right p-0 m-0">Tin # :</p>
                                <p class="col-8 pl-3 p-0 m-0" id="r_tin_number"></p>
                            </div>
                            <div class="form-group row m-0">
                                <p class="col-4 text-lg-right p-0 m-0">Contact Person :</p>
                                <p class="col-8 pl-3 p-0 m-0" id="r_contact_person"></p>
                            </div>
                            <div class="form-group row m-0">
                                <p class="col-4 text-lg-right p-0 m-0">Contact # :</p>
                                <p class="col-8 pl-3 p-0 m-0" id="r_mobile_number"></p>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group row">
                                <label for="r_date" class="col-4 col-form-label text-lg-right">Date<span class="text-danger ml-1">*</span> :</label>
                                <div class="col-8">
                                    <input type="date" class="form-control" id="r_date" name="date" placeholder="" value="{{date('Y-m-d')}}" required>
                                    <p class="text-danger error-message error-message-date" style="display:none"></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="r_proforma" class="col-4 col-form-label text-lg-right">Proforma # :</label>
                                <div class="col-8">
                                    <input type="text" id="r_proforma" class="col-12 form-control" name="proforma">
                                    <p class="text-danger error-message error-message-proforma" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="r_due_date" class="col-4 col-form-label text-lg-right">Due Date :</label>
                                <div class="col-8">
                                    <input type="date" class="form-control" id="r_due_date" name="due_date" placeholder="" value="{{date('Y-m-d', strtotime('+7 days'))}}" required>
                                    <p class="text-danger error-message error-message-due_date" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="r_cash_account" class="col-4 col-form-label text-lg-right">Cash Acct.<span class="text-danger ml-1">*</span> :</label>
                                <div class="col-8">
                                    <input id="r_cash_account" class="col-12 form-control" name='cash_account'>
                                    <p class="text-danger error-message error-message-cash_account" style="display:none"></p>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <th>Name<span class="text-danger ml-1">*</span></th>
                                <th>Quantity<span class="text-danger ml-1">*</span></th>
                                <th>Price</th>
                                <th>Tax<span class="text-danger ml-1">*</span></th>
                                <th>Total</th>
                                <th class="thead-actions">Actions</th>
                            </thead>
                            <tbody id="r_items">
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right table-item-content" colspan="4">
                                        <strong>Sub Total: </strong>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control text-right" name="sub_total" id="r_sub_total" placeholder="0.00" value="0.00" readonly>
                                        <p class="text-danger error-message error-message-sub_total" style="display:none"></p>
                                    </td>
                                    <td></td>
                                </tr>
                                {{-- <tr>
                                    <td colspan="3" class="text-right"><span class="text-muted">Add toggle here</span></td>
                                    <td class="text-right table-item-content"><strong>Discount: </strong></td>
                                    <td>
                                        <input type="text" class="form-control text-right" name="discount" placeholder="0.00">
                                        <p class="text-danger error-message error-message-discount" style="display:none"></p>
                                    </td>
                                    <td></td>
                                </tr> --}}
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <div class="form-check">
                                            <label class="form-check-label mr-5" for="r_withholding_toggle">Withholding</label>
                                            <input class="form-check-input" id="r_withholding_toggle" type="checkbox" value="on" name="withholding_check">
                                        </div>
                                    </td>
                                    <td class="text-right table-item-content"><strong>Withholding: </strong></td>
                                    <td>
                                        <input type="text" class="form-control text-right" name="withholding" id="r_withholding" value="0.00" readonly>
                                        <p class="text-danger error-message error-message-withholding" style="display:none"></p>
                                    </td>
                                    <td></td>
                                </tr>
                                {{-- <tr>
                                    <td class="text-right table-item-content" colspan="4"><strong>Non-Taxable: </strong></td>
                                    <td>
                                        <input type="text" class="form-control text-right" name="tax" placeholder="0.00" disabled>
                                        <p class="text-danger error-message error-message-tax" style="display:none"></p>
                                    </td>
                                    <td></td>
                                </tr> --}}
                                <tr>
                                    <td class="text-right table-item-content" colspan="4"><strong>Tax: </strong></td>
                                    <td>
                                        <input type="text" class="form-control text-right r_tax_total" name="tax_total" value="0.00" readonly>
                                        <p class="text-danger error-message error-message-tax" style="display:none"></p>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="text-right table-item-content" colspan="4"><strong>Total: </strong></td>
                                    <td>
                                        <input type="text" class="form-control text-right" name="grand_total" id="r_grand_total" placeholder="0.00" value="0.00" readonly>
                                        <p class="text-danger error-message error-message-grand_total" style="display:none"></p>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="r_remark" class="col-sm-3 col-form-label">Remark</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="r_remark" name="remark"></textarea>
                                    <p class="text-danger error-message error-message-remark" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="r_attachment" class="col-sm-3 col-form-label">Attachment</label>
                                <div class="col-sm-9">
                                    <input type="file" id="r_attachment" name="attachment">
                                    <p class="text-danger error-message error-message-attachment" style="display:none"></p>
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <label for="r_commission" class="col-sm-3 col-form-label">Commission</label>
                                <div class="input-group col-sm-9">
                                    <div class="input-group-prepend">
                                    <button class="btn btn-primary" type="button" id="r_btn_commission_select">Select</button>
                                    </div>
                                    <input type="text" class="form-control" id="r_commission" name="commission" placeholder="Select Commission" disabled>
                                    <input type="hidden" id="r_commission_employee_id" name="commission_employee_id" value="">
                                    <p class="text-danger error-message error-message-commission" style="display:none"></p>
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-md-6">
                            {{-- <div class="form-group row">
                                <label for="r_revenue_type" class="col-sm-4 col-form-label">Revenue Type<span class="text-danger ml-1">*</span></label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="r_revenue_type" name="revenue_type">
                                        <option>Sales</option>
                                    </select>
                                    <p class="text-danger error-message error-message-revenue_type" style="display:none"></p>
                                </div>
                            </div> --}}
                            {{--<div class="form-group row">
                                <label for="payment" class="col-sm-4 col-form-label">Payment Type<span class="text-danger ml-1">*</span></label>
                                <div class="col-sm-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentType" id="r_paymentType_credit" value="credit">
                                        <label class="form-check-label" for="r_paymentType_credit">
                                        Credit
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentType" id="r_paymentType_cash" value="cash">
                                        <label class="form-check-label" for="r_paymentType_cash">
                                        Cash
                                        </label>
                                    </div>
                                    <p class="text-danger error-message error-message-paymentType" style="display:none"></p>
                                </div>
                            </div>--}}
                            <div class="form-group row">
                                <label for="r_payment" class="col-sm-4 col-form-label">Payment<span class="text-danger ml-1">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control text-right" id="r_total_amount_received" name="total_amount_received" placeholder="0.00" required>
                                    <p class="text-danger error-message error-message-total_amount_received" style="display:none"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form-receipt">Save & Close</button>
                    <button type="submit" class="btn btn-primary" form="form-receipt" data-new="modal-receipt">Save & New</button>
                </div>
            </div>
        </div>
    </div>
</form>
