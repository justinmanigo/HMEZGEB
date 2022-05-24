@extends('template.index')

@section('content')

<div>

    <div class="d-flex justify-content-between align-items-end">
        {{-- Tab Navigation --}}
        <ul class="nav nav-tabs d-flex" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="balance_sheet-tab" data-toggle="tab" href=".balance_sheet" role="tab"
                    aria-controls="balance_sheet" aria-selected="true">Balance Sheet</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="balance_sheet_zero_account-tab" data-toggle="tab" href=".balance_sheet_zero_account" role="tab"
                    aria-controls="balance_sheet_zero_account" aria-selected="true">Balance Sheet With Zero Account</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="income_statement_single-tab" data-toggle="tab" href=".income_statement_single" role="tab"
                    aria-controls="income_statement_single" aria-selected="false">Income Statement Single Step</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="income_statement_multiple-tab" data-toggle="tab" href=".income_statement_multiple" role="tab"
                    aria-controls="income_statement_multiple" aria-selected="false">Income Statement Multiple Step</a>
            </li>
        </ul>
    </div>

    {{-- Tab Contents --}}
    <div class="card">
        <div class="card-body tab-content">

            <div class="tab-pane fade show balance_sheet_zero_account">
                <form action="{{route('reports.balance_sheet_zero_account.pdf')}}" method="POST">
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
                            <button class="btn btn-primary" id="generate_report">Generate Report</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade show active balance_sheet">
                <form action="{{route('reports.balance_sheet.pdf')}}" method="POST">
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
                            <button class="btn btn-primary" id="generate_report">Generate Report</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade show income_statement_single">
                <form action="{{route('reports.income_statement_single.pdf')}}" method="POST">
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
                            <button class="btn btn-primary" id="generate_report">Generate Report</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade show income_statement_multiple">
                <form action="{{route('reports.income_statement_multiple.pdf')}}" method="POST">
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
                            <button class="btn btn-primary" id="generate_report">Generate Report</button>
                        </div>
                    </div>
                </form>
            </div>



        </div>
    </div>
</div>

@endsection