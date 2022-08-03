@extends('template.subscription')

@push('styles')

@endpush

@push('scripts')

@endpush

@section('content')

<div class="container">
    <div class="row">
        <h3>Subscription Summary</h3>
    </div>
    
    @if (isset($subscriptions) && count($subscriptions) > 0)
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
                                <td>Owner</td>
                                <td class="text-right">
                                    {{ $subscription->subscription_owner_name }}
                                </td>
                            </tr>
                            @if($subscription->subscription_user_role == 'admin' || $subscription->subscription_user_role == 'super admin')
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
                            @endif
                            <tr>
                                <td>Account Role</td>
                                <td class="text-right">
                                    @if($subscription->subscription_user_role == 'super admin')
                                        <span class="badge badge-success">Super Admin</span>
                                    @elseif($subscription->subscription_user_role == 'admin')
                                        <span class="badge badge-info">Admin</span>
                                    @elseif($subscription->subscription_user_role == 'moderator')
                                        <span class="badge badge-warning">Moderator</span>
                                    @elseif($subscription->subscription_user_role == 'member')
                                        <span class="badge badge-secondary">Member</span>
                                    @endif
                                </td>
                            </tr>
                            @if($subscription->subscription_user_role == 'admin' || $subscription->subscription_user_role == 'super admin')
                                <tr>
                                    <td>Expires At</td>
                                    <td class="text-right">
                                        @if($subscription->account_type == 'super admin' && $subscription->date_to == null)
                                            <span class="badge badge-success">Never Expires</span>
                                        @else
                                            {{ $subscription->date_to }}
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </td>
                    </tr>
                </table>
                @if($subscription->is_accepted == 0 && $subscription->account_type != 'super admin')
                    You are invited to this subscription.
                    <!-- Add button group with accept and reject buttons -->
                    <div class="btn-group">
                        <button type="button" data-id="{{ $subscription->subscription_user_id }}" class="btn btn-success btn-accept-invitation">Accept</button>
                        <button type="button" data-id="{{ $subscription->subscription_user_id }}" class="btn btn-danger btn-reject-invitation">Reject</button>
                    </div>
                @elseif($subscription->is_accepted == 0 && $subscription->account_type == 'super admin')
                    To gain access to this subscription, you must accept the invitation as HMEZGEB Admin/Staff.
                @endif
            </div>
            @endforeach
        </div>
    @else
        <div class="row">
            <h4 class="mb-4">You are not a member of any subscriptions.</h4>
        </div>
        <div class="row">
            <button class="btn btn-primary m-0" disabled>Sign up for a subscription!</button>
        </div>
    @endif
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
