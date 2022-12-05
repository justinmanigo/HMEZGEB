@extends('template.index')

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
                @if(isset($_GET['success']))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ $_GET['success'] }}
                        {{-- {{ session()->get('success') }} --}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                        <thead>
                            <th>ID</th>
                            <th>Date</th>
                            <th class="text-right">Amount</th>
                            <th id="thead-actions">Actions</th>
                        </thead>
                        <tbody>
                            @for($i = 0; $i < count($journalVouchers); $i++)
                            <tr>
                                <td class="table-item-content">{{ $journalVouchers[$i]->id }}</td>
                                <td class="table-item-content">{{ $journalVouchers[$i]->journalEntry['date'] }}</td>
                                <td class="table-item-content text-right">{{ number_format($totalAmount[$i], 2) }}</td>
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
                <form class="ajax-submit-updated" id="form-jv" method="post" action="{{ route('journals.store') }}" data-message="Successfully created a journal voucher.">
                    @csrf
                    <div class="form-group row">
                        {{-- Blank for now --}}
                        <label for="jv_reference_number" class="col-sm-3 col-lg-2"></label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0"></div>

                        {{-- Date --}}
                        <label for="jv_date" class="col-sm-3 col-lg-2 col-form-label">Date <span class="text-danger ml-1">*</span> :</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="date" class="form-control" id="jv_date" name="date" placeholder="" value="{{date('Y-m-d')}}" required>
                            <p class="col-8 col-lg-5 text-danger error-message error-message-date" style="display:none"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{-- Blank for now --}}
                        <label for="jv_reference_number" class="col-sm-3 col-lg-2"></label>
                        <div class="col-sm-9 col-lg-4 mb-3 mb-lg-0"></div>

                        {{-- Reference --}}
                        <label for="jv_reference_number" class="col-sm-3 col-lg-2 col-form-label">Reference # :</label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="text" class="form-control" id="jv_reference_number" name="reference_number" placeholder="" value="" >
                            <p class="col-8 col-lg-5 text-danger error-message error-message-date" style="display:none"></p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <th>Account<span class="text-danger ml-1">*</span></th>
                                <th>Description<span class="text-danger ml-1">*</span></th>
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
                                <th colspan="2" class="pt-2">
                                    Total
                                    <p class="text-danger error-message error-message-total" style="display:none"></p>
                                </th>
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
                        <p class="text-danger error-message error-message-notes" style="display:none"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="form-jv-save-btn" form="form-jv">Save Journal Voucher</button>
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
