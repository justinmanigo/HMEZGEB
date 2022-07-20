@extends('template.subscription')

@push('styles')

@endpush

@push('scripts')

@endpush

@section('content')

<h3>Subscription Summary</h3>

<div class="card-columns">
    @foreach($subscriptions as $subscription)
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Subscription ID: {{ $subscription->id }}</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td>Account Usage / Limit</td>
                        <td class="text-right">
                            <span class="badge 
                                @if($subscription->accountingSystems->count() / $subscription->account_limit > 75)
                                    badge-danger
                                @else
                                    badge-success
                                @endif"
                            >
                                {{ $subscription->accountingSystems->count() }}/{{ $subscription->account_limit }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Account Type</td>
                        <td class="text-right">
                            @if($subscription->account_type == 'super admin')
                                <span class="badge badge-success">Super Admin</span>
                            @elseif($subscription->account_type == 'admin')
                                <span class="badge badge-info">Admin</span>
                            @elseif($subscription->account_type == 'moderator')
                                <span class="badge badge-warning">Moderator</span>
                            @elseif($subscription->account_type == 'user')
                                <span class="badge badge-secondary">User</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Expires At</td>
                        <td class="text-right">
                            @if($subscription->account_type == 'super admin' && $subscription->expires_at == null)
                                <span class="badge badge-success">Never Expires</span>
                            @else
                                {{ $subscription->date_to }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td class="text-right">
                            @if($subscription->status == 'trial')
                                <span class="badge badge-warning">{{ 'Trial' }}</span>
                            @elseif($subscription->status == 'active')
                                <span class="badge badge-success">Active</span>
                            @elseif($subscription->status == 'expired')
                                <span class="badge badge-danger">Expired</span>
                            @else
                                <span class="badge badge-secondary">{{ $subscription->status }}</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
