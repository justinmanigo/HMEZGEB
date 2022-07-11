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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create-as" disabled>
                <span class="icon text-white-50">
                    <i class="fas fa-file-import"></i>
                </span>
                <span class="text">Create Accounting System</span>
            </button>
        </div>  
        <p>Accounts: {{ $total_accts }} / {{ $total_acct_limit }}</p>

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
