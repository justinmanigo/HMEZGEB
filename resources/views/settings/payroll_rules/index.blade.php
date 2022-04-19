@extends('template.index')

@section('content')

<div>

    <div class="d-flex justify-content-between align-items-end">
        {{-- Tab Navigation --}}
        <ul class="nav nav-tabs d-flex" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="receipt-tab" data-toggle="tab" href=".receipt" role="tab"
                    aria-controls="receipt" aria-selected="true">Payroll Rules</a>
            </li>
        </ul>

    </div>


    {{-- Tab Contents --}}
    <div class="card">
        <div class="card-body tab-content">
            <!--Receipt content--->
            <div class="tab-pane fade show active receipt">

                <div class="container col-12">

                    <div class="d-flex justify-content-between mb-3">
                        <h4>Income Tax Rules</h4>
                        <button type="button" class="btn btn-primary" id="it_default">Government Rule</button>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <form action="{{route('settings.store_income_tax') }}" method="POST">
                            @csrf

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Condition</th>
                                        <th scope="col">Income</th>
                                        <th scope="col">Taxable Income </th>
                                        <th scope="col">Rate (%)</th>
                                        <th scope="col">Deduction</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="pr_entries">
                                    {{--  <tr>
                                            <td scope="row">IF Taxable Income > 10900</td>
                                            <td scope="row">Taxable Income </td>
                                            <td scope="row">35% </td>
                                            <td scope="row">1500</td>
                                            <th scope="row">
                                                <button type="button" class="btn btn-icon btn-danger"
                                                    data-toggle="tooltip" data-placement="bottom" title="Edit">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                </button>
                                            </th>
                                        </tr>--}}

                                </tbody>
                            </table>
                            <div class="form-group float-right my-3">
                                <a href="/setting_payrollrules" type="submit" class="btn btn-danger ">Cancel</a>
                                <button type="submit" class="btn btn-primary ">Save</button>
                                <div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <h4>Overtime Rules</h4>
                    <button type="button" class="btn btn-primary" id="ot_default">Government Rule</button>
                </div>
                <div class="row">

                    <div class="form-group col-md-12">
                        <form action="{{route('settings.store_overtime') }}" method="POST">
                            @csrf
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="row">Hour Rate Circulation from the Basic Salary</th>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <p class="w-25 mt-1">[Basic Salary] </p>/
                                                <input type="text" id="working_days" class="form-control w-25"
                                                    name="working_days" placeholder="Working days" required> /
                                                <input type="text" id="working_hours" class="form-control w-25"
                                                    name="working_hours" placeholder="Working hours" required>
                                            </div>


                                        </td>

                                    </tr>
                                    <tr>
                                        <th scope="row">Day Rate before 6pm (18:00)</th>
                                        <td> <input type="text" id="day_rate" class="form-control" name="day_rate"
                                                required placeholder="0.00">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Night Rate after 6pm (18:00)</th>
                                        <td>
                                            <input type="text" id="night_rate" class="form-control" name="night_rate"
                                                required placeholder="0.00">

                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Holiday/Weekend Rate</th>
                                        <td>
                                            <input type="text" id="holiday_weekend_rate" class="form-control"
                                                name="holiday_weekend_rate" required="" placeholder="0.00">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                    </div>
                    {{-- <div class="form-group col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="otrules" id="user_otrules" value="option1" >
                                        <label class="form-check-label" for="user_otrules">
                                        User (Editable)
                                        </label>
                                    </div>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Hour Rate Circulation from the Basic Salary</th>
                                                <td contenteditable="true">[Basic Salary]/_/_</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Day Rate before 6pm (18:00)</th>
                                                <td contenteditable="true"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Night Rate after 6pm (18:00)</th>
                                                <td contenteditable="true"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Holiday/Weekend Rate</th>
                                                <td contenteditable="true"></td>
                                            </tr>
                                        </tbody>
                                    </table>   
                            </div>--}}
                </div>
            </div>
            <div class="form-group float-right">
                <a href="/setting_payrollrules" type="submit" class="btn btn-danger ">Cancel</a>
                <button type="submit" class="btn btn-primary ">Save</button>
                <div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#dataTables').DataTable();
        $('#dataTables2').DataTable();
        $('.dataTables_filter').addClass('pull-right');
    });
    </script>
    <script src="/js/settings/payroll_rules.js"></script>
    @endsection