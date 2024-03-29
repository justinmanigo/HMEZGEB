@extends('template.index')

@push('styles')
<style>
    .content-card {
        border-radius: 0px 0px 5px 5px;
    }
</style>
@endpush

@section('content')

<div>

    <div class="d-flex justify-content-between align-items-end">
        {{-- Tab Navigation --}}
        <ul class="nav nav-tabs d-flex" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="receipt-tab" data-toggle="tab" href=".receipt" role="tab" aria-controls="receipt" aria-selected="true">Receipt</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="advance_receipt-tab" data-toggle="tab" href=".advance_receipt" role="tab" aria-controls="advance_receipt" aria-selected="false">Advance Receipt</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="credit_receipt-tab" data-toggle="tab" href=".credit_receipt" role="tab" aria-controls="credit_receipt" aria-selected="false">Credit Receipt</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="bill-tab" data-toggle="tab" href=".bill" role="tab" aria-controls="bill" aria-selected="false">Bill</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="payment-tab" data-toggle="tab" href=".payment" role="tab" aria-controls="payment" aria-selected="false">Payment</a>
            </li>
        </ul>

    </div>


        {{-- Tab Contents --}}
    <div class="card">
        <div class="card-body tab-content">
            <!--Receipt content--->
            <div class="tab-pane fade show active receipt">
                <section>
                    {{-- <form>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Fs#-</span>
                            </div>
                            <input disabled type="text" class="form-control tagify-defaults" placeholder="Receipt Reference Number" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="form-group">
                                <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button>
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                <button type="button" class="btn btn-danger btn-sm">Cancel</button>
                            <div>
                    </form>    --}}
                    <form id="form-defaults-receipts" class="my-3 ajax-submit-updated" data-noreload="1" method="post" action="{{ url('/ajax/settings/defaults/receipts') }}" data-message="Changes saved.">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Cash on Hand:</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="receipt_cash_on_hand">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">VAT Payable:</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="receipt_vat_payable">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Sales:</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="receipt_sales">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Account Receivable:</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="receipt_account_receivable">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Sales Discount:</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="receipt_sales_discount">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Withholding:</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="receipt_withholding">
                                </div>
                        </div>
                        <div class="form-group">
                            {{-- <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button> --}}
                            <button type="submit" class="btn btn-primary btn-sm" form="form-defaults-receipts">Save</button>
                            <button type="button" class="btn btn-danger btn-sm">Cancel</button>
                        <div>
                    </form>
                </section>
            </div>

            <!--Advance Receipt content--->
            <div class=" tab-pane fade advance_receipt">
                <section>
                    {{-- <form>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">AdvRec#-</span>
                            </div>
                            <input disabled type="text" class="form-control tagify-defaults" placeholder="Advance Receipt Reference Number" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="form-group">
                                <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button>
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                <button type="button" class="btn btn-danger btn-sm">Cancel</button>
                            <div>
                    </form>    --}}
                    <form id="form-defaults-advance-receipts" class="my-3 ajax-submit-updated" data-noreload="1" method="post" action="{{ url('/ajax/settings/defaults/advance-receipts') }}" data-message="Changes saved.">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Cash on Hand:</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="advance_receipt_cash_on_hand">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Advance Payment:</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="advance_receipt_advance_payment">
                                </div>
                        </div>
                        <div class="form-group">
                            {{-- <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button> --}}
                            <button type="submit" class="btn btn-primary btn-sm" form="form-defaults-advance-receipts">Save</button>
                            <button type="button" class="btn btn-danger btn-sm">Cancel</button>
                        <div>
                    </form>
                </section>
            </div>
            <!--Credit Receipt content--->
            <div class=" tab-pane fade credit_receipt">
                <section>
                    {{-- <form>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">CrR#-</span>
                            </div>
                            <input disabled type="text" class="form-control tagify-defaults" placeholder="Credit Receipt Reference Number" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="form-group">
                                <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button>
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                <button type="button" class="btn btn-danger btn-sm">Cancel</button>
                            <div>
                    </form>    --}}
                    <form id="form-defaults-credit-receipts" class="my-3 ajax-submit-updated" data-noreload="1" method="post" action="{{ url('/ajax/settings/defaults/credit-receipts') }}" data-message="Changes saved.">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Cash on Hand:</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="credit_receipt_cash_on_hand">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Account Receivable</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="credit_receipt_account_receivable">
                                </div>
                        </div>
                        <div class="form-group">
                            {{-- <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button> --}}
                            <button type="submit" class="btn btn-primary btn-sm" form="form-defaults-credit-receipts">Save</button>
                            <button type="button" class="btn btn-danger btn-sm">Cancel</button>
                        <div>
                    </form>
                </section>
            </div>
            <!--bill content--->
            <div class=" tab-pane fade bill">
            <section>
                    {{-- <form>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Bill#-</span>
                            </div>
                            <input disabled type="text" class="form-control tagify-defaults" placeholder="Bill Reference Number" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="form-group">
                                <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button>
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                <button type="button" class="btn btn-danger btn-sm">Cancel</button>
                            <div>
                    </form>    --}}
                    <form id="form-defaults-bills" class="my-3 ajax-submit-updated" data-noreload="1" method="post" action="{{ url('/ajax/settings/defaults/bills') }}" data-message="Changes saved.">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Cash on Hand:</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="bill_cash_on_hand">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Items for Sale</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="bill_items_for_sale">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Freight Charge Expense:</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="bill_freight_charge_expense">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">VAT Receivable:</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="bill_vat_receivable">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Account Payable:</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="bill_account_payable">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Withholding:</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="bill_withholding">
                                </div>
                        </div>
                        <div class="form-group">
                            {{-- <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button> --}}
                            <button type="submit" class="btn btn-primary btn-sm" form="form-defaults-bills">Save</button>
                            <button type="button" class="btn btn-danger btn-sm">Cancel</button>
                        <div>
                    </form>
                </section>
            </div>
             <!--payment content--->
            <div class=" tab-pane fade payment">
            <section>
                    {{-- <form>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">PV#-</span>
                            </div>
                            <input disabled type="text" class="form-control tagify-defaults" placeholder="Receipt Reference Number" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="form-group">
                                <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button>
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                <button type="button" class="btn btn-danger btn-sm">Cancel</button>
                            <div>
                    </form>    --}}
                    <form id="form-defaults-payments" class="my-3 ajax-submit-updated" data-noreload="1" method="post" action="{{ url('/ajax/settings/defaults/payments') }}" data-message="Changes saved.">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Cash on Hand:</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="payment_cash_on_hand">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">VAT Receivable:</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="payment_vat_receivable">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Account Payable</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="payment_account_payable">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Withholding</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="payment_withholding">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Salary Payable</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="payment_salary_payable">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Commission Payment</label>
                                <div class="col-md-10">
                                    <input disabled type="text" class="form-control tagify-defaults" name="payment_commission_payment">
                                </div>
                        </div>
                        <div class="form-group">
                            {{-- <button type="submit" class="btn btn-secondary btn-sm">Set as Default</button> --}}
                            <button type="submit" class="btn btn-primary btn-sm" form="form-defaults-payments">Save</button>
                            <button type="button" class="btn btn-danger btn-sm">Cancel</button>
                        <div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#dataTables').DataTable();
        $('#dataTables2').DataTable();
        $('.dataTables_filter').addClass('pull-right');
    });
</script>
<script src="{{ url('/js/settings/defaults/defaults.js') }}"></script>
@endsection
