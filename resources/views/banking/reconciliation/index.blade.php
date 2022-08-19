@extends('template.index')

@push('styles')
<style>
    .thead-actions {
        /** Fixed width, increase if adding addt. buttons **/
        width: 120px;
    }
</style>

<script src="https://unpkg.com/@yaireo/tagify"></script>
<script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <h1>Bank Reconciliation</h1>
    </div>
</div>
@endsection
