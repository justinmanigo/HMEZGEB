@extends('template.index')

@section('content')

<div>
    
    <div class="d-flex justify-content-between align-items-end">
        {{-- Tab Navigation --}}
        <ul class="nav nav-tabs d-flex" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="receipt-tab" data-toggle="tab" href=".receipt" role="tab" aria-controls="receipt" aria-selected="true">Inventory Value Calculation</a>
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
                    <div class="form-check my-2">
                        <input class="form-check-input" type="radio" name="inventory" id="inventory1" value="Average" checked>
                        <label class="form-check-label h5" for="inventory1">
                            Average
                        </label>
                        </div>
                        <div class="form-check my-2">
                        <input class="form-check-input" type="radio" name="inventory" id="inventory2" value="LIFO">
                        <label class="form-check-label h5" for="inventory2">
                            FIFO
                        </label>
                        </div>
                        <div class="form-check my-2">
                        <input class="form-check-input" type="radio" name="inventory" id="inventory3" value="FIFO" >
                        <label class="form-check-label h5" for="inventory3">
                            LIFO
                        </label>
                    </div>
                    <div class="form-group mt-4">
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
