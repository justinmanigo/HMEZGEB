@extends('template.index')

@section('content')

{{-- Button Group Navigation --}}
<div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-select-period">
        <span class="icon text-white-50">
            <i class="fas fa-pen"></i>
        </span>
        <span class="text">New</span>
    </button>
</div>

{{-- Page Content --}}
<div class="card">
    <div class="card-body">
        {{-- alert messge --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                <thead>
                    <th>Period</th>
                    <th>Date From</th>
                    <th>Date To</th>
                    <th>Number of Employees</th>
                    <th>Status</th>
                    {{-- <th>Period</th>
                    <th>Employee Name</th>
                    <th>Status</th>
                    <th>Basic Salary</th>
                    <th>Additions</th>
                    <th>Deductions</th>
                    <th>Overtime</th>
                    <th>Loan</th>
                    <th>Tax</th>
                    <th>Pension 7%</th>
                    <th>Pension 11%</th>
                    <th>Net Pay</th> --}}
                    <th id="thead-actions">Actions</th>
                </thead>
                <tbody>
                    @foreach($payroll_periods as $period)

                    <tr>
                        <td>
                            #
                            @if($period->period_number < 10)
                                {{ '0' . $period->period_number }}
                            @else
                                {{ $period->period_number }}
                            @endif
                        </td>
                        <td>{{ $period->date_from }}</td>
                        <td>{{ $period->date_to }}</td>
                        <td>{{ $period->employee_count }}</td>
                        <td>
                            @if(!$period->payroll_period_id)
                                <span class="badge badge-secondary">Ungenerated</span>
                            @elseif(!$period->is_paid)
                                <span class="badge badge-warning">Unpaid</span>
                            @else
                                <span class="badge badge-success">Paid</span>
                            @endif
                        </td>
                        {{-- <td class="table-item-content">{{$payroll->payrollPeriod->period->period_number}}</td>
                        <td class="table-item-content">{{$payroll->employee->first_name}}</td>
                        <td class="table-item-content"><span class="badge badge-secondary">{{$payroll->status}}</span></td>
                        <td class="table-item-content">{{$payroll->total_salary}} Birr</td>
                        <td class="table-item-content">{{$payroll->total_addition}} Birr</td>
                        <td class="table-item-content">{{$payroll->total_deduction}} Birr</td>
                        <td class="table-item-content">{{$payroll->total_overtime}} Birr</td>
                        <td class="table-item-content">{{$payroll->total_loan}} Birr</td>
                        <td class="table-item-content">{{$payroll->total_tax}} Birr</td>
                        <td class="table-item-content">{{$payroll->total_pension_7}} Birr</td>
                        <td class="table-item-content">{{$payroll->total_pension_11}} Birr</td>
                        <td class="table-item-content">{{$payroll->net_pay}} Birr</td> --}}
                        <td>
                            {{-- <a href="{{ route('payrolls.payrolls.show', $payroll->id) }}" role="button" class="btn btn-small btn-icon btn-primary" data-toggle="tooltip" data-placement="bottom" title="View">
                                <span class="icon text-white-50">
                                    <i class='fa fa-eye'></i>
                                </span>
                            </a> --}}
                            <a href="
                                @if(!$period->payroll_period_id)
                                    {{ 'javascript:void(0)' }}
                                @else
                                    {{ '/hr/payrolls/' . $period->payroll_period_id }}
                                @endif
                                " role="button" class="btn btn-small btn-icon btn-primary @if(!$period->payroll_period_id) disabled @endif" data-toggle="tooltip" data-placement="bottom" title="View">
                                <span class="icon text-white-50">
                                    <i class='fa fa-eye'></i>
                                </span>
                            </a>
                            {{-- <button type="button" class="btn btn-small btn-icon btn-danger" @if(!$period->payroll_period_id || $period->is_paid) disabled @endif>
                                <span class="icon text-white-50">
                                    <i class='fa fa-trash'></i>
                                </span>
                            </button> --}}
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Select Accounting Period Modal --}}
<div class="modal fade" id="modal-select-period" tabindex="-1" role="dialog" aria-labelledby="modal-select-period" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-select-period">Select Accounting Period</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/hr/payrolls/') }}" method="post">
                    @csrf
                    {{-- <div class="form-group row">
                        <label for="employee" class="col-12 col-md-3">Employee</label>
                        <div class="col-12 col-lg-6">
                            <select class="form-control select2" id="employee" name="employee">
                                <option>Graeme Xyber Pastoril</option>
                                <option>Justin Manigo</option>
                                <option>Lester Fong</option>
                            </select>
                        </div>
                    </div> --}}
                    <div class="form-group row  mb-3">
                        <label for="month" class="col-12 col-md-4">Accounting Period</label>
                        <div class="col-12 col-lg-8">
                            <select class="form-control" id="period" name="period">
                                @foreach($accounting_periods_with_no_payroll as $period)
                                    <option value="{{$period->id}}">
                                        #
                                        @if($period->period_number < 10)
                                            {{ '0' . $period->period_number }}
                                        @else
                                            {{ $period->period_number }}
                                        @endif
                                        |
                                        {{ $period->date_from }} to {{ $period->date_to }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row justify-content-end">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary mx-2">Generate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- TODO Later when more info arrives: --}}
{{-- Salary Details Modal (Eye Icon)--}}

{{-- Payment Modal (Money Icon)--}}
{{-- <div class="modal fade" id="modal-payment" tabindex="-1" role="dialog" aria-labelledby="modal-payment-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-payment-label">Payment for February 2022</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="form-overtime" method="POST">
                    <div class="form-group row">
                        <label for="p_basic_salary" class="col-lg-4 col-form-label">Basic Salary</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control text-right" id="p_basic_salary" name="basic_salary" placeholder="0.00" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="p_total_additions" class="col-lg-4 col-form-label">Total Additions</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control text-right" id="p_total_additions" name="total_additions" placeholder="0.00" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="p_total_deductions" class="col-lg-4 col-form-label">Total Deductions</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control text-right" id="p_total_deductions" name="total_deductions" placeholder="0.00" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="p_gross_salary" class="col-lg-4 col-form-label">Gross Salary</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control text-right" id="p_gross_salary" name="gross_salary" placeholder="0.00" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="p_payment_method" class="col-lg-4 col-form-label">Payment Method</label>
                        <div class="col-lg-8">
                            <select class="form-control" id="p_payment_method" name="payment_method" required>
                                <option value="">-Select Payment Method-</option>
                                <option value="offline">Offline</option>
                                <option value="online">Online</option>
                                <option value="paypal">Paypal</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="p_notes" class="col-lg-4 col-form-label">Notes</label>
                        <div class="col-lg-8">
                            <textarea class="form-control" id="p_notes" name="notes"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-payment">Save Payment</button>
            </div>
        </div>
    </div>
</div> --}}


<script>
    // $(document).ready(function () {
    // $('#dataTables').DataTable();
    // $('.dataTables_filter').addClass('pull-right');
    // });
</script>
@endsection
