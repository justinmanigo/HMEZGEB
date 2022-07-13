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

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                @foreach($user->subscriptions as $subscription)
                    <a class="nav-item nav-link @if($loop->first) active @endif" id="nav-{{ $subscription->id }}-tab"
                        data-toggle="tab" href="#nav-{{ $subscription->id }}" role="tab" aria-controls="nav-{{ $subscription->id }}"
                        aria-selected="true">Subscription # {{ $subscription->id }}</a>
                @endforeach
                {{-- <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                    aria-controls="nav-home" aria-selected="true">Home</a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
                    aria-controls="nav-profile" aria-selected="false">Profile</a>
                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab"
                    aria-controls="nav-contact" aria-selected="false">Contact</a> --}}
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">
            @foreach($user->subscriptions as $subscription)
                <div class="tab-pane fade show active" id="nav-{{ $subscription->id }}" role="tabpanel" aria-labelledby="nav-{{ $subscription->id }}-tab">
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
            @endforeach
        </div>
    </div>
</div>

@endsection
