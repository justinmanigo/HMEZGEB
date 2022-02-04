<form id="form-credit-receipt" method="post" enctype="multipart/form-data">
    {{-- <div class="form-group row">
        <label for="inputCustomerName" class="col-sm-3 col-form-label">Customer Name<span class="text-danger ml-1">*</span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="inputCustomerName" placeholder="" required>
        </div>
    </div> --}}

    {{-- Insert Customer, Date, Invoice Number, etc. --}}

    <div class="form-group row">
        <div class="col-lg-6">
            {{-- Deposit Ticket ID --}}
            <div class="row mb-2">
                <label for="deposit_ticket_id" class="col-md-4 col-form-label">Deposit Ticket ID</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" placeholder="" name="deposit_ticket_id">
                </div>
            </div>

            {{-- Customer --}}
            <div class="row mb-2">
                <label for="customer" class="col-md-4 col-form-label">Customer<span class="text-danger ml-1">*</span></label>
                <div class="input-group col-md-8">
                    <div class="input-group-prepend">
                    <button class="btn btn-primary" type="button" id="btn_customer_select">Select</button>
                    </div>
                    <input type="text" class="form-control" placeholder="ARMSTRONG" name="customer" disabled>
                    <input type="hidden" name="customer_id" value="">
                </div>
            </div>

            {{-- Customer Details --}}
            <div class="row mb-2">
                <div class="col-md-4">
                    
                </div>
                <div class="col-md-8">
                    <p>
                        Armstrong Landscaping<br>
                        2300 Club Drive<br>
                        Suite A<br>
                        Nocross, GA 30093
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            {{-- Reference --}}
            <div class="row mb-2">
                <label for="reference" class="col-md-4 col-form-label">Reference</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="reference" placeholder="">
                </div>
            </div>

            {{-- Receipt Number --}}
            <div class="row mb-2">
                <label for="receipt_number" class="col-md-4 col-form-label">Receipt Number</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="receipt_number" placeholder="">
                </div>
            </div>

            {{-- Date --}}
            <div class="row mb-2">
                <label for="date" class="col-md-4 col-form-label">Date<span class="text-danger ml-1">*</span></label>
                <div class="col-md-8">
                    <input type="date" class="form-control" name="date" placeholder="" required>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="row mb-2">
                <label for="date" class="col-md-4 col-form-label">Payment Method<span class="text-danger ml-1">*</span></label>
                <div class="col-md-8">
                    <select class="form-control" name="payment_method" required>
                        <option>Cash</option>
                        <option>Check</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        
    </div>

    <div class="table-responsive mb-3">
        <table class="table table-bordered">
            <thead>
                <th id="thead-actions">Pay</th>
                <th>Invoice</th>
                <th>Date Due</th>
                <th>Amount Due</th>
                <th>Description</th>
                <th>Discount</th>
                <th>Amount Paid<span class="text-danger ml-1">*</span></th>
            </thead>
            <tbody>
                <tr>
                    <td class="table-item-content"> {{-- Actions --}}
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="invoices_1483681825" name="invoices[]" value="1483681825">
                        </div>
                    </td>
                    <td class="table-item-content"> {{-- Invoice --}}
                        <label for="invoices_1483681825">1483681825</label>
                    </td>
                    <td> {{-- Date Due --}}
                        <input type="number" class="form-control" name="date_due[]" value="04/02/2022" disabled>
                    </td>
                    <td> {{-- Amount Due --}}
                        <input type="text" class="form-control inputPrice text-right" name="amount_due[]" value="2,383.94" disabled>
                    </td>
                    <td> {{-- Description --}}
                        <div class="form-group">
                            <input type="text" class="form-control" name="description[]" placeholder="">
                        </div>
                    </td>
                    <td> {{-- Discount --}}
                        <input type="text" class="form-control text-right" name="discount[]" placeholder="0.00">
                    </td>
                    <td> {{-- Amount Paid --}}
                        <input type="text" class="form-control text-right" name="amount_paid[]" placeholder="0.00" required>
                    </td>
                </tr>
                <tr>
                    <td class="table-item-content"> {{-- Actions --}}
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="invoices_1483681826" name="invoices[]" value="">
                        </div>
                    </td>
                    <td class="table-item-content"> {{-- Invoice --}}
                        <label for="invoices_1483681826">1483681826</label>
                    </td>
                    <td> {{-- Date Due --}}
                        <input type="number" class="form-control" name="date_due[]" value="05/02/2022" disabled>
                    </td>
                    <td> {{-- Amount Due --}}
                        <input type="text" class="form-control inputPrice text-right" name="amount_due[]" value="9,645.26" disabled>
                    </td>
                    <td> {{-- Description --}}
                        <div class="form-group">
                            <input type="text" class="form-control" name="description[]" placeholder="">
                        </div>
                    </td>
                    <td> {{-- Discount --}}
                        <input type="text" class="form-control text-right" name="discount[]" placeholder="0.00">
                    </td>
                    <td> {{-- Amount Paid --}}
                        <input type="text" class="form-control text-right" name="amount_paid[]" placeholder="0.00" required>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-right table-item-content" colspan="6"><strong>Receipt Amount: </strong></td>
                    <td>
                        <input type="text" class="form-control text-right" name="receipt_amount" placeholder="0.00" disabled>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row">
        <div class="col-lg-6">
            {{-- Discount Account --}}
            <div class="row">
                <label for="customer" class="col-md-4 col-form-label">Discount Account</label>
                <div class="input-group col-md-8">
                    <div class="input-group-prepend">
                    <button class="btn btn-primary" type="button" id="btn_discount_account_select">Select</button>
                    </div>
                    <input type="text" class="form-control" placeholder="Discount Account" name="discount_account" disabled>
                    <input type="hidden" name="discount_account_id" value="">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            
        </div>
    </div>
</form>