@extends('template.subscription')

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
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-generate-referral">
            <span class="icon text-white-50">
                <i class="fas fa-file-import"></i>
            </span>
            <span class="text">Generate Referrals</span>
        </button>
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
@if(isset($_GET['success']))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $_GET['success'] }}
        {{-- {{ session()->get('success') }} --}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th>Referral Code</th>
                    <th>Date Created</th>
                    <th>Name</th>
                    <th>Status</th>
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
                            <td>
                                @if(!$referral->subscription_owner)
                                    {{ $referral->referred_owner }}
                                @else
                                    {{ $referral->subscription_owner }}
                                @endif
                            </td>
                            <td>
                                @if($referral->status == 'unused')
                                    <span class="badge badge-danger">
                                        {{ ucwords($referral->status) }}
                                    </span>
                                @elseif($referral->status == 'trial')
                                    <span class="badge badge-warning">
                                        {{ ucwords($referral->status) }}
                                    </span>
                                @elseif($referral->status == 'active')
                                    <span class="badge badge-success">
                                        {{ ucwords($referral->status) }}
                                    </span>
                                @elseif($referral->status == 'suspended')
                                    <span class="badge badge-secondary">
                                        {{ ucwords($referral->status) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url("/referrals/{$referral->id}") }}" role="button" class="btn btn-small btn-icon btn-dark" data-toggle="tooltip" data-placement="top" title="View Referral">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </a>
                                <button type="button" class="btn btn-small btn-icon btn-primary btn-resend-invitation" data-id="{{ $referral->id }}" data-toggle="tooltip" data-placement="top" title="Resend Email">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-envelope"></i>
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

{{-- Generate Referrals --}}
<div class="modal fade" id="modal-generate-referral" tabindex="-1" role="dialog" aria-labelledby="modal-generate-referral-label" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-generate-referral-label">Generate Referrals</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-generate-referral-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form class="ajax-submit-updated" id="form-generate-referral" method="post" action="{{ url('/referrals') }}"  data-message="Successfully generated referrals.">
                    @csrf
                    @method('patch')
                    <div class="form-group row">
                        <label for="g_number_of_codes" class="col-12 col-lg-6 col-form-label">Number of Codes<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="number" min="1" class="form-control" id="g_number_of_codes" name="number_of_codes" value="1" required>
                            <p class="text-danger error-message error-message-number_of_codes" style="display:none"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="g_referral_type" class="col-12 col-lg-6 col-form-label">Referral Type<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <select class="form-control" id="g_referral_type" name="referral_type" required>
                                <option value='' hidden>Select Referral Type</option>
                                <option value='normal'>Normal</option>
                                <option value='advanced'>Advanced</option>
                            </select>
                            <p class="text-danger error-message error-message-referral_type" style="display:none"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label id="g_account_type_label" for="g_account_type" class="col-12 col-lg-6 col-form-label">Account Type<span class="text-danger ml-1" style="display:none">*</span></label>
                        <div class="col-12 col-lg-6">
                            <select class="form-control" id="g_account_type" name="account_type" required disabled>
                                <option value='' hidden>Select Account Type</option>
                                <option value='super admin'>Super Admin</option>
                                <option value='admin'>Admin</option>
                                <option value='moderator'>Moderator</option>
                                <option value='member'>Member</option>
                            </select>
                            <p class="text-danger error-message error-message-account_type" style="display:none"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label id="g_number_of_accounts_label" for="g_number_of_accounts" class="col-12 col-lg-6 col-form-label">Number of Accounts<span class="text-danger ml-1" style="display:none">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="number" min="1" max="10" class="form-control" id="g_number_of_accounts" name="number_of_accounts" value="1" required disabled>
                            <p class="text-danger error-message error-message-number_of_accounts" style="display:none"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label id="g_trial_duration_label" for="g_trial_duration" class="col-12 col-lg-6 col-form-label">Trial Duration<span class="text-danger ml-1" style="display:none">*</span></label>
                        <div class="col-12 col-lg-6">
                            <div class="input-group">
                                <input type="number" class="form-control" id="g_trial_duration" name="trial_duration" value="1" min="1" required disabled>
                                <select class="form-control" id="g_trial_duration_type" name="trial_duration_type" required disabled>
                                    <option value='day'>Days</option>
                                    <option value='week'>Weeks</option>
                                    <option value='month'>Months</option>
                                </select>
                                <p class="text-danger error-message error-message-trial_duration error-message-trial_duration_type" style="display:none"></p>
                            </div>
                        </div>
                    </div>
                    <p>The referral code is auto-generated on submission.</p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-generate-referral">Generate Referrals</button>
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

    $('#g_account_type').change(function() {
        if ($(this).val() == 'admin' || $(this).val() == 'super admin') {
            $('#g_number_of_accounts').prop('disabled', false);
            $('#g_number_of_accounts_label span').show();
        } else {
            $('#g_number_of_accounts').prop('disabled', true);
            $('#g_number_of_accounts_label span').hide();
        }
    });

    // When the referral type is selected, check if it is set to normal or advanced.
    // If it is set to advanced, enable the account_type, trial_duration, and trial_duration_type fields.
    $('#g_referral_type').change(function() {
        if ($(this).val() == 'advanced') {
            $('#g_account_type').prop('disabled', false);
            $('#g_trial_duration').prop('disabled', false);
            $('#g_trial_duration_type').prop('disabled', false);

            if($('#g_account_type').val() == 'admin' || $('#g_account_type').val() == 'super admin') {
                $('#g_number_of_accounts').prop('disabled', false);
            } else {
                $('#g_number_of_accounts').prop('disabled', true);
            }

            $('#g_account_type_label span').show();
            $('#g_trial_duration_label span').show();
            $('#g_trial_duration_type_label span').show();
            $('#g_number_of_accounts_label span').show();
        } else {
            $('#g_account_type').prop('disabled', true);
            $('#g_trial_duration').prop('disabled', true);
            $('#g_trial_duration_type').prop('disabled', true);
            $('#g_number_of_accounts').prop('disabled', true);

            $('#g_account_type_label span').hide();
            $('#g_trial_duration_label span').hide();
            $('#g_trial_duration_type_label span').hide();
            $('#g_number_of_accounts_label span').hide();

            $('#g_number_of_accounts').val(1);
            $('#g_account_type').val('admin');
            $('#g_trial_duration').val(1);
            $('#g_trial_duration_type').val('week');
        }
    });


</script>
<script src="{{ url('/js/referrals/resend.js') }}"></script>
@endsection
