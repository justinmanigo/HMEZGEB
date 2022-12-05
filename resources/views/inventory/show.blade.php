@extends('template.index')

@push('styles')
<style>
.w-15 {
    width: 15%;
}
</style>
@endpush

@section('content')

<main>
    <div class="d-flex justify-content-between align-items-start">
        <!---buttons--->
        <div class="d-flex">
            <!--add item btn--->
            <a type="button" class="btn btn-info mx-1" href="{{ url('/inventory') }}">Back to Inventory</a>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">

            <div class="row">
                <div class="col-12 col-lg-8">

                    <h5>Item Information</h5>
                    <div class="form-group row">
                        <label for="#" class="col-form-label col-4">Code</label>
                        <div class="col-8">
                            <input readonly type="text" class="form-control-plaintext" name="item_code" required value="{{ $inventory->item_code }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="#" class="col-form-label col-4">Name</label>
                        <div class="col-8">
                            <input readonly type="text" class="form-control-plaintext" name="item_name" required value="{{ $inventory->item_name }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="#" class="col-form-label col-4">Description</label>
                        <div class="col-8">
                            <textarea readonly id="" class="form-control-plaintext" rows="6"  name="description" required>{{ $inventory->description }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="#" class="col-form-label col-4">Inventory Type</label>
                        <div class="col-8">
                            <div class="form-check row ml-1">
                                <input disabled class="form-check-input" type="radio" name="inventory_type" id="ar_paymentType_credit" value="inventory_item" @if($inventory->inventory_type == 'inventory_item') checked="checked" @endif>
                                <label class="form-check-label" for="ar_paymentType_credit">
                                Inventory item
                                </label>
                            </div>
                            <div class="form-check row ml-1">
                                <input disabled class="form-check-input" type="radio" name="inventory_type" id="ar_paymentType_cash" value="non_inventory_item" @if($inventory->inventory_type == 'non_inventory_item') checked="checked" @endif>
                                <label class="form-check-label" for="ar_paymentType_cash">
                                Non-inventory item
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-form-label col-4">Photo</label>
                        <img src="@if($inventory->picture != null || $inventory->picture != '') {{ asset('public/inventories/'.$inventory->picture) }} @else {{ asset('img/blank.jpg') }} @endif" alt="{{ $inventory->item_name }}" style="width:100px">
                    </div>

                </div>
                <div class="col-12 col-lg-4">

                    <h5>Item Price</h5>

                    <div class="form-group row">
                        <label for="#" class="col-4 col-form-label">Purchase Price</label>
                        <div class="col-8">
                            <input readonly type="number" class="form-control-plaintext inputPrice text-right"  name="purchase_price" step=".01" placeholder="0.00" required value="{{ $inventory->purchase_price }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="#" class="col-4 col-form-label">Sale Price</label>
                        <div class="col-8">
                            <input readonly type="number" class="form-control-plaintext inputPrice text-right"  name="sale_price" step=".01" placeholder="0.00" required value="{{ $inventory->sale_price }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="#" class="col-4 col-form-label">Tax</label>
                        <div class="col-8">
                            <input readonly class="form-control-plaintext" id="" name="tax_id" value="@if(isset($inventory->tax)) {{ "{$inventory->tax->name} ({$inventory->tax->percentage}%)" }} @endif">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="#" class="col-4 col-form-label">Critical Quantity</label>
                        <div class="col-8">
                            <input readonly type="number" class="form-control-plaintext inputPrice text-right"  name="critical_quantity" placeholder="0" required value="{{ $inventory->critical_quantity }}" @if($inventory->inventory_type == 'non_inventory_item') disabled='disabled' @endif>
                            <div class="form-check mt-2">
                                <input readonly class="form-check-input" id="c_notify_critical_quantity" type="checkbox" value="Yes" name="notify_critical_quantity" @if($inventory->notify_critical_quantity == 'Yes') checked='checked' @endif disabled='disabled'>
                                <label class="form-check-label" for="c_notify_critical_quantity">Notify me when stocks reach critical level</label>
                            </div>
                        </div>
                    </div>

                    <h5>Default Accounts</h5>
                    <div class="form-group row">
                        <label for="#" class="col-4 col-form-label">Expense Account</label>
                        <div class="col-8">
                            <input readonly name="default_income_account" class="form-control-plaintext" id="" disabled value="{{ $inventory->default_income_account }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="#" class="col-4 col-form-label">Income Account</label>
                        <div class="col-8">
                            <input readonly name="default_expense_account" class="form-control-plaintext" id="" disabled value="{{ $inventory->default_expense_account }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <a role="button" class="btn btn-secondary" href="{{ url('/inventory') }}">Back to Inventory</a>
                <button type="submit" class="btn btn-primary" >Edit Item</button>
            </div>

        </div>
    </div>


</main>

<script>
$(document).ready(function() {
    $('#dataTables').DataTable();
    $('.dataTables_filter').addClass('pull-right');
});

// This function toggles when the inventory_item radio button is changed
$(document).ready(function() {
    $('input[type=radio][name=inventory_type]').change(function() {
        if (this.value == 'inventory_item') {
            $('input[name=critical_quantity]').removeAttr('disabled');
            $('input[name=notify_critical_quantity]').removeAttr('disabled');
        } else {
            $('input[name=critical_quantity]').attr('disabled', true);
            $('input[name=notify_critical_quantity]').attr('disabled', true);
        }
    });
});
</script>
@endsection
