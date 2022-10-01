@extends('template.index')

@push('styles')
<style>
    .table-item-content { 
        /** Equivalent to pt-3 */
        padding-top:1rem!important;
    }

    #thead-actions {
        /** Fixed width, increase if adding addt. buttons **/
        width:120px;
    }
</style>
@endpush


@section('content')

{{-- Button Group Navigation --}}
{{-- <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-select-period">
        <span class="icon text-white-50">
            <i class="fas fa-pen"></i>
        </span>
        <span class="text">New</span>
    </button>   
</div> --}}

<a href="{{ url('/hr/payrolls') }}" class="btn btn-primary mb-3">
    <span class="icon text-white-50">
        <i class="fas fa-arrow-left"></i>
    </span>
    <span class="text">Back</span>
</a>

<button type="button" class="btn btn-danger btn-icon mb-3" data-toggle="modal" data-target="#DeleteModal"
    @if($payroll_period->is_paid) disabled @endif>
    <span class="icon text-white-50">
        <i class="fas fa-trash"></i>
    </span>
    <span class="text">Delete Payroll</span>
</button>

{{-- Page Content --}}
<div class="card">
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
    <div class="card-body">
        <table class="table table-borderless table-sm">
            <tr>
                <td style="width:200px">Period Number</td>
                <td><strong>
                    @if($payroll_period->period->period_number < 10) 
                        {{ '0' . $payroll_period->period->period_number }} 
                    @else
                        {{ $payroll_period->period->period_number }}
                    @endif
                </strong></td>
            </tr>
            <tr>
                <td>Date From</td>
                <td><strong>{{ $payroll_period->period->date_from }}</strong></td>
            </tr>
            <tr>
                <td>Date To</td>
                <td><strong>{{ $payroll_period->period->date_to }}</strong></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    @if(!$payroll_period->period->is_paid)
                        <span class="badge badge-warning">Unpaid</span>
                    @else
                        <span class="badge badge-success">Paid</span>
                    @endif    
                </td>
            </tr>
        </table>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                <thead>
                    <th>ID</th>
                    <th>Employee Name</th>
                    <th>Basic Salary</th>
                    <th>Additions</th>
                    <th>Deductions</th>
                    <th>Overtime</th>
                    <th>Loan</th>
                    <th>Tax</th>
                    <th>Pension 7%</th>
                    <th>Pension 11%</th>
                    <th>Net Pay</th>
                </thead>
                <tbody>
                    @foreach($payrolls as $payroll)
                        <tr>
                            <td class="table-item-content">{{ $payroll->employee_id }}</td>
                            <td class="table-item-content">{{ $payroll->first_name }}</td>
                            <td class="table-item-content text-right">{{ number_format($payroll->total_salary, 2) }}</td>
                            <td class="table-item-content text-right">{{ number_format($payroll->total_addition, 2) }}</td>
                            <td class="table-item-content text-right">{{ number_format($payroll->total_deduction, 2) }}</td>
                            <td class="table-item-content text-right">{{ number_format($payroll->total_overtime, 2) }}</td>
                            <td class="table-item-content text-right">{{ number_format($payroll->total_loan, 2) }}</td>
                            <td class="table-item-content text-right">{{ number_format($payroll->total_tax, 2) }}</td>
                            <td class="table-item-content text-right">{{ number_format($payroll->total_pension_7, 2) }}</td>
                            <td class="table-item-content text-right">{{ number_format($payroll->total_pension_11, 2) }}</td>
                            <td class="table-item-content text-right"><strong>{{ number_format($payroll->net_pay, 2) }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Payroll</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(!$payroll_period->period->is_paid)
                    Are you sure you want to delete this payroll?
                @else
                    This payroll has already been paid. No further action is required.
                @endif 
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                @if(!$payroll_period->period->is_paid)
                    <form action="{{ route('payrolls.destroy', $payroll_period->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                @endif
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