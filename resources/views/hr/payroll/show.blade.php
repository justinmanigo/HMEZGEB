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

<a href="{{ route('payrolls.payrolls.index') }}" class="btn btn-primary mb-3">
    <span class="icon text-white-50">
        <i class="fas fa-arrow-left"></i>
    </span>
    <span class="text">Back</span>
</a>

<a href="" class="btn btn-danger btn-icon mb-3">
    <span class="icon text-white-50">
        <i class="fas fa-trash"></i>
    </span>
    <span class="text">Delete Payroll</span>
</a>
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
                    <th>#</th>
                    <th>Source</th>
                    <th>Amount</th>              
                </thead>
                <tbody>
                    @foreach($payroll_items as $payroll)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $payroll->type }}</td>
                        <td>{{ $payroll->amount }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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