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

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> 
@endpush

@section('content')

<div class="row">
    <p>Referrals</p>
</div>

<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
@endsection