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

    .inputPrice::-webkit-inner-spin-button, .inputTax::-webkit-inner-spin-button,
    .inputPrice::-webkit-outer-spin-button, .inputTax::-webkit-outer-spin-button {
        -webkit-appearance: none; 
        margin: 0; 
    }
    
    /*
        TEMPORARY
    */
    /* Suggestions items */
    .tagify__dropdown.customers-list .tagify__dropdown__item {
        padding: .5em .7em;
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 0 1em;
        grid-template-areas: "avatar name"
            "avatar email";
    }
    .tagify__dropdown.customers-list .tagify__dropdown__item:hover .tagify__dropdown__item__avatar-wrap {
        transform: scale(1.2);
    }
    .tagify__dropdown.customers-list .tagify__dropdown__item__avatar-wrap {
        grid-area: avatar;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        overflow: hidden;
        background: #EEE;
        transition: .1s ease-out;
    }
    .tagify__dropdown.customers-list img {
        width: 100%;
        vertical-align: top;
    }
    .tagify__dropdown.customers-list strong {
        grid-area: name;
        width: 100%;
        align-self: center;
    }
    .tagify__dropdown.customers-list span {
        grid-area: email;
        width: 100%;
        font-size: .9em;
        opacity: .6;
    }
    .tagify__dropdown.customers-list .addAll {
        border-bottom: 1px solid #DDD;
        gap: 0;
    }
    /* Tags items */
    .tagify__tag {
        white-space: nowrap;
    }
    .tagify__tag:hover .tagify__tag__avatar-wrap {
        transform: scale(1.6) translateX(-10%);
    }
    .tagify__tag .tagify__tag__avatar-wrap {
        width: 16px;
        height: 16px;
        white-space: normal;
        border-radius: 50%;
        background: silver;
        margin-right: 5px;
        transition: .12s ease-out;
    }
    .tagify__tag img {
        width: 100%;
        vertical-align: top;
        pointer-events: none;
    }
</style>

<script src="https://unpkg.com/@yaireo/tagify"></script>
<script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> 
@endpush

@section('content')

<div class="row">

    {{-- Main Content Section --}}
    <div class="col-xl-10 col-lg-9 col-12">
        {{-- Button Group Navigation --}}
        <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
            <button type="button" class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-jv">
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
            <button type="button" class="btn btn-secondary">
                <span class="icon text-white-50">
                    <i class="fas fa-download"></i>
                </span>
                <span class="text">Download Excel Format</span>
            </button>    
        </div>

        {{-- Page Content --}}
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                        <thead>
                            <th id="thead-actions">Actions</th>
                            <th>Reference Number</th>
                            <th>Date</th>
                            <th class="text-right">Amount</th>
                        </thead>
                        <tbody>
                            @for($i = 0; $i < count($journalVouchers); $i++)
                            <tr>
                                <td>
                                    <a href="{{ route('journals.show', $journalVouchers[$i]['id']) }}" role="button" class="btn btn-small btn-icon btn-primary" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                        <span class="icon text-white-50">
                                            <i class='fa fa-eye text-white'></i>
                                        </span>
                                    </a>
                                    {{-- <button type="button" class="btn btn-small btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </button> --}}
                                </td>
                                <td class="table-item-content">{{ $journalVouchers[$i]['reference_number'] }}</td>
                                <td class="table-item-content">{{ $journalVouchers[$i]->journalEntry['date'] }}</td>
                                <td class="table-item-content text-right">{{ number_format($totalAmount[$i], 2) }}</td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar Content Section --}}
    <div class="col-xl-2 col-lg-3 d-none d-lg-block">
        <h4 class="">Account Receivable</h4>
        {{-- Account Receivable Active --}}
        <div class="mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Birr 40,000</div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                2 Active</div>
                        </div>
                        <div class="col-auto">
                            {{-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Account Receivable Overdue --}}
        <div class="mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Birr 215,000</div>
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                5 Over Due</div>
                        </div>
                        <div class="col-auto">
                            {{-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JV Modal --}}
