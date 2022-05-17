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
                <a class="nav-link" id="income_statement-tab" data-toggle="tab" href=".income_statement" role="tab"
                    aria-controls="income_statement" aria-selected="false">Income Statement</a>
            </li>
        </ul>
    </div>

    {{-- Tab Contents --}}
    <div class="card">
        <div class="card-body tab-content">

            <div class="tab-pane fade show active balance_sheet">
                <form action="" method="POST">
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
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="type">Balance Sheet Account Type</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="all">All</option>
                                    <option value="zero_accounts">Zero Accounts</option>
                                </select>
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

            <div class="tab-pane fade show income_statement">
                <form action="" method="POST">
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
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="step">Income Statement Step</label>
                                <select class="form-control" id="step" name="step">
                                    <option value="single">Single Step</option>
                                    <option value="multiple">Multiple Step</option>
                                </select>
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