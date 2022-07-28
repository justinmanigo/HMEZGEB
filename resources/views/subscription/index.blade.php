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
            <h5 class="card-title">
                Subscription ID: {{ $subscription->id }}
                @if(auth()->id() == $subscription->user_id)
                    <span class='badge badge-success'>Owned</span>
                @elseif($subscription->is_accepted == 0)
                    <span class='badge badge-warning'>Invited</span>
                @endif
            </h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td>Account Usage / Limit</td>
                        <td class="text-right">
                            <span class="badge 
                                @if($subscription->account_limit - $subscription->count < 2)
                                    badge-danger
                                @else
                                    badge-success
                                @endif"
                            >
                                {{ $subscription->count }}/{{ $subscription->account_limit }}
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
                @if($subscription->is_accepted == 0)
                    You are invited to this subscription.
                    <!-- Add button group with accept and reject buttons -->
                    <div class="btn-group">
                        <button type="button" data-id="{{ $subscription->subscription_user_id }}" class="btn btn-success btn-accept-invitation">Accept</button>
                        <button type="button" data-id="{{ $subscription->subscription_user_id }}" class="btn btn-danger btn-reject-invitation">Reject</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection

@push('scripts')
<script>
    $(document).on('click', '.btn-accept-invitation', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '/ajax/subscription/accept-invitation',
            type: 'POST',
            data: {
                id: id,
                _token: '{{ csrf_token() }}',
                _method: 'PATCH'
            },
            success: function(response) {
                console.log(response);
                if(response.success) {
                    location.reload();
                }
            }, 
            error: function(response) {
                console.log(response);
            }
        });
    });

    $(document).on('click', '.btn-reject-invitation', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '/ajax/subscription/reject-invitation',
            type: 'POST',
            data: {
                id: id,
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: function(response) {
                console.log(response);
                if(response.success) {
                    location.reload();
                }
            },
            error: function(response) {
                console.log(response);
            }
        });
    });
</script>
@endpush
