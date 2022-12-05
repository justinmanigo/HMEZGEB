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

            <form action="{{ url('/inventory/'.$inventory->id) }}"  method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-12 col-lg-8">

                        <h5>Item Information</h5>
                        <div class="form-group row">
                            <label for="#" class="col-form-label col-4">Code</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="item_code" required value="{{ $inventory->item_code }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="#" class="col-form-label col-4">Name</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="item_name" required value="{{ $inventory->item_name }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="#" class="col-form-label col-4">Description</label>
                            <div class="col-8">
                                <textarea  id="" class="form-control" rows="6"  name="description" required>{{ $inventory->description }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="#" class="col-form-label col-4">Inventory Type</label>
                            <div class="col-8">
                                <div class="form-check row ml-1">
                                    <input class="form-check-input" type="radio" name="inventory_type" id="ar_paymentType_credit" value="inventory_item" @if($inventory->inventory_type == 'inventory_item') checked="checked" @endif>
                                    <label class="form-check-label" for="ar_paymentType_credit">
                                    Inventory item
                                    </label>
                                </div>
                                <div class="form-check row ml-1">
                                    <input class="form-check-input" type="radio" name="inventory_type" id="ar_paymentType_cash" value="non_inventory_item" @if($inventory->inventory_type == 'non_inventory_item') checked="checked" @endif>
                                    <label class="form-check-label" for="ar_paymentType_cash">
                                    Non-inventory item
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-form-label col-4">Photo</label>
                            <div class="input-group mb-3 col-8">
                                <div class="custom-file">
                                    <input type="file" accept="image/*" class="custom-file-input" id="inputGroupFile03" name="picture" value="{{ $inventory->image }}" disabled>
                                    <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-lg-4">

                        <h5>Item Price</h5>

                        <div class="form-group row">
                            <label for="#" class="col-4 col-form-label">Purchase Price</label>
                            <div class="col-8">
                                <input type="number" class="form-control inputPrice text-right"  name="purchase_price" step=".01" placeholder="0.00" required value="{{ $inventory->purchase_price }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="#" class="col-4 col-form-label">Sale Price</label>
                            <div class="col-8">
                                <input type="number" class="form-control inputPrice text-right"  name="sale_price" step=".01" placeholder="0.00" required value="{{ $inventory->sale_price }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="#" class="col-4 col-form-label">Tax</label>
                            <div class="col-8">
                                <select class="form-control" id="" name="tax_id">
                                    <option value="" selected disabled hidden>Choose</option>
                                    <option value="">No Tax</option>
                                    @foreach($taxes as $tax)
                                        <option value="{{ $tax->id }}" @if($tax->id == $inventory->tax_id) selected='selected' @endif>{{ $tax->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="#" class="col-4 col-form-label">Critical Quantity</label>
                            <div class="col-8">
                                <input type="number" class="form-control inputPrice text-right"  name="critical_quantity" placeholder="0" required value="{{ $inventory->critical_quantity }}" @if($inventory->inventory_type == 'non_inventory_item') disabled='disabled' @endif>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" id="c_notify_critical_quantity" type="checkbox" value="Yes" name="notify_critical_quantity" @if($inventory->notify_critical_quantity == 'Yes') checked='checked' @endif @if($inventory->inventory_type == 'non_inventory_item') disabled='disabled' @endif>
                                    <label class="form-check-label" for="c_notify_critical_quantity">Notify me when stocks reach critical level</label>
                                </div>
                            </div>
                        </div>

                        <h5>Default Accounts</h5>
                        <div class="form-group row">
                            <label for="#" class="col-4 col-form-label">Expense Account</label>
                            <div class="col-8">
                                <select name="default_income_account" class="form-control" id="" disabled value="{{ $inventory->default_income_account }}">
                                    <option>Choose</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="#" class="col-4 col-form-label">Income Account</label>
                            <div class="col-8">
                                <select name="default_expense_account" class="form-control" id="" disabled value="{{ $inventory->default_expense_account }}">
                                    <option>Choose</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- text-left --}}
                <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">Delete</button>

                    <div class="text-right">
                        <a role="button" class="btn btn-secondary" href="{{ url('/inventory') }}">Close</a>
                        <button type="submit" class="btn btn-primary" >Update Item</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    {{-- modal delete --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this item?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <form action="{{ url('/inventory/'.$inventory->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
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
