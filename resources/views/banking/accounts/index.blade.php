@extends('template.index')

@push('styles')
    <style>
        .table-item-content { 
        /** Equivalent to pt-3 */
        padding-top:1rem!important;
        }

        .thead-actions {
            /** Fixed width, increase if adding addt. buttons **/
            width:120px;
        }
        .content-card {
            border-radius:0px 0px 5px 5px;
        }

        .inputPrice::-webkit-inner-spin-button, .inputTax::-webkit-inner-spin-button,
        .inputPrice::-webkit-outer-spin-button, .inputTax::-webkit-outer-spin-button {
            -webkit-appearance: none; 
            margin: 0; 
        }

        input[type="checkbox"], label {
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
            <button role="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-deposit">
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
        </div>

        {{-- Tab Navigation --}}
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="transactions-tab" data-toggle="tab" href="#transactions" role="tab" aria-controls="transactions" aria-selected="true">Bank Accounts</a>
            </li>
            {{-- <li class="nav-item" role="presentation">
                <a class="nav-link" id="proforma-tab" data-toggle="tab" href="#proforma" role="tab" aria-controls="proforma" aria-selected="false">Proforma</a>
            </li> --}}
        </ul>

        {{-- Tab Contents --}}
        <div class="card" class="content-card">
            <div class="card-body tab-content" id="myTabContent">
                {{-- success message --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
        
                    </div>
                @endif
                {{-- error message --}}
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                @endif

                {{-- Transaction Contents --}}
                <div class="tab-pane fade show active" id="transactions" role="tabpanel" aria-labelledby="transactions-tab">
                    <div class="table-responsive">
                         <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                
                            <thead>
                                
                                <th>Chart of Acct#</th>
                                <th>Account Name</th>
                                <th>Branch</th>
                                <th>Type</th>
                                <th>Account Number</th>
                            
                            </thead>
                            <tbody>
                                @foreach($bank_accounts as $account)
                                <tr onclick="window.location='{{ route('accounts.accounts.edit',$account->id) }}'">
                                    <td>{{ $account->chartOfAccount->chart_of_account_no }}</td>
                                    <td>{{ $account->chartOfAccount->account_name }}</td>
                                    <td>{{ $account->bank_branch }}</td>
                                    <td>{{ $account->bank_account_type }}</td>
                                    <td>{{ $account->bank_account_number }}</td>
                                    
                                </tr>
                                @endforeach
                                {{-- <tr>
                                    
                                    <td class="table-item-content">1030</td>
                                    <td class="table-item-content">Commercail Bank of Ethiopia	</td> 
                                    <td class="table-item-content"> Main Branch	</td>
                                    <td class="table-item-content"> Checking Account </td>
                                    <td class="table-item-content">100002344758</td>
                                    <td class="table-item-content">700,000.00 </td>
                                    <td>
                                        <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-small btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

   

</div>

{{-- Modals --}}
{{-- Import --}}
<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="modal-import-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-import-label">Import Accounts</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-import" action="{{route('accounts.accounts.import')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row container">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" name="file">
                            <label class="custom-file-label" for="file">Choose file</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-import">Import Accounts</button>
            </div>
        </div>
    </div>
</div>

{{-- Export --}}
<div class="modal fade" id="modal-export" tabindex="-1" role="dialog" aria-labelledby="modal-export-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-export-label">Export Accounts</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-export" action="{{route('accounts.accounts.export')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="e_file_type" class="col-sm-4 col-form-label">File Type<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" id="e_file_type" name="file_type" required>
                                <option value="pdf">PDF</option>
                                <option value="csv">CSV</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-export">Export Accounts</button>
            </div>
        </div>
    </div>
</div>

{{-- New Deposit --}}
<div class="modal fade" id="modal-deposit" tabindex="-1" role="dialog" aria-labelledby="modal-deposit-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-deposit-label">New Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('accounts.accounts.store')}}" id="form-deposit" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="b_coa_number" class="col-sm-3 col-lg-2 col-form-label">Chart of Account Number<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <input type="text" class="form-control" id="b_coa_number" name="coa_number" placeholder="XXXX" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="b_account_name" class="col-sm-3 col-lg-2 col-form-label">Bank Account Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <input type="text" class="form-control" id="b_account_name" name="account_name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="b_account_number" class="col-sm-3 col-lg-2 col-form-label">Bank Account Number<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <input type="text" class="form-control" id="b_account_number" name="bank_account_number" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="b_bank_branch" class="col-sm-3 col-lg-2 col-form-label">Bank Branch<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <input type="text" class="form-control" id="b_bank_branch" name="bank_branch" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="b_type" class="col-sm-3 col-lg-2 col-form-label">Bank Account Type<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-6">
                            <select class="form-control" id="b_type" name="bank_account_type" required>
                                <option value='' selected disabled hidden>Choose Bank Account Type</option>
                                <option value="savings">Savings Account</option>
                                <option value="checking">Checking Account</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-deposit">Save Account</button>
            </div>
        </div>
    </div>
</div>

<script>
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

@endsection