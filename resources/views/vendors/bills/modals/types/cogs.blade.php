<form class="ajax-submit-updated" action="{{ url('/vendors/bills/cogs') }}" id="form-cogs" method="post" enctype="multipart/form-data" data-message="Successfully created COGS." data-noreload="true" data-onsuccess="bill_search" data-onsuccessparam="bills_page_number_current" data-modal="modal-cogs">
    @csrf
    <div class="modal fade" id="modal-cogs" tabindex="-1" role="dialog" aria-labelledby="modal-cogs-label"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-cogs-label">New Cost of Goods Sold</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-5 mb-3 mb-lg-0">
                            <h5>Details:</h5>

                            <div class="form-group row">
                                <label for="cogs_cash_account" class="col-4 col-form-label text-left">Cash Acct:<span class="text-danger ml-1">*</span> :</label>

                                <div class="col-8">
                                    <input class="form-control" id="cogs_cash_account" name='cash_account'>
                                    <p class="text-danger error-message error-message-cash_account" style="display:none"></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="cogs_date" class="col-4 col-form-label">Date<span class="text-danger ml-1">*</span> :</label>
                                <div class="col-8">
                                    <input type="date" class="form-control" id="cogs_date" name="date" placeholder="" value="{{date('Y-m-d')}}" required>
                                    <p class="text-danger error-message error-message-date" style="display:none"></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="cogs_reference_number" class="col-4 col-form-label">Reference # :</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" id="cogs_reference_number" name="reference_number">
                                    <p class="text-danger error-message error-message-reference_number" style="display:none"></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="cogs_remark" class="col-4 col-form-label">Remark :</label>
                                <div class="col-8">
                                    <textarea class="form-control" id="cogs_remark" name="remark"></textarea>
                                    <p class="text-danger error-message error-message-remark" style="display:none"></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="cogs_attachment" class="col-4 col-form-label">Attachment :</label>
                                <div class="col-8">
                                    <input type="file" id="sattachment" name="attachment">
                                    <p class="text-danger error-message error-message-attachment" style="display:none"></p>
                                </div>
                            </div>

                        </div>

                        <div class="col-12 col-lg-7">
                            <h5>Transaction: </h5>

                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <tbody>
                                        <tr>
                                            <td class="text-right table-item-content" width="150px"><strong>Price</strong><span class="text-danger ml-1">*</span></td>
                                            <td>
                                                <input class="form-control inputPrice text-right" type="text" id="cogs_price_amount" name="price_amount" placeholder="0.00" required>
                                                <p class="text-danger error-message error-message-price_amount" style="display:none"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right table-item-content"><strong>Tax</strong></td>
                                            <td>

                                                <div class="input-group">
                                                    <input class="form-control" id="cogs_tax" name="tax">
                                                    <input class="form-control inputPrice text-right" type="text" id="cogs_tax_amount" name="tax_amount" value="0.00" readonly>
                                                </div>
                                                <p class="text-danger error-message error-message-tax_amount" style="display:none"></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody>
                                        <th class="text-right table-item-content"><strong>Sub Total</strong></th>
                                        <th>
                                            <input class="form-control inputPrice text-right" type="text" id="cogs_sub_total" name="sub_total" value="0.00" readonly>
                                            <p class="text-danger error-message error-message-sub_total" style="display:none"></p>
                                        </th>
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <td class="text-right table-item-content"><strong>Discount</strong></td>
                                            <td>
                                                <input class="form-control inputPrice text-right" type="text" id="cogs_discount_amount" name="discount_amount" placeholder="0.00">
                                                <p class="text-danger error-message error-message-discount_amount" style="display:none"></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <th class="text-right table-item-content"><strong>Grand Total</strong></th>
                                        <th>
                                            <input class="form-control inputPrice text-right" type="text" id="cogs_grand_total" name="grand_total" value="0.00" readonly>
                                            <p class="text-danger error-message error-message-grand_total" style="display:none"></p>
                                        </th>
                                    </tfoot>
                                </table>
                            </div>

                            <hr>

                            <h5>Payment: </h5>
                            <div class="form-group row">
                                <label for="cogs_total_amount_received" class="col-4 col-form-label">Amount <span class="text-danger ml-1">*</span> :</label>
                                <div class="col-8">
                                    <div class="input-group">
                                        <select class="form-control" id="cogs_payment_type" name="payment_type">
                                            <option value="" selected disabled hidden>Select...</option>
                                            <option value="cash">Cash</option>
                                            <option value="credit">Credit</option>
                                        </select>
                                        <input type="text" class="form-control text-right" id="cogs_total_amount_received" name="total_amount_received" placeholder="0.00" required>
                                    </div>

                                    <p class="text-danger error-message error-message-total_amount_received" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cogs_withholding_amount" class="col-4 col-form-label">Withholding <span id="cogs_withholding_required" class="text-danger ml-1 d-none">*</span> :</label>
                                <div class="col-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" id="cogs_withholding_toggle" name="withholding_check" value="on" aria-label="Enable/Disable withholding">
                                            </div>
                                        </div>
                                        <input class="form-control inputPrice text-right" type="text" id="cogs_withholding_amount" name="withholding_amount" placeholder="0.00" disabled required>
                                    </div>
                                    <p class="text-danger error-message error-message-withholding_amount" style="display:none"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form-cogs">Save & Close</button>
                    <button type="submit" class="btn btn-primary" form="form-cogs" data-new="modal-cogs">Save & New</button>
                </div>
            </div>
        </div>
    </div>
</form>
