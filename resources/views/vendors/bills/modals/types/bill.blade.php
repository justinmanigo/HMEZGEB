<form class="ajax-submit-updated" action="{{ url('/vendors/bills/bill') }}" id="form-bill" method="post" enctype="multipart/form-data" data-message="Successfully created bill.">
    @csrf
    <div class="modal fade" id="modal-bill" tabindex="-1" role="dialog" aria-labelledby="modal-bill-label"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-bill-label">New Bill</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                            <div class="form-group row">
                                <label for="b_vendor" class="col-4 col-form-label text-left">Vendor<span
                                        class="text-danger ml-1">*</span> :</label>
                                <input class="col-8 col-lg-7" id="b_vendor" name='vendor'>
                                <p class="col-8 col-lg-5 text-danger error-message error-message-vendor" style="display:none"></p>
                            </div>
                            <div class="form-group row">
                                <label for="b_purchase_order" class="col-4 col-form-label text-left">Purchase Order :</label>
                                <input class="col-8 col-lg-7" id="b_purchase_order" name='purchase_order'>
                                <p class="col-8 col-lg-5 text-danger error-message error-message-purchase_order" style="display:none"></p>
                            </div>

                            <div class="form-group row">
                                <label for="b_cash_account" class="col-4 col-form-label text-left">Cash Acct.<span
                                        class="text-danger ml-1">*</span> :</label>
                                <input class="col-8 col-lg-7" id="b_cash_account" name='cash_account'>
                                <p class="col-8 col-lg-5 text-danger error-message error-message-cash_account" style="display:none"></p>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group row">
                                <label for="b_date" class="col-4 col-form-label text-lg-right">Date<span
                                        class="text-danger ml-1">*</span> :</label>
                                <div class="col-8">
                                    <input type="date" class="form-control" id="b_date" name="date" placeholder=""
                                        value="{{date('Y-m-d')}}" required>
                                    <p class="text-danger error-message error-message-date" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="b_date" class="col-4 col-form-label text-lg-right">Due Date<span
                                        class="text-danger ml-1">*</span> :</label>
                                <div class="col-8">
                                    <input type="date" class="form-control" id="b_due_date" name="due_date" placeholder=""
                                        value="{{now()->addDays(7)->format('Y-m-d')}}" required>
                                    <p class="text-danger error-message error-message-due_date" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="b_reference_number" class="col-4 col-form-label text-lg-right">Reference # :</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="b_reference_number" name="reference_number" placeholder="">
                                    <p class="text-danger error-message error-message-reference_number" style="display:none"></p>
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
                            <tbody id="b_items">
                                {{-- <tr>
                                    <td>
                                        <div class="input-group">
                                            <input id="b_item" class="b_item" name='item[]'>
                                            <input type="hidden" name="item_id[]" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="quantity[]" placeholder="Enter Quantity" required>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control inputPrice text-right" name="price[]" placeholder="0.00" disabled>
                                    </td>
                                    <td>
                                        <select class="form-control" name="tax[]">
                                            <option>Sales Tax (15%)</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control text-right" name="total[]" placeholder="0.00" disabled>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete">
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
                                </tr> --}}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right table-item-content" colspan="4">
                                        <strong>Sub Total: </strong>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control text-right" name="sub_total" id="b_sub_total"
                                            placeholder="0.00" value="0.00" readonly>
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
                                        <input type="text" class="form-control text-right b_tax_total" name="tax_total" value="0.00" readonly>
                                        <p class="text-danger error-message error-message-tax" style="display:none"></p>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="text-right table-item-content" colspan="4"><strong>Total: </strong></td>
                                    <td>
                                        <input type="text" class="form-control text-right" name="grand_total" id="b_grand_total"
                                            placeholder="0.00" value="0.00" readonly>
                                        <p class="text-danger error-message error-message-grand_total" style="display:none"></p>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-lg-7">
                            <div class="form-group row">
                                <label for="b_remark" class="col-form-label col-lg-2">Remark:</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="remark" id="b_remark" rows="3"></textarea>
                                    <p class="text-danger error-message error-message-remark" style="display:none"></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="attachment" class="col-form-label col-lg-2">Attachment:</label>
                                <div class="input-group col-md-2 col-lg-5">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile03">
                                        <label class="custom-file-label" for="inputGroupFile03" name="attachment">Choose file</label>
                                    </div>
                                    <p class="text-danger error-message error-message-attachment" style="display:none"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group row">
                                <label for="payment" class="col-form-label col-4">Payment<span class="text-danger ml-1">*</span></label>
                                <div class="col-8">
                                    <input type="text" class="form-control text-right" id="total_amount_received" name="total_amount_received" placeholder="0.00" required>
                                    <p class="text-danger error-message error-message-total_amount_received" style="display:none"></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="b_withholding_amount" class="col-4 col-form-label">Withholding <span id="b_withholding_required" class="text-danger ml-1 d-none">*</span> :</label>
                                <div class="col-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" id="b_withholding_toggle" name="withholding_check" value="on" aria-label="Enable/Disable withholding">
                                            </div>
                                        </div>
                                        <input class="form-control inputPrice text-right" type="text" id="b_withholding" name="withholding" placeholder="0.00" disabled required>
                                    </div>
                                    <p class="text-danger error-message error-message-withholding" style="display:none"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form-bill">Save & Close</button>
                    <button type="submit" class="btn btn-primary" form="form-bill" data-new="modal-bill">Save & New</button>
                </div>
            </div>
        </div>
    </div>
</form>
