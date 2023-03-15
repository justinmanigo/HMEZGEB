<form class="ajax-submit-updated" action="{{route('receipts.proformas.store') }}" id="form-proforma" method="post" enctype="multipart/form-data" data-message="Successfully created proforma." data-noreload="true" data-onsuccess="proforma_search" data-onsuccessparam="proformas_page_number_current" data-modal="modal-proforma">
    @csrf
    <div class="modal fade" id="modal-proforma" tabindex="-1" role="dialog" aria-labelledby="modal-proforma-label" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-proforma-label">New Proforma</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                            <h5>Customer Details:</h5>
                            <div class="form-group row">
                                <label for="p_customer" class="col-4 col-form-label text-left">Customer<span class="text-danger ml-1">*</span> :</label>
                                <input class="col-8 col-lg-7" id="p_customer" name='customer'>
                                <input type="hidden" id="p_customer_id" name="customer_id" value="">
                                <p class="col-8 col-lg-5 text-danger error-message error-message-customer" style="display:none"></p>
                            </div>
                            {{-- Contact Details --}}
                            <div class="form-group row mb-0">
                                <label for="p_tin_number" class="col-4 col-form-label text-lg-right">Tin # :</label>
                                <input type="text" id="p_tin_number" class="form-control-plaintext col-8 pl-3" placeholder="" name="tin_number" disabled readonly>
                                </div>
                            <div class="form-group row mb-0">
                                <label for="p_contact_person" class="col-4 col-form-label text-lg-right">Contact Person :</label>
                                <input type="text" id="p_contact_person" class="form-control-plaintext col-8 pl-3" placeholder="" name="contact_person" disabled readonly>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="p_mobile_number" class="col-4 col-form-label text-lg-right">Contact # :</label>
                                <input type="text" id="p_mobile_number" class="form-control-plaintext col-8 pl-3" placeholder="" name="mobile_number" disabled readonly>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group row">
                                <label for="p_date" class="col-4 col-form-label text-lg-right">Date<span class="text-danger ml-1">*</span> :</label>
                                <div class="col-8">
                                    <input type="date" class="form-control" id="p_date" name="date" placeholder="" value="{{date('Y-m-d')}}" required>
                                </div>
                                <p class="text-danger error-message error-message-date" style="display:none"></p>
                            </div>

                            <div class="form-group row">
                                <label for="p_due_date" class="col-4 col-form-label text-lg-right">Due Date :</label>
                                <div class="col-8">
                                    <input type="date" class="form-control" id="p_due_date" name="due_date" placeholder="" value="{{date('Y-m-d', strtotime('+7 days'))}}" required>
                                    <p class="text-danger error-message error-message-due_date" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="p_reference_no" class="col-4 col-form-label text-lg-right">Reference #:</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="p_reference_number" name="reference_number" placeholder="" value="">
                                    <p class="text-danger error-message error-message-due_date" style="display:none"></p>
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
                            <tbody id="p_items">
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right table-item-content" colspan="4">
                                        <strong>Sub Total: </strong>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control text-right" name="sub_total" id="p_sub_total" placeholder="0.00" value="0.00" readonly>
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
                                    <td colspan="3" class="text-right"><span class="text-muted">Add toggle here</span></td>
                                    <td class="text-right table-item-content"><strong>Withholding: </strong></td>
                                    <td>
                                        <input type="text" class="form-control text-right" name="withholding" placeholder="0.00">
                                        <p class="text-danger error-message error-message-withholding" style="display:none"></p>
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
                                        <input type="text" class="form-control text-right p_tax_total" name="tax_total" value="0.00" readonly>
                                        <p class="text-danger error-message error-message-tax" style="display:none"></p>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="text-right table-item-content" colspan="4"><strong>Total: </strong></td>
                                    <td>
                                        <input type="text" class="form-control text-right" name="grand_total" id="p_grand_total" placeholder="0.00" value="0.00" readonly>
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
                                <label for="p_terms_and_condition" class="col-sm-3 col-form-label">Terms and Conditions:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="p_terms_and_condition" name="terms_and_condition"></textarea>
                                    <p class="text-danger error-message error-message-terms_and_condition" style="display:none"></p>
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <label for="p_attachment" class="col-sm-3 col-form-label">Attachment</label>
                                <div class="col-sm-9">
                                    <input type="file" id="p_attachment" name="attachment">
                                    <p class="text-danger error-message error-message-attachment" style="display:none"></p>
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form-proforma">Save & Close</button>
                    <button type="submit" class="btn btn-primary" form="form-proforma" data-new="modal-proforma">Save & New</button>
                </div>
            </div>
        </div>
    </div>
</form>
