@extends('template.index')

@push('styles')
<style>
    .w-15 {
        width: 15%;
    }

    .inputPrice::-webkit-inner-spin-button,
    .inputTax::-webkit-inner-spin-button,
    .inputPrice::-webkit-outer-spin-button,
    .inputTax::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
@endpush

@section('content')

<div class="row">
    <div class="col-xl-10 col-lg-9 col-12">
        {{-- Button Group Navigation --}}
        <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-new-item">
                <span class="icon text-white-50">
                    <i class="fas fa-pen"></i>
                </span>
                <span class="text">New</span>
            </button>
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-import">
                <span class="icon text-white-50">
                    <i class="fas fa-file-import"></i>
                </span>
                <span class="text">Import</span>
            </button>
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-export">
                <span class="icon text-white-50">
                    <i class="fas fa-download"></i>
                </span>
                <span class="text">Export</span>
            </button>
        </div>

        <div class="card">
            <div class="card-body">
                @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @elseif(session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session()->get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                        <thead>
                            <th class="w-15">Item Code</th>
                            <th>Item Name</th>
                            <th>Purchase Price</th>
                            <th>Sale Price</th>
                            <th>Quantity</th>
                            <th>Inventory Value</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            @foreach($inventories as $inventory)
                            <tr>
                                <td class="table-item-content">{{ $inventory->item_code }}</td>
                                <td class="table-item-content">{{ $inventory->item_name }}</td>
                                <td class="table-item-content">Birr {{ $inventory->purchase_price }}</td>
                                <td class="table-item-content">Birr {{ $inventory->sale_price }}</td>
                                <td class="table-item-content">
                                    @if($inventory->inventory_type != 'non_inventory_item')
                                    {{ $inventory->quantity }}
                                    @endif
                                </td>
                                <td class="table-item-content">
                                    @if($inventory->inventory_type != 'non_inventory_item')
                                    {{ $inventory->inventoryValue }}
                                    @endif
                                </td>
                                <td>
                                    <!-- edit -->
                                    <a href="{{ url('inventory/'.$inventory->id.'/edit') }}"
                                        class="btn btn-sm btn-primary">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                    </a>
                                    <!-- delete -->
                                    <button type="button" class="btn btn-sm btn-danger" disabled>
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </button>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-2 col-lg-3 d-none d-lg-block">
        <div class="card border-left-success shadow py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Inventory Value</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Birr {{ $inventoryValue }}</div>
                    </div>
                    <div class="col-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modals --}}

{{-- New inventory modal --}}
<div class="modal fade" id="modal-new-item" tabindex="-1" role="dialog" aria-labelledby="modal-newItem-label"
    aria-hidden="true">
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

<script>
    $(document).ready(function() {
    $('#dataTables').DataTable();
    $('.dataTables_filter').addClass('pull-right');
});

// This function toggles when the inventory_item radio button is changed
$(document).ready(function() {
    $('input[type=radio][name=inventory_type]').change(function() {
        if (this.value == 'inventory_item') {
            $('input[name=critical_quantity]').removeAttr('disabled');
            $('input[name=notify_critical_quantity]').removeAttr('disabled');
        } else {
            $('input[name=critical_quantity]').attr('disabled', true);
            $('input[name=notify_critical_quantity]').attr('disabled', true);
        }
    });
});
</script>
@endsection