@extends('template.account')

@section('accounts_content')

<h1>Manage Users</h1>

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
            <tr>
                <td>{{ ucwords(Auth::user()->firstName . ' ' . Auth::user()->lastName) }}</td>
                <td>{{ Auth::user()->email }}</td>
                <td>{{ 'To be added later' }}</td>
                <td>{{ 'To be added later' }}</td>
                <td>{{ 'To be added later' }}</td>
                <td>
                    <a type="button" class="btn btn-primary" href="{{ url('account/users/' . Auth::user()->id) }}">
                        <span class="icon text-white-50">
                            <i class="fas fa-pen"></i>
                        </span>
                    </a>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection

@section('accounts_script')
{{-- <script src="js/account/update_info.js"></script> --}}
@endsection