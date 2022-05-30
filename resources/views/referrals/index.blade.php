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

<div class="d-sm-flex align-items-start justify-content-between mb-2">
    <h1>Referrals</h1>
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modal-referral">
            <span class="icon text-primary-50">
                <i class="fas fa-file-import"></i>
            </span>
            <span class="text">New Normal Referral</span>
        </button>
        @if(Auth::user()->control_panel_role == 'admin')
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-advanced-referral">
            <span class="icon text-white-50">
                <i class="fas fa-file-import"></i>
            </span>
            <span class="text">New Advanced Referral</span>
        </button>
        @endif
    </div>  
</div>
<div id="alert-container">

</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th>Referral Code</th>
                    <th>Date Created</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @if(count($referrals) < 1)
                    <tr>
                        <td colspan='5'>You don't have referrals at the moment. Invite someone to use HMEZGEB now.</td>
                    </tr>
                    @endif

                    @foreach($referrals as $referral)
                        <tr>
                            <td>
                                {{ $referral->code }}
                                @if($referral->type == 'advanced')
                                    <span class="badge badge-primary">Advanced</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($referral->created_at)->format('Y-m-d') }}</td>
                            <td>{{ $referral->name }}</td>
                            <td>{{ $referral->email }}</td>
                            <td>
                                <button type="button" class="btn btn-small btn-icon btn-primary" onclick="javascript:void(0)" disabled>
                                    <span class="icon text-white-50">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    Resend Email
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modals --}}
{{-- New Normal Referral --}}
<div class="modal fade" id="modal-referral" tabindex="-1" role="dialog" aria-labelledby="modal-referral-label" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-referral-label">New Normal Referral</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-referral-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form-referral" method="post" action="{{ url('/referrals') }}" class="ajax-submit" data-reload="1">
                    @csrf
                    <div class="form-group row">
                        <label for="r_name" class="col-12 col-lg-6 col-form-label">Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="text" class="form-control" id="r_name" name="name" required>
                        </div>
                        {{-- Error (Name) --}}
                        <p id="error-form-referral-name" data-field="name" class="text-danger col-12 mt-1 mb-0" style="display:none"></p>
                    </div>
                    <div class="form-group row">
                        <label for="r_email" class="col-12 col-lg-6 col-form-label">Email<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="email" class="form-control" id="r_email" name="email" required>
                        </div>
                        {{-- Error (email) --}}
                        <p id="error-form-referral-email" data-field="email" class="text-danger col-12 mt-1 mb-0" style="display:none"></p>
                    </div>
                    <p>The referral code is auto-generated on submission.</p>
                </form>
            </div>
            <div class="modal-footer">
                <button id="close-form-referral" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="submit-form-referral" type="submit" class="btn btn-primary" form="form-referral">Create and Send Invitation</button>
            </div>
        </div>
    </div>
</div>

{{-- New Advanced Referral --}}
<div class="modal fade" id="modal-advanced-referral" tabindex="-1" role="dialog" aria-labelledby="modal-advanced-referral-label" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-advanced-referral-label">New Advanced Referral</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-advanced-referral-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form-advanced-referral" method="post" action="{{ url('/referrals') }}" class="ajax-submit" data-reload="1">
                    @csrf
                    @method('put')
                    <div class="form-group row">
                        <label for="a_name" class="col-12 col-lg-6 col-form-label">Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="text" class="form-control" id="a_name" name="name" required>
                        </div>
                        {{-- Error (Name) --}}
                        <p id="error-form-advanced-referral-name" data-field="name" class="text-danger col-12 mt-1 mb-0" style="display:none"></p>
                    </div>
                    <div class="form-group row">
                        <label for="a_email" class="col-12 col-lg-6 col-form-label">Email<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="email" class="form-control" id="a_email" name="email" required>
                        </div>
                        {{-- Error (Email) --}}
                        <p id="error-form-advanced-referral-email" data-field="email" class="text-danger col-12 mt-1 mb-0" style="display:none"></p>
                    </div>
                    <div class="form-group row">
                        <label for="a_account_type" class="col-12 col-lg-6 col-form-label">Account Type<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <select class="form-control" id="a_account_type" name="account_type" required>
                                <option value='' hidden>Select Account Type</option>
                                <option value='super admin'>Super Admin</option>
                                <option value='admin'>Admin</option>
                                <option value='moderator'>Moderator</option>
                                <option value='member'>Member</option>
                            </select>
                        </div>
                        {{-- Error (Account Type) --}}
                        <p id="error-form-advanced-referral-account_type" data-field="account_type" class="text-danger col-12 mt-1 mb-0" style="display:none"></p>
                    </div>
                    <div class="form-group row">
                        <label id="a_number_of_accounts_label" for="a_number_of_accounts" class="col-12 col-lg-6 col-form-label">Number of Accounts<span class="text-danger ml-1" style="display:none">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="number" min="1" max="10" class="form-control" id="a_number_of_accounts" name="number_of_accounts" value="1" required disabled>
                        </div>
                        {{-- Error (Number of Accounts) --}}
                        <p id="error-form-advanced-referral-number_of_accounts" data-field="number_of_accounts" class="text-danger col-12 mt-1 mb-0" style="display:none"></p>
                    </div>
                    <div class="form-group row">
                        <label for="a_trial_duration" class="col-12 col-lg-6 col-form-label">Trial Duration<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <div class="input-group">
                                <input type="number" class="form-control" id="a_trial_duration" name="trial_duration" value="1" required>
                                <select class="form-control" id="a_trial_duration_type" name="trial_duration_type" required>
                                    <option value='day'>Days</option>
                                    <option value='week'>Weeks</option>
                                    <option value='month'>Months</option>
                                </select>
                            </div>
                        </div>
                        {{-- Error (Trial Duration) --}}
                        <p id="error-form-advanced-referral-trial_duration" data-field="trial_duration" class="text-danger col-12 mt-1 mb-0" style="display:none"></p>
                    </div>
                    <p>The referral code is auto-generated on submission.</p>
                </form>
            </div>
            <div class="modal-footer">
                <button id="close-form-advanced-referral" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="submit-form-advanced-referral" type="submit" class="btn btn-primary" id="a_submit_btn" form="form-advanced-referral">Create and Send Invitation</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
<script>
    // When the account_type is selected, check if it is set to admin or super admin.
    // If it is set to admin or super admin, enable the number of accounts field.
    // Otherwise, disable it.
    $('#a_account_type').change(function() {
        if ($(this).val() == 'admin' || $(this).val() == 'super admin') {
            $('#a_number_of_accounts').prop('disabled', false);
            $('#a_number_of_accounts_label span').show();
        } else {
            $('#a_number_of_accounts').prop('disabled', true);
            $('#a_number_of_accounts_label span').hide();
        }
    });
</script>
@endsection