<div class="modal fade" id="modal-jv" tabindex="-1" role="dialog" aria-labelledby="modal-jv-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-jv-label">New Journal Voucher</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-jv" method="post" action="{{ route('journals.store') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="jv_reference_number" class="col-sm-3 col-lg-2 col-form-label">Reference #<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="jv_reference_number" name="reference_number" placeholder="" required>
                        </div>

                        <label for="jv_date" class="col-sm-3 col-lg-2 col-form-label">Date</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="date" class="form-control" id="jv_date" name="date" placeholder="" value="{{date('Y-m-d')}}" required>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <th>Account<span class="text-danger ml-1">*</span></th>
                                <th>Description</th>
                                <th>Debit<span class="text-danger ml-1">*</span></th>
                                <th>Credit<span class="text-danger ml-1">*</span></th>
                                <th>Actions</th>
                            </thead>
                            <thead>
                                <th colspan="5">Debits</th>
                            </thead>
                            <tbody id="jv_debits"></tbody>
                            <thead>
                                <th colspan="5">Credits</th>
                            </thead>
                            <tbody id="jv_credits"></tbody>
                            <tfoot>
                                <th colspan="2" class="pt-2">Total</th>
                                <th>
                                    <p id="jv_debit_total" class="text-right pr-2 pt-2">0.00</p>
                                </th>
                                <th>
                                    <p id="jv_credit_total" class="text-right pr-2 pt-2">0.00</p>
                                </th>
                                <th></th>
                            </tfoot>
                        </table>
                    </div>
                    <div>
                        <label for="jv_notes" class="col-form-label">Notes:</label>
                        <textarea class="form-control" id="jv_notes" name="notes"></textarea>
                    </div>
                    {{-- <div class="form-group row">
                        <label for="c_address" class="col-sm-3 col-lg-2 col-form-label">Address</label>
                        <div class="col-sm-9 col-lg-10">
                            <input type="text" class="form-control" id="c_address" name="address" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="c_city" class="col-sm-3 col-lg-2 col-form-label">City</label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="c_city" name="city" placeholder="">
                        </div>

                        <label for="c_country" class="col-sm-3 col-lg-2 col-form-label">Country</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="text" class="form-control" id="c_country" name="country" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="c_phone_1" class="col-sm-3 col-lg-2 col-form-label">Phone 1</label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="c_phone_1" name="phone_1" placeholder="">
                        </div>

                        <label for="c_phone_2" class="col-sm-3 col-lg-2 col-form-label">Phone 2</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="text" class="form-control" id="c_phone_2" name="phone_2" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="c_fax" class="col-sm-3 col-lg-2 col-form-label">Fax</label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="c_fax" name="fax" placeholder="">
                        </div>

                        <label for="c_mobile_number" class="col-sm-3 col-lg-2 col-form-label">Mobile Number</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="text" class="form-control" id="c_mobile_number" name="mobile_number" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="c_contact_person" class="col-sm-2 col-form-label">Contact Person</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="c_contact_person" name="contact_person" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="c_email" class="col-sm-2 col-form-label">E-mail</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="c_email" name="email" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="c_website" class="col-sm-2 col-form-label">Website</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="c_website" name="website" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="c_picture" class="col-sm-2 col-form-label">Picture</label>
                        <div class="col-sm-10">
                            <input type="file" id="c_picture" name="picture">
                        </div>
                    </div> --}}
                </form>
            </div>
            <div class="modal-footer">
                <div class="form-check mr-3">
                    {{-- <input class="form-check-input" id="c_is_active" type="checkbox" value="" name="is_active">
                    <label class="form-check-label" for="c_is_active">Mark Customer as Active</label> --}}
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="form-jv-save-btn" form="form-jv" disabled>Save Journal Voucher</button>
            </div>
        </div>
    </div>
</div>

{{-- Import --}}
<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="modal-import-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-import-label">Import Customers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-import" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="i_file" class="col-sm-4 col-form-label">File<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-8">
                            <input type="file" id="i_file" name="file" class="mt-1" required>
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
                <form id="form-export" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="e_file_type" class="col-sm-4 col-form-label">File Type<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" id="e_file_type" name="file_type" required>
                                <option>HTML</option>
                                <option>PDF</option>
                                <option>CSV</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-export">Export Customers</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#dataTables').DataTable();
        $('.dataTables_filter').addClass('pull-right');
    });
</script>
<script src="/js/journal_voucher/template_select_account.js"></script>
<script src="/js/journal_voucher/jv_functions.js"></script>
@endsection