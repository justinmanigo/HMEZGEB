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
    <div class="row mb-4">
        <div class="card col-12 col-lg-6">
            <div class="card-body">
                <p>To proceed with the bank reconciliation process, kindly select a Bank Account and import its bank statement in the form below.</p>
                <form id="form-getting-started" action="" method="POST">
                    <div class="form-group">
                        <label for="bank-account">Bank Account</label>
                        <input class="form-control" id="gs_bank_account" name="bank_account">
                    </div>
                    <div class="form-group">
                        <label for="bank-statement">Bank Statement</label>
                        <input type="file" class="form-control-file" id="gs_bank_statement" name="bank_statement">
                    </div>
                    <button type="submit" class="btn btn-primary">Import</button>
                </form>
            </div>
        </div>        
    </div>
</div>
@endsection

@push('scripts')
<script src="/js/banking/template_select_bank.js"></script>
<script src="/js/banking/reconciliation/select_bank.js"></script>
@endpush