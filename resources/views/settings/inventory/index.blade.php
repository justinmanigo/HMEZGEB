@extends('template.index')

@section('content')

{{-- Tab Contents --}}
<div class="card">
    <div class="card-body">                
        <div class="container col-12">
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <form method="POST" action="{{ url('/settings/inventory') }}">
                @csrf
                @method('put')
                <h5>Inventory Type Calculation</h5>
                <div class="form-check my-2">
                    <input class="form-check-input" type="radio" name="settings_inventory_type" id="inventory1" value="average" @if($settings_inventory_type == 'average') checked @endif>
                    <label class="form-check-label h5" for="inventory1">
                        Average
                    </label>
                    </div>
                    <div class="form-check my-2">
                    <input class="form-check-input" type="radio" name="settings_inventory_type" id="inventory2" value="lifo" @if($settings_inventory_type == 'lifo') checked @endif>
                    <label class="form-check-label h5" for="inventory2">
                        LIFO
                    </label>
                    </div>
                    <div class="form-check my-2">
                    <input class="form-check-input" type="radio" name="settings_inventory_type" id="inventory3" value="fifo" @if($settings_inventory_type == 'fifo') checked @endif>
                    <label class="form-check-label h5" for="inventory3">
                        FIFO
                    </label>
                </div>
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger">Cancel</button>
                <div>
            </form>
        </div>
    </div>
</div>
@endsection
