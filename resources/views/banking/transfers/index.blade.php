@extends('template.index')


@push('styles')
<style>
    .content-card {
        border-radius: 0px 0px 5px 5px;
    }

    .inputPrice::-webkit-inner-spin-button,
    .inputTax::-webkit-inner-spin-button,
    .inputPrice::-webkit-outer-spin-button,
    .inputTax::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="checkbox"],
    label {
        cursor: pointer;
    }
</style>
@endpush

@section('content')

<div class="row">

    {{-- Main Content Section --}}
    <div class="col-xl-12 col-lg-12 col-12">
     {{-- Button Group Navigation --}}
        <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
            <button type="button" class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-customer">
                <span class="icon text-white-50">
                    <i class="fas fa-exchange-alt"></i>
                </span>
                <span class="text">Transfer</span>
            </button>
            <button type="button" class="btn btn-secondary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-import">
                <span class="icon text-white-50">
                    <i class="fas fa-file-import"></i>
                </span>
                <span class="text">Import</span>
            </button>
            <button type="button" class="btn btn-secondary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-export">
                <span class="icon text-white-50">
                    <i class="fas fa-file-export"></i>
                </span>
                <span class="text">Export</span>
            </button>
        </div>
        {{-- Button Group Navigation --}}
        {{-- <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="icon text-white-50">
                        <i class="fas fa-pen"></i>
                    </span>
                    <span class="text">New</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-receipt">Receipt</a>
                    <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-advance-revenue">Advance Revenue</a>
                    <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-credit-receipt">Credit Receipt</a>
                    <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-proforma">Proforma</a>
                </div>
            </div>
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
        </div> --}}

        {{-- Tab Navigation --}}
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="transactions-tab" data-toggle="tab" href="#transactions" role="tab" aria-controls="transactions" aria-selected="true">Transfer History</a>
            </li>
        </ul>

        {{-- Tab Contents --}}
        <div class="card" class="content-card">
            <div class="card-body tab-content" id="myTabContent">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="tab-pane fade show active" id="transactions" role="tabpanel" aria-labelledby="transactions-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                            <thead>
                                <th>Date</th>
                                <th>Reference</th>
                                <th>From Bank</th>
                                <th>To Bank</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Reason</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @foreach($transfers as $transfer)
                                <tr>
                                    <td class="table-item-content">{{ $transfer->created_at->format('d-m-Y') }}</td>
                                    <td class="table-item-content">{{$transfer->id}}</td>
                                    <td class="table-item-content">{{$transfer->fromAccount->bank_branch}}</td>
                                    <td class="table-item-content">{{$transfer->toAccount->bank_branch}}</td>
                                    <td class="table-item-content">{{$transfer->amount}}</td>
                                    <td class="table-item-content">
                                        {{-- add badge --}}
                                        @if($transfer->status == 'void')
                                            <span class="badge badge-warning">{{$transfer->status}}</span>
                                        @elseif($transfer->status == 'completed')
                                            <span class="badge badge-success">{{$transfer->status}}</span>
                                        @endif
                                    </td>
                                    <td class="table-item-content">{{$transfer->reason}}</td>
                                    <td>
                                        <a href="{{ url('/banking/transfer/'.$transfer->id.'/edit')}}" class="btn btn-sm btn-icon btn-primary mb-1">
                                            <!-- edit -->
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </a>
                                        <button class="btn btn-sm btn-icon btn-secondary mb-1" data-toggle="modal" data-target="#mail-modal" onclick="mailModal({{$transfer->id}})">
                                            <!-- email -->
                                            <span class="icon text-white-50">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                        </button>
                                        <button class="btn btn-sm btn-icon btn-secondary mb-1" data-toggle="modal" data-target="#print-modal" onclick="printModal({{$transfer->id}})">
                                            <!-- print -->
                                            <span class="icon text-white-50">
                                                <i class="fas fa-print"></i>
                                            </span>
                                        </button>
                                        <button class="btn btn-sm btn-icon btn-danger mb-1" disabled>
                                            <!-- void -->
                                            <span class="icon text-white-50">
                                                <i class="fas fa-ban"></i>
                                            </span>
                                        </button>
                                        <button class="btn btn-sm btn-icon btn-danger mb-1" disabled>
                                            <!-- delete -->
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


{{-- Transfer Modal --}}
<div class="modal fade" id="modal-customer" tabindex="-1" role="dialog" aria-labelledby="modal-customer-label" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-customer-label">New Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('transfers.transfer.store')}}" id="form-transfer" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="t_bank_from" class="col-sm-3 col-lg-4 col-form-label">Send From<span class="text-danger ml-1"></span></label>
                        <div class="col-sm-9 col-lg-12 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="t_bank_from"  placeholder="" required>
                            <input type="hidden" id="t_bank_id_from"  name="from_account_id" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_amount" class="col-sm-3 col-lg-4 col-form-label">Amount</label>
                        <div class="col-sm-9 col-lg-12 mb-3 mb-lg-0">
                            <input type="number" class="form-control" id="t_amount" name="amount" placeholder="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_bank_to" class="col-sm-3 col-lg-6 col-form-label">Destination Account</label>
                        <div class="col-sm-9 col-lg-12 mb-3 mb-lg-0">
                            <input type="text" class="form-control" id="t_bank_to" name="bank_to" placeholder="" required>
                            <input type="hidden" id="t_bank_id_to" name="to_account_id" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_reason" class="col-sm-3 col-lg-4 col-form-label">Reason</label>
                        <div class="col-sm-9 col-lg-12 mb-3 mb-lg-0">
                            <textarea class="form-control" id="t_reason" name="reason" rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-transfer">Transfer Amount</button>
            </div>
        </div>
    </div>
</div>


{{-- Import --}}
<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="modal-import-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-import-label">Import Transfers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-import" action="{{route('transfers.transfers.import')}}" method="post" enctype="multipart/form-data">
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
                <button type="submit" class="btn btn-primary" form="form-import">Import Transfers</button>
            </div>
        </div>
    </div>
</div>

 {{-- Export --}}
<div class="modal fade" id="modal-export" tabindex="-1" role="dialog" aria-labelledby="modal-export-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-export-label">Export Transfers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-export" action="{{route('transfers.transfers.export')}}" method="post" enctype="multipart/form-data">
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
                <button type="submit" class="btn btn-primary" form="form-export">Export Transfers</button>
            </div>
        </div>
    </div>
</div>

{{-- Mail confirmation modal --}}
<div class="modal fade" id="mail-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Send Mail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to print this bank transfer record?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="" class="btn btn-primary" id="mail-modal-btn">Send</a>
            </div>
        </div>
    </div>
</div>

{{-- Print confirmation modal --}}
<div class="modal fade" id="print-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Print</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to send this bank transfer record?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="" class="btn btn-primary" id="print-modal-btn">Send</a>
            </div>
        </div>
    </div>
</div>

<script>
    function mailModal(id)
    {
        $('#mail-modal-btn').attr('href', '{{route("transfers.transfer.mail", ":id") }}'.replace(':id', id));
    }

    function printModal(id)
    {
        $('#print-modal-btn').attr('href', '{{route("transfers.transfer.print", ":id") }}'.replace(':id', id));
    }

    // add the file name only in file input field
    $('.custom-file-input').on('change', function() {
    var fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    $(document).ready(function () {
    $('#dataTables').DataTable();
    $('.dataTables_filter').addClass('pull-right');
    });
</script>
<script src="/js/banking/template_select_bank.js"></script>
<script src="/js/banking/transfer/select_bank.js"></script>

@endsection
