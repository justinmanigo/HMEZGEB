@extends('template.account')

@section('accounts_content')

<h1>Manage Users</h1>

{{-- Button Group Navigation --}}
@if(session('subscription_user_role') == 'admin' || session('subscription_user_role' == 'moderator'))
    <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
        <div class="btn-group" role="group">
            <button id="btnGroupDrop1" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-new-user"
            aria-haspopup="true" aria-expanded="false">
                <span class="icon text-white-50">
                    <i class="fas fa-user"></i>
                </span>
                <span class="text">Invite User</span>
            </button>
        </div>
    </div>
@endif

@if(\Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ \Session::get('error') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(\Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ \Session::get('success') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="table-responsive">
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
                        @if($user->role == 'super admin')
                            <span class="badge badge-success">{{ ucwords($user->role) }}</span>
                        @elseif($user->role == 'admin')
                            <span class="badge badge-info">{{ ucwords($user->role) }}</span>
                        @elseif($user->role == 'moderator')
                            <span class="badge badge-warning">{{ ucwords($user->role) }}</span>
                        @elseif($user->role == 'member')
                            <span class="badge badge-secondary">{{ ucwords($user->role) }}</span>
                        @else
                            <span class="badge badge-danger">{{ 'Unknown' }}</span>
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
</div>

<!-- Invite User Modal -->
<div class="modal fade" id="modal-add-new-user" tabindex="-1" role="dialog" aria-labelledby="modal-add-new-user-label" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-add-new-user-label">Invite User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-add-new-user-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form-add-new-user" method="post" action="{{ url('/settings/users/add/new')}}">
                    @csrf
                    <div class="form-group row">
                        <label for="anu_email" class="col-12 col-lg-6 col-form-label">Email<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="email" class="form-control" id="anu_email" name="email" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <small class="col-12">Invited Users who aren't part of the accounting system's subscription will automatically get a <span class='badge badge-secondary'>Member</span> role which you can modify at the subscription panel.</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="anu_submit_btn" form="form-add-new-user">Invite User</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('accounts_script')
{{-- <script src="js/account/update_info.js"></script> --}}
@endsection