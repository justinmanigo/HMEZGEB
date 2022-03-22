@extends('template.index')

@push('styles')
<style>
   .w-15 { 
       width:15%;
    }
</style>
@endpush

@section('content')

<main>
    <div class="d-flex justify-content-between align-items-start">
        <!---buttons--->
        <div class="d-flex">
            <!--add item btn--->
            <button type="button" class="btn btn-info mx-1" data-toggle="modal" data-target="#modal-new-item">New Item</button>
            <div class="modal fade" id="modal-new-item" tabindex="-1" role="dialog" aria-labelledby="modal-newItem-label" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-receipt-label">New Inventory Item</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @include('inventory.forms.newItem')
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-info mx-1" data-toggle="modal" data-target=".bd-example-modal-lg">Import</button>
            <button type="button" class="btn btn-info mx-1" data-toggle="modal" data-target=".bd-example-modal-lg">Export</button>
            <button type="button" class="btn btn-info mx-1" data-toggle="modal" data-target=".bd-example-modal-lg">Download Excel File</button>
        </div>
        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Inventory Value</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Birr 215,000</div>
                        </div>
                        <div class="col-auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                    <thead>
                        <th class="w-15"></th>
                        <th class="w-15">Item Code</th>
                        <th>Item Name</th>
                        <th>Purchase Price</th>
                        <th>Purchase Quantity</th>
                        <th>Sale Price</th>
                        <th>Sold Quantity</th>
                        <th>Inventory Value</th>
                    </thead>
                    <tbody>
                        @foreach($inventories as $inventory)
           
                        <tr>
                            <td class=" d-flex justify-content-center">
                                <img src="{{ url('storage/inventories/' .$inventory->picture)}}" class="w-100 img-responsive" style="min-width:100px">
                            </td>
                            <td>{{ $inventory->item_code }}</td>
                            <td class="table-item-content">{{ $inventory->item_name }}</td>
                            <td class="table-item-content">Birr {{  $inventory->purchase_price }}</td>
                            <td class="table-item-content">{{  $inventory->purchase_quantity }}</td>        
                            <td class="table-item-content">Birr {{ $inventory->sale_price }}</td>
                            <td class="table-item-content">{{ $inventory->sold_quantity }}</td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</main>

<script>
    $(document).ready(function () {
    $('#dataTables').DataTable();
    $('.dataTables_filter').addClass('pull-right');
    });
</script>
@endsection