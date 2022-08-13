@extends('template.index')

@section('content')

<div class="container">
    <div class="d-sm-flex align-items-start justify-content-between mb-2">
        <h1>{{$credit_receipt->receiptReference->customer->name}}</h1>
    </div>
    <div class="container card shadow px-4 py-3">
        <form action="">
            <div class="row mt-2">
                <div class="col">
                    <label for="#">Customer Name</label>
                    <input type="text" class="form-control" value="{{$credit_receipt->receiptReference->customer->name}}" disabled>
                </div>
                <div class="col form-group">
                        <label for="cars">Bill Status:</label>

                        <select id="cars" class="form-control">
                        <option value="#" selected disabled hidden>Choose</option>
                        <option value="#">Paid Bill</option>
                        <option value="#">Partially Paid Bill</option>
                        <option value="#">Unpaid Bill</option>
                        </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <label for="#">Bill number</label>
                    <input type="number" value="09123851225" class="form-control">
                </div>
                <div class="col">
                    <label for="#">Date</label>
                    <input type="date" value="Cebu" class="form-control">
                </div>
                <div class="col">
                    <label for="#">Due date</label>
                    <input type="date" value="Philippines" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <label for="#">Item table</label>
                    <input type="text" class="form-control" value="">
                </div>
                <div class="col-3">
                    <label for="#">Order Number</label>
                    <input type="number" class="form-control" value="00459318">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <label for="#">Note</label>
                    <textarea style="min-height: 2.5rem " class="form-control" value="092173640"></textarea>
                </div>
            </div>
            <div class="row ">
                <div class="col">
                    <label for="#">Bill type</label>
                    <select class="form-control">
                        <option value="#" selected disabled hidden>Choose</option>
                        <option value="#">Cash Bill</option>
                        <option value="#">Credit Paid Bill</option>
                    <select>
                </div>
                <div class="col">
                    <label for="email">Attachment:</label>
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile03">
                            <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="form-group col">
                    <label for="cars">Cash from:</label>

                    <select id="cars" class="form-control">
                    <option value="#">Cash on hand</option>
                    <option value="#">sample1</option>
                    <option value="#">Sample2</option>
                    </select>
                </div>
            </div>
            <div class="row mt-3 d-flex justify-content-between">
                    <div>
                        <a href="{{route('receipts.receipts.index')}}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i>
                            Back
                        </a>
                    </div>
                    <div>
                        <button class="btn btn-secondary mx-1">Edit</button>
                        <button class="btn btn-danger mr-3">Delete</button>
                    </div>
            </div>
        </form>
    </div>
</div>

@endsection