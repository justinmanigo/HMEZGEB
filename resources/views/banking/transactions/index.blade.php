@extends('template.index')

@section('content')

<div class="row">

    {{-- Main Content Section --}}
    <div class="col-xl-10 col-lg-9 col-12">
        {{-- Button Group Navigation --}}
        <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="icon text-white-50">
                        <i class="fas fa-download"></i>
                    </span>
                    <span class="text">Download</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-receipt">Excel</a>
                    <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-advance-revenue">PDF</a>
                </div>
        </div>

        {{-- Page Content --}}
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                        <thead>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Bank Account</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Amount</th>
                        </thead>
                        <tbody>
                                {{-- get all transactions	 	 	  --}}
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $transaction->chartOfAccount->account_name }}</td>
                                    <td>{{ $transaction->type }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>{{ $transaction->amount }}</td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar Content Section --}}
    <div class="col-xl-2 col-lg-3 d-none d-lg-block">
        <h4 class="">Account Receivable</h4>
        {{-- Account Receivable Active --}}
        <div class="mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Birr 40,000</div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                2 Active</div>
                        </div>
                        <div class="col-auto">
                            {{-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Account Receivable Overdue --}}
        <div class="mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Birr 215,000</div>
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                5 Over Due</div>
                        </div>
                        <div class="col-auto">
                            {{-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#dataTables').DataTable();
        $('.dataTables_filter').addClass('pull-right');
    });
</script>
@endsection
