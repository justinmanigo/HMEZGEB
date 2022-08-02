@extends('template.subscription')

@section('content')

<h3>Manage Super Admin Users</h3>

{{-- Button Group Navigation --}}
@if(auth()->user()->control_panel_role == 'admin')
    <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
        <div class="btn-group" role="group">
            <button id="btnGroupDrop1" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-new-user"
            aria-haspopup="true" aria-expanded="false">
                <span class="icon text-white-50">
                    <i class="fas fa-user"></i>
                </span>
                <span class="text">Invite Super Admin</span>
            </button>
        </div>
    </div>
@endif

<div class="table-responsive">
    @if(isset($_GET['success']))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $_GET['success'] }}
            {{-- {{ session()->get('success') }} --}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
            <th>Name</th>
            <th>E-mail</th>
            <th>Role</th>
            @if(auth()->user()->control_panel_role == 'admin')
                <th>Actions</th>
            @endif
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
                    @if(auth()->user()->control_panel_role == 'admin')
                        <td>
                            <button type="button" class="btn btn-sm btn-primary btn-sa-edit" data-id="{{ $user->id }}" data-toggle="modal" data-target="#modal-sa-edit">
                                <span class="icon text-white-50">
                                    <i class="fas fa-pen"></i>
                                    <span class="ml-1">Edit</span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger btn-sa-remove" data-id="{{ $user->id }}" data-toggle="modal" data-target="#modal-sa-remove">
                                <span class="icon text-white-50">
                                    <i class="fas fa-trash"></i>
                                    <span class="ml-1">Remove</span>
                                </span>
                            </button>
                        </td>
                    @endif
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
{{-- FORMERLY: Add New Super Admin User, Now Invite Super Admin --}}
<form action="{{ url('/control/admins/add') }}" id="form-add-new-user" method="post" data-message="Successfully added user for Super Admin Role.">
    @csrf
    @method('PUT')
    <div class="modal fade" id="modal-add-new-user" tabindex="-1" role="dialog"
        aria-labelledby="modal-credit-receipt-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-credit-receipt-label">Invite Super Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="email" class="col-sm-6 col-form-label">Email<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                required>
                            <p id="error-iu-email" class="text-danger error-message error-message-email" style="display:none"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="control_panel_role" class="col-sm-6 col-form-label">Role<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-6">
                            <select class="form-control" id="control_panel_role" name="control_panel_role"
                                required>
                                <option value="" hidden selected disabled>Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                            <p class="text-danger error-message error-message-control_panel_role" style="display:none"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="form-add-new-user">Invite Super Admin</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- Edit Existing Super Admin --}}
<form class="ajax-submit-updated" action="" id="form-edit-sa" method="post" data-message="Successfully modified super admin.">
    @csrf
    @method('PUT')
    <div class="modal fade" id="modal-sa-edit" tabindex="-1" role="dialog"
        aria-labelledby="modal-sa-edit-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-sa-edit-label">Edit Super Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>You are editing Super Admin <strong id="edit-sa-name"></strong> with User ID: <strong id="edit-sa-id"></strong> and Email <strong id="edit-sa-email"></strong></p>
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
                    <button type="submit" class="btn btn-primary" form="form-edit-sa">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- Remove Existing Super Admin --}}
<form class="ajax-submit-updated" action="" id="form-remove-sa" method="post" data-message="Successfully removed super admin.">
    @csrf
    @method('DELETE')
    <div class="modal fade" id="modal-sa-remove" tabindex="-1" role="dialog"
        aria-labelledby="modal-sa-remove-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-sa-remove-label">Remove Super Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove Super Admin <strong id="remove-sa-name"></strong> with User ID: <strong id="remove-sa-id"></strong> and Email <strong id="remove-sa-email"></strong>? <br>
                        His/her user account won't be deleted and the subscription not associated with the super admin status will remain intact. <br>
                        However, the subscription related to this privilege will expire after 7 days, and will be unaccessible until reinstated.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Close</button>
                    <button type="submit" class="btn btn-danger" form="form-remove-sa">Yes, Remove Super Admin</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
    <script src="{{ url('/js/control/template_select_user.js') }}"></script>
    <script src="{{ url('/js/control/select_existing_user.js') }}"></script>
    <script>
        $(document).on('submit', '#form-add-new-user', function(e){
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();
            var url = form.attr('action');
            var method = form.attr('method');

            $('#error-iu-email').hide();
            $('button[form="form-add-new-user"]').prop('disabled', true);

            var request = $.ajax({
                url: url,
                type: method,
                data: formData,
                dataType: 'json',
            });

            request.done(function(res) {
                console.log(res);
                if(res.success) {
                    window.location.href = '{{ url("/control/?success=") }}' + res.message;
                }
                else {
                    $('button[form="form-add-new-user"]').prop('disabled', false);
                    $('#error-iu-email').show().text(res.message);
                }
            });

            request.fail(function(res) {
                console.log(res);
                $('button[form="form-add-new-user"]').prop('disabled', false);
            });
        })

        $(document).on('click', '.btn-sa-edit', function(e) {
            $('#form-edit-sa button[type="submit"]').attr('disabled', true);

            // Check if user still exists. If exists, get data and proceed with modification.
            var request = $.ajax({
                url: "/ajax/control/user/get/" + $(this).data('id'),
                method: "GET",
            });

            request.done(function(res){
                console.log(res);
                $('#form-edit-sa').attr('action', '/control/admins/edit/' + res.id);
                $('#edit-sa-name').html(res.firstName + ' ' + res.lastName);
                $('#edit-sa-id').html(res.id);
                $('#edit-sa-email').html(res.email);
                $('#form-edit-sa option[value="' + res.control_panel_role + '"]').attr('selected', true);
            });

            request.fail(function(res){
                $('#modal-sa-edit').modal('hide');
            });

            request.always(function(res){
                $('#form-edit-sa button[type="submit"]').attr('disabled', false);
            });
        });

        $(document).on('click', '.btn-sa-remove', function(e){
            $('#form-remove-sa button[type="submit"]').attr('disabled', true);

            // Check if user still exists. If exists, get data and prompt to continue removing user.
            var request = $.ajax({
                url: "/ajax/control/user/get/" + $(this).data('id'),
                method: "GET",
            });

            request.done(function(res){
                console.log(res);
                $('#form-remove-sa').attr('action', '/control/admins/remove/' + res.id);
                $('#remove-sa-name').text(res.firstName + ' ' + res.lastName);
                $('#remove-sa-id').text(res.id);
                $('#remove-sa-email').text(res.email);
            });

            request.fail(function(res){
                $('#modal-sa-remove').modal('hide');
            });

            request.always(function(){
                $('#form-remove-sa button[type="submit"]').attr('disabled', false);
            });
        });
    </script>
@endpush