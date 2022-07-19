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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
    // Commented AJAX can be used to fetch select2 entries from server.
    // Guide: https://www.nicesnippets.com/blog/laravel-select2-ajax-autocomplete-example
    $('#employee').select2({
        placeholder: 'Select Employee',
        // ajax: {
        //     url: '/select2-autocomplete-ajax',
        //     dataType: 'json',
        //     delay: 250,
        //     processResults: function (data) {
        //     return {
        //         results:  $.map(data, function (item) {
        //             return {
        //                 text: item.name,
        //                 id: item.id
        //             }
        //         })
        //     };
        //     },
        //     cache: true
        // }
    });

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
</script>
@endpush

@section('content')

{{-- <div class="card col-12 col-lg-6 mb-3">
    <div class="card-body">
        <p>Filter</p>
        <hr>
        <form>
            <div class="form-group row">
                <label for="employee" class="col-12 col-md-3">Employee</label>
                <div class="col-12 col-lg-6">
                    <select class="form-control select2" id="employee" name="employee">
                        <option>Graeme Xyber Pastoril</option>
                        <option>Justin Manigo</option>
                        <option>Lester Fong</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="month" class="col-12 col-md-3">Select Month</label>
                <div class="col-12 col-lg-6">
                    <input type="month" class="form-control "id="month" name="month">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12 col-md-3"></div>
                <div class="col-8 col-lg-3">
                    <button type="submit" class="form-control btn btn-primary">Search</button>
                </div>
                <div class="col-4 col-lg-3">
                    <button type="button" class="form-control btn btn-secondary">Reset</button>
                </div>
            </div>
        </form>
    </div>
</div> --}}

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
                    {{-- <th id="thead-actions">Actions</th>     --}}
                    <th>Employee Name</th>
                    <th>Status</th>
                    <th>Basic Salary</th>
                    <th>Additions</th>
                    <th>Deductions</th>
                    <th>Overtime</th>
                    <th>Loan</th>
                    <th>Tax</th>
                    <th>Pension</th>
                </thead>
                <tbody>
                    @foreach($payrolls as $payroll)
                    <tr>
                        {{-- <td>
                            <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="tooltip" data-placement="bottom" title="View">
                                <span class="icon text-white-50">
                                    <i class='fa fa-eye text-white'></i>
                                </span>
                            </button> --}}
                            {{-- <button type="button" class="btn btn-small btn-icon btn-danger" data-toggle="modal" data-target="#modal-payment">
                                <span class="icon text-white-50">
                                    <i class='fa fa-money text-white'></i>
                                </span>
                            </button>
                        </td> --}}
                        <td class="table-item-content">{{$payroll->employee->first_name}}</td>
                        <td class="table-item-content"><span class="badge badge-secondary">{{$payroll->status}}</span></td>
                        <td class="table-item-content">{{$payroll->total_salary}} Birr</td>
                        <td class="table-item-content">{{$payroll->total_addition}} Birr</td>
                        <td class="table-item-content">{{$payroll->total_deduction}} Birr</td>
                        <td class="table-item-content">{{$payroll->total_overtime}} Birr</td>
                        <td class="table-item-content">{{$payroll->total_loan}} Birr</td>
                        <td class="table-item-content">{{$payroll->total_tax}} Birr</td>
                        <td class="table-item-content">{{$payroll->total_pension}} Birr</td>
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
                <form action="{{route('payrolls.payrolls.store')}}" method="post">
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
                                <option value="1">Period 1</option>
                                <option value="2">Period 2</option>
                                <option value="3">Period 3</option>
                                <option value="4">Period 4</option>
                                <option value="5">Period 5</option>
                                <option value="6">Period 6</option>
                                <option value="7">Period 7</option>
                                <option value="8">Period 8</option>
                                <option value="9">Period 9</option>
                                <option value="10">Period 10</option>
                                <option value="11">Period 11</option>
                                <option value="12">Period 12</option>
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
    $(document).ready(function () {
    $('#dataTables').DataTable();
    $('.dataTables_filter').addClass('pull-right');
    });
</script>
@endsection