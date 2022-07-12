@extends('template.subscription')

@push('styles')

@endpush

@push('scripts')

@endpush

@section('content')

<h3>Manage Accounting Systems</h3>

<div class="card">
    <div class="card-body">
        <div class="btn-group mb-4" role="group">
            <a 
                role="button" 
                class="btn btn-primary @if($total_acct_limit - $total_accts <= 0) {{ 'disabled' }} @endif" 
                @if($total_accts < $total_acct_limit) href="{{ url('/onboarding') }}" @endif
            >
                <span class="icon text-white-50">
                    <i class="fas fa-file-import"></i>
                </span>
                <span class="text">Create Accounting System</span>
            </a>
        </div>  
        <p>
            Accounts: {{ $total_accts }} / {{ $total_acct_limit }}
            @if($total_acct_limit - $total_accts <= 0) <span class="text-danger">(Account limit reached. Please upgrade your account.)</span> @endif
        </p>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th>Name</th>
                    <th>Year</th>
                    <th>Calendar Type</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach($user->subscriptions as $subscription)
                        @foreach($subscription->accountingSystems as $accounting_system)
                            <tr>
                                <td>{{ $accounting_system->name }}</td>
                                <td>{{ $accounting_system->accounting_year }}</td>
                                <td>
                                    @if($accounting_system->calendar_type == 'gregorian')
                                        <span class="badge badge-primary">Gregorian</span>
                                    @elseif($accounting_system->calendar_type == 'ethiopian')
                                        <span class="badge badge-success">Ethiopian</span>
                                    @endif
                                </td>
                                <td>

                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
