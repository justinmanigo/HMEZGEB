@extends('template.subscription')

@push('styles')
<style>
    .table-item-content { 
        /** Equivalent to pt-3 */
        padding-top:1rem!important;
    }

    #thead-actions {
        /** Fixed width, increase if adding addt. buttons **/
        width:120px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> 
@endpush

@section('content')
    {{-- Button Group Navigation --}}
    <div class="btn-toolbar mb-3">
        <div class="btn-group mr-3" role="group" aria-label="Button group with nested dropdown">
            <a href="{{ url('/referrals') }}" role="button" class="btn btn-secondary">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                
                <span class="text">Back</span>
            </a> 
        </div>
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <button type="button" class="btn btn-primary" disabled>
                <span class="icon text-white-50">
                    <i class="fas fa-pen"></i>
                </span>
                <span class="text">Update Referral Details</span>
            </button>
            <button type="button" class="btn btn-secondary" disabled>
                <span class="icon text-white-50">
                    <i class="fas fa-envelope"></i>
                </span>
                <span class="text">Resend Email</span>
            </button>
        </div>
    </div>

    <h2>Referral Information</h2>

    <div class="card">
        <div class="card-body">
            <table class="table table-borderless table-sm">
                <tr>
                    <td style="width:200px">Date Created</td>
                    <td><strong>{{ $referral->created_at }}</strong></td>
                </tr>
                <tr>
                    <td>Referral Code</td>
                    <td><strong>{{ $referral->code }}</strong></td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td><strong>
                        @if(!$referral->subscription)
                            {{ $referral->name }}
                        @else
                            {{ $referral->subscription->user->firstName . ' ' . $referral->subscription->user->lastName }}
                        @endif
                    </strong></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><strong>
                        @if(!$referral->subscription)
                            {{ $referral->email }}
                        @else
                            {{ $referral->subscription->user->email }}
                        @endif
                    </strong></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        @if(isset($referral->subscription->status) && $referral->subscription->status == 'unused')
                            <span class="badge badge-danger">
                                {{ ucwords($referral->subscription->status) }}
                            </span>
                        @elseif(isset($referral->subscription->status) && $referral->subscription->status == 'trial')
                            <span class="badge badge-warning">
                                {{ ucwords($referral->subscription->status) }}
                            </span>
                        @elseif(isset($referral->subscription->status) && $referral->subscription->status == 'active')
                            <span class="badge badge-success">
                                {{ ucwords($referral->subscription->status) }}
                            </span>
                        @elseif(isset($referral->subscription->status) && $referral->subscription->status == 'suspended')
                            <span class="badge badge-secondary">
                                {{ ucwords($referral->subscription->status) }}
                            </span>
                        @else
                            <span class="badge badge-danger">
                                {{ ucwords('Unused') }}
                            </span>
                        @endif   
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection