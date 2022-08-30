@extends('template.index')

@section('content')

<div>

    <div class="d-flex justify-content-between align-items-end">
        {{-- Tab Navigation --}}
        <ul class="nav nav-tabs d-flex" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="aged_payables-tab" data-toggle="tab" href=".aged_payables" role="tab"
                    aria-controls="aged_payables" aria-selected="true">Aged Payables</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="cash_disbursements_journal-tab" data-toggle="tab"
                    href=".cash_disbursements_journal" role="tab" aria-controls="cash_disbursements_journal" aria-selected="false">Cash Disbursements Journal</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="vendor_ledgers-tab" data-toggle="tab" href=".vendor_ledgers" role="tab"
                    aria-controls="vendor_ledgers" aria-selected="false">Vendor Ledgers</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="cash_requirements-tab" data-toggle="tab" href=".cash_requirements" role="tab"
                    aria-controls="cash_requirements" aria-selected="false">Cash Requirements</a>
            </li>

        </ul>
    </div>

    {{-- Tab Contents --}}
    <div class="card">
        <div class="card-body tab-content">

            <div class="tab-pane fade show active aged_payables">
                <form target="_blank" action="{{route('reports.aged_payables.pdf')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="date_from">Date From</label>
                                <input type="date" class="form-control" id="date_from" name="date_from"
                                    value="{{ now()->subDays(30)->format('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="date_to">Date To</label>
                                <input type="date" class="form-control" id="date_to" name="date_to"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select class="form-control form-control-select" id="type" name="type" required>
                                    <option value="" hidden selected>Select Report Type ...</option>
                                    <option value="summary">Summary</option>
                                    <option value="detailed">Detailed</option>
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

            <div class="tab-pane fade cash_disbursements_journal">
                <form target="_blank" action="{{route('reports.cash_disbursements_journal.pdf')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="date_from">Date From</label>
                                <input type="date" class="form-control" id="date_from" name="date_from"
                                    value="{{ now()->subDays(30)->format('Y-m-d') }}">
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

            <div class="tab-pane fade vendor_ledgers">
                <form target="_blank" action="{{route('reports.vendor_ledgers.pdf')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="date_from">Date From</label>
                                <input type="date" class="form-control" id="date_from" name="date_from"
                                    value="{{ now()->subDays(30)->format('Y-m-d') }}">
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
            
            <div class="tab-pane fade cash_requirements">
                <form target="_blank" action="{{route('reports.cash_requirements.pdf')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="date_from">Date From</label>
                                <input type="date" class="form-control" id="date_from" name="date_from"
                                    value="{{ now()->subDays(30)->format('Y-m-d') }}">
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