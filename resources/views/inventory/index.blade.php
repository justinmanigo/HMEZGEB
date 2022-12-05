@extends('template.index')

@push('styles')
<style>
    .w-15 {
        width: 15%;
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
                                            <i class="fas fa-pen"></i>
                                        </span>
                                    </a>
                                    <!-- delete -->
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-modal" onclick="deleteModal({{$inventory->id}})">
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

<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-delete-label">Delete Inventory Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">Are you sure to delete this record?</div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
                <form id="delete-frm" class="" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- Import --}}
<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="modal-import-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-import-label">Import Inventories</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-import" action="{{route('inventory.import')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row container">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" name="file" required>
                            <label class="custom-file-label" for="file">Choose file</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-import">Import Customers</button>
            </div>
        </div>
    </div>
</div>

 {{-- Export --}}
<div class="modal fade" id="modal-export" tabindex="-1" role="dialog" aria-labelledby="modal-export-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-export-label">Export Customers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-export" action="{{route('inventory.export')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="e_file_type" class="col-sm-4 col-form-label">File Type<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" id="e_file_type" name="file_type" required>
                                <option value="csv">CSV</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-export">Export Inventories</button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
    $('#dataTables').DataTable();
    $('.dataTables_filter').addClass('pull-right');
});
    // delete
    function deleteModal(id){
            $('#delete-frm').attr('action', '{{ route("inventory.inventory.destroy", ":id") }}'.replace(':id', id))
        }

    // add the file name only in file input field
    $('.custom-file-input').on('change', function() {
    var fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
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
