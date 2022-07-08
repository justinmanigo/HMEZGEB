@extends('template.account')

@section('accounts_content')

<h5>Edit Accounting System User</h5>
<p>You are currently editing <strong>{{ $as_user->user->firstName . ' ' . $as_user->user->lastName }}</strong></p>

@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session()->get('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<form id="form_permissions" method="post" action="/settings/users/{{ $user_id }}/edit">
    @csrf
    @method('PUT')
    <h5>Edit Role</h5>
    <div class="form-group row">
        <div class="col-12 col-lg-3">
            <label for="role">Role</label>
        </div>
        <div class="col-12 col-lg-6">
            <select class="form-control" id="role" name="role" required>
                <option value="" disabled hidden selected>Select a role</option>
                <option value="admin" {{ $as_user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="moderator" {{ $as_user->role == 'moderator' ? 'selected' : '' }}>Moderator</option>
                <option value="member" {{ $as_user->role == 'member' ? 'selected' : '' }}>Member</option>
            </select>
        </div>
    </div>

    <h5>Edit User Permissions</h5>
    <div class="table-responsive">
        <div class="card-columns">

            @for($i = 0; $i < count($modules); $i++)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ ucwords($modules[$i]->name) }}</h5>
                    <div class="submodules">

                        @for($j = 0; $j < count($permissions[$i]); $j++)
                        <div id="submodule_{{ $permissions[$i][$j]->id }}" class="row mb-2">
                            <div class="col-8">
                                <p class="mt-2 mb-0">{{ ucwords($permissions[$i][$j]->name) }}</p>
                            </div>
                            <div class="col-4">
                                <input type="hidden" name="submodule_id[]" value="{{ $permissions[$i][$j]->id }}">
                                <select name="access_level[]" class="form-control">
                                    <option value="none" @if($permissions[$i][$j]->access_level == null) selected=selected @endif>None</option>
                                    <option value="r" @if($permissions[$i][$j]->access_level == 'r') selected=selected @endif>Read Only</option>
                                    <option value="rw" @if($permissions[$i][$j]->access_level == 'rw') selected=selected @endif>Read & Write</option>
                                </select>
                            </div>
                        </div>
                        @endfor

                    </div>
                </div>
            </div>
            @endfor

            
        </div>
    </div>

    <button type="submit" class="btn btn-primary form-control">Submit</button>
</form>

@endsection

@section('accounts_script')
{{-- <script src="js/account/update_info.js"></script> --}}
@endsection