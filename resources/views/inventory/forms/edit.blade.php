@extends('template.index')
@section('content')

<div class="modal-header ">
    <h5 class="modal-title" id="modal-customer-label">Edit Inventory</h5>
</div>
<br />

<form id="form-customer" action="{{ url('inventory/'.$inventory->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')


    <div class="form-group row">
        <label for="#" class="col-lg-2 col-form-label">Item Code:</label>
        <div class="col-lg-4">
            <input type="text" class="form-control" name="item_code" required value="{{$inventory->id}}">
        </div>
        <label for="#" class="col-lg-2 col-form-label">Item Name:</label>
        <div class="col-lg-4">
            <input type="text" class="form-control" name="item_name" required value="{{$inventory->item_name}}">
        </div>
    </div>
    <div class="form-group row">
        <label for="#" class="col-lg-2 col-form-label">Sale Price:</label>
        <div class="col-lg-4">
            <input type="number" class="form-control inputPrice" name="sale_price" step=".01" required value="{{$inventory->sale_price}}">
        </div>
        <label for="#" class="col-lg-2 col-form-label">Purchase Price:</label>
        <div class="col-lg-4">
            <input type="number" class="form-control inputPrice" name="purchase_price" step=".01" required value="{{$inventory->purchase_price}}">
        </div>
    </div>
    <div class="form-group row">
        <label for="" class="col-lg-2 col-form-label">Quantity:</label>
        <div class="col-lg-4">
            <input type="number" class="form-control" name="quantity" value="0" required value="{{$inventory->id}}">
        </div>
        <label for="" class="col-sm-2">Tax:</label>
        <div class="col">
            <select class="form-control" id="" name="tax_id">
                <option value="" selected disabled hidden>Choose</option>
                <option value="" {{ ($inventory->tax_id == '') ? 'disabled' : 'disabled'}}>No Tax</option>
                @foreach($taxes as $tax)
                <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                @endforeach
                {{-- <option name="tax" value="0%">0%</option>
                <option name="tax" value="2%">2%</option>
                <option name="tax" value="15%">15%</option> --}}
            </select>
        </div>
        {{-- <label for="#" class="col-lg-2 col-form-label">Purchase Quantity:</label>
        <div class="col-lg-4">
            <input type="text" class="form-control"  name="purchase_quantity" required>
        </div> --}}

    </div>
    <div class="form-group row">

        <label for="" class="col-sm-2 mt-2">Default Expense Account:</label>
        <div class="col">
            <select name="default_income_account" class="form-control" id="">
                <option>Choose</option>
            </select>
        </div>
        <label for="" class="col-sm-2 mt-2">Default Income Account:</label>
        <div class="col">
            <select name="default_expense_account" class="form-control" id="">
                <option>Choose</option>
            </select>
        </div>

    </div>
    <div class="form-group row">
        <label for="#" class="col-sm-2 col-form-label">Inventory Type:</label>
        <div class="form-check mx-2 mt-2">
            <input class="form-check-input" type="radio" name="inventory_type" id="ar_paymentType_credit"
                value="inventory_item" checked="checked">
            <label class="form-check-label" for="ar_paymentType_credit">
                Inventory item
            </label>
        </div>
        <div class="form-check col-md-2 ml-3 mr-4 mt-2">
            <input class="form-check-input" type="radio" name="inventory_type" id="ar_paymentType_cash"
                value="non_inventory_item" >
            <label class="form-check-label" for="ar_paymentType_cash">
                Non-inventory item
            </label>
        </div>
        <label for="email" class="col ml-2 mt-2">Item Picture:</label>
        <div class="input-group mb-3 col-lg-4">
            <div class="custom-file">
                <!-- Add img -->
                <img src="{{asset('inventories/picture')}}" class="img-fluid" alt="">
                <input type="file" accept="image/*" class="custom-file-input" id="inputGroupFile03" name="picture" value="{{ $inventory->image }}">
                <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg">
            <label for="">Description:</label>
            <textarea id="" class="form-control" style="min-height: 2.5rem" name="description" required>{{$inventory->description}}</textarea>
        </div>
    </div>
    </div>
    
    <div class="modal-footer">
        <div class="form-check mr-3">
            <input class="form-check-input" id="c_is_active" type="checkbox" value="Notify" name="is_active">
            <label class="form-check-label" for="c_is_active">Notify me when Quantity below</label>
        </div>
        <a type="button" href="/inventory" class="btn btn-secondary">Back</a>
        <button type="submit" class="btn btn-primary">Edit Item</button>
</form>
     
@endsection