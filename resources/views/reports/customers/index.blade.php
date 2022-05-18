@extends('template.index')

@section('content')

<div>

    <div class="d-flex justify-content-between align-items-end">
        {{-- Tab Navigation --}}
        <ul class="nav nav-tabs d-flex" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="aged_receivable-tab" data-toggle="tab" href=".aged_receivable" role="tab"
                    aria-controls="aged_receivable" aria-selected="true">Aged Receivable</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="cash_receipts_journal-tab" data-toggle="tab" href=".cash_receipts_journal"
                    role="tab" aria-controls="cash_receipts_journal
                cash_receipts_journal" aria-selected="false">Cash Receipt Journal</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="customer_ledgers-tab" data-toggle="tab" href=".customer_ledgers" role="tab"
                    aria-controls="customer_ledgers" aria-selected="false">Customer Ledgers</a>
            </li>

        </ul>
    </div>

    {{-- Tab Contents --}}
    <div class="card">
        <div class="card-body tab-content">
            <!--Bill Payment content--->
            <div class="tab-pane fade show active aged_receivable">

                <form action="{{route('reports.aged_receivable.pdf')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="date_from">Date From</label>
                                <input type="date" class="form-control" id="date_from" name="date_from"
                                    value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="date_to">Date To</label>
                                <input type="date" class="form-control" id="date_to" name="date_to"
                                    value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6 mt-3">
                            <button type="submit" class="btn btn-primary" id="generate_report">Generate Report</button>
                        </div>
                    </div>
                </form>

            </div>

            <!--Other Payment content--->
            <div class="tab-pane fade cash_receipts_journal">
                
                <form action="{{route('reports.cash_receipts_journal.pdf')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_from">Date From</label>
                                <input type="date" class="form-control" id="date_from" name="date_from"
                                    value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_to">Date To</label>
                                <input type="date" class="form-control" id="date_to" name="date_to"
                                    value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <button class="btn btn-primary" id="generate_report">Generate Report</button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="tab-pane fade customer_ledgers">
                
                <form action="{{route('reports.customer_ledgers.pdf')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_from">Date From</label>
                                <input type="date" class="form-control" id="date_from" name="date_from"
                                    value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_to">Date To</label>
                                <input type="date" class="form-control" id="date_to" name="date_to"
                                    value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <button class="btn btn-primary" id="generate_report">Generate Report</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection