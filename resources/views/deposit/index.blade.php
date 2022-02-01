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
<div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
    <a role="button" class="btn btn-primary" href="{{ route('deposit.new') }}">
        <span class="icon text-white-50">
            <i class="fas fa-pen"></i>
        </span>
        <span class="text">New</span>
    </a> 
</div>

{{-- Page Content --}}
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <table class="table table-bordered">
                    <thead>
                        <th id="thead-actions">Actions</th>
                        <th>Date</th>
                        <th>Bank</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{-- <button type="button" class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                </button> --}}
                            </td>
                            <td>Feb. 1, 2022</td>
                            <td>Bank A</td>
                            <td>Birr 1,000</td>
                        </tr>
                    </tbody>
                </table>
            </table>
        </div>
    </div>
</div>

{{-- Modals --}}
{{-- New Receipt --}}
<div class="modal fade" id="modal-new-deposit" tabindex="-1" role="dialog" aria-labelledby="modal-new-deposit-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-new-deposit-label">New Deposit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection