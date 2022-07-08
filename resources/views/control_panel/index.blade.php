@extends('template.account')

@section('accounts_content')

<h3>Manage Super Admin Users</h3>

{{-- Button Group Navigation --}}
<div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
    <div class="btn-group" role="group">
        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <span class="icon text-white-50">
                <i class="fas fa-user"></i>
            </span>
            <span class="text">Add Super Admin</span>
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-add-new-user">New User</a>
            <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-add-existing-user">Existing User</a>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <th>Name</th>
            <th>E-mail</th>
            <th>Role</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach($super_admins as $user)
                <tr>
                    <td>{{ ucwords($user->firstName . ' ' . $user->lastName) }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->control_panel_role == 'admin')
                            <span class="badge badge-success">{{ ucwords($user->control_panel_role) }}</span>
                        @elseif($user->control_panel_role == 'staff')
                            <span class="badge badge-secondary">{{ ucwords($user->control_panel_role) }}</span>
                        @endif
                    </td>
                    <td>
                        {{-- TODO: Change Role / Remove Admin --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <th>Name</th>
            <th>E-mail</th>
            <th>Role</th>
            <th>Status</th>
            <th>Last Logged In</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach($accountingSystemUsers as $user)
                <tr>
                    <td>{{ ucwords($user->firstName . ' ' . $user->lastName) }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role == 'admin')
                            <span class="badge badge-success">{{ ucwords($user->role) }}</span>
                        @elseif($user->role == 'moderator')
                            <span class="badge badge-info">{{ ucwords($user->role) }}</span>
                        @elseif($user->role == 'member')
                            <span class="badge badge-warning">{{ ucwords($user->role) }}</span>
                        @else
                            <span class="badge badge-secondary">{{ 'Unknown' }}</span>
                        @endif
                    </td>
                    <td><span class="text-muted">{{ 'To be added later' }}</span></td>
                    <td><span class="text-muted">{{ 'To be added later' }}</span></td>
                    <td>
                        <a type="button" class="btn btn-primary" href="{{ url('settings/users/' . $user->accounting_system_user_id) }}/permissions">
                            <span class="icon text-white-50">
                                <i class="fas fa-pen"></i>
                            </span>
                        </a>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}

{{-- Modals --}}
{{-- Add New Super Admin User --}}
<form action="{{ url('/control/admins/add') }}" id="form-add-new-user" method="post" data-message="Successfully added user for Super Admin Role.">
    @csrf
    @method('PUT')
    <div class="modal fade" id="modal-add-new-user" tabindex="-1" role="dialog"
        aria-labelledby="modal-credit-receipt-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-credit-receipt-label">Add New Super Admin User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Name</h5>
                    <div class="form-group row">
                        <label for="firstName" class="col-sm-6 col-form-label">First Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="firstName" name="firstName"
                                placeholder="First Name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lastName" class="col-sm-6 col-form-label">Last Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="lastName" name="lastName"
                                placeholder="Last Name" required>
                        </div>
                    </div>
                    <h5>Login Credentials</h5>
                    <div class="form-group row">
                        <label for="email" class="col-sm-6 col-form-label">Email<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-6 col-form-label">Password<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_confirmation" class="col-sm-6 col-form-label">Confirm Password<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Confirm Password" required>
                        </div>
                    </div>
                    <h5>Role</h5>
                    <div class="form-group row">
                        <label for="control_panel_role" class="col-sm-6 col-form-label">Role<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-6">
                            <select class="form-control" id="control_panel_role" name="control_panel_role"
                                required>
                                <option value="" hidden selected disabled>Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form-add-new-user">Save & Add Super Admin User</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- Add New Super Admin User --}}
<form action="{{ url('/control/admins/add') }}" id="form-add-existing-user" method="post" data-message="Successfully added existing user for Super Admin Role.">
    @csrf
    <div class="modal fade" id="modal-add-existing-user" tabindex="-1" role="dialog"
        aria-labelledby="modal-add-existing-user-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-credit-receipt-label">Add Existing User for Super Admin Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="e_user" class="col-sm-6 col-form-label">User<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="e_user" name="user">
                            <p class="text-danger error-message error-message-user" style="display:none"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="control_panel_role" class="col-sm-6 col-form-label">Role<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-6">
                            <select class="form-control" id="e_control_panel_role" name="control_panel_role"
                                required>
                                <option value="" hidden selected disabled>Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form-add-existing-user">Save & Add Super Admin User</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('accounts_script')
    <script src="{{ url('/js/control/template_select_user.js') }}"></script>
    <script src="{{ url('/js/control/select_existing_user.js') }}"></script>
@endsection