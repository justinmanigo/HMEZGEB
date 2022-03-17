@extends('template.index')

@section('content')

<div>
    
    <div class="d-flex justify-content-between align-items-end">
        {{-- Tab Navigation --}}
        <ul class="nav nav-tabs d-flex" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="receipt-tab" data-toggle="tab" href=".receipt" role="tab" aria-controls="receipt" aria-selected="true">Payroll Rules</a>
            </li>
         </ul>
       
    </div>

    
        {{-- Tab Contents --}}
    <div class="card">
        <div class="card-body tab-content">
            <!--Receipt content--->
            <div class="tab-pane fade show active receipt">                
               
                <div class="container col-12">
                        <form>
                    <h4>Income Tax Rules</h4>
                        <div class="row">
                        <div class="form-group col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="incometax" id="governmentrule_incometax" value="option1" checked>
                                        <label class="form-check-label" for="governmentrule_incometax">
                                            Government Rule (Default)
                                        </label>
                                    </div>
                                <textarea class="form-control " readonly  id="exampleFormControlTextarea1" rows="6">IF([Taxable income]>10900,([Taxable income)*35%)-1500,&#10;IF( [Taxable income]>7800,([Taxable income)*30%)-955,&#10;IF( [Taxable income]>5250,([Taxable income) *25%)-565,&#10;IF( [Taxable income]>3200,([Taxable income] *20%)-302.5,&#10;IF( [Taxable income]>1650,([Taxable income) *15%)-142.5,&#10;IF( [Taxable income]>600,([Taxable income)* 10%)-60,0))))))</textarea>    
                            </div>

                            <div class="form-group  col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="incometax" id="user_incometax" value="option1">
                                        <label class="form-check-label" for="user_incometax">
                                            User (Editable)
                                        </label>
                                    </div>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="6"></textarea>    
                            </div>
                        </div>

                        <h4>Overtime Rules</h4>
                        <div class="row">
                            
                            <div class="form-group col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="otrules" id="governmentrule_otrules" value="option1" checked>
                                        <label class="form-check-label" for="governmentrule_otrules">
                                        Government Rule (Default)
                                        </label>
                                    </div>
                                    <table class="table">
                                    <tbody>
                                            <tr>
                                                <th scope="row">Hour Rate Circulation from the Basic Salary</th>
                                                <td>[Basic Salary]/26/8</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Day Rate before 6pm (18:00)</th>
                                                <td>1.25</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Night Rate after 6pm (18:00)</th>
                                                <td>1.50</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Holiday/Weekend Rate</th>
                                                <td>2.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                            </div>
                            <div class="form-group col-md-6">
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
                            </div>
                        </div>
                    </div>
                    <div class="form-group float-right">
                            <button type="submit" class="btn btn-primary ">Save</button>
                            <button type="submit" class="btn btn-danger ">Cancel</button>
                        <div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#dataTables').DataTable();
        $('#dataTables2').DataTable();
        $('.dataTables_filter').addClass('pull-right');
    });
</script>
@endsection
