@extends('template.index')

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

<div class="d-sm-flex align-items-start justify-content-between mb-2">
    <h1>Referrals</h1>
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-referral">
            <span class="icon text-white-50">
                <i class="fas fa-file-import"></i>
            </span>
            <span class="text">New</span>
        </button>
    </div>  
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th>Referral Code</th>
                    <th>Date Created</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @if(count($referrals) < 1)
                    <tr>
                        <td colspan='5'>You don't have referrals at the moment. Invite someone to use HMEZGEB now.</td>
                    </tr>
                    @endif

                    @foreach($referrals as $referral)
                        <tr>
                            <td>{{ $referral->code }}</td>
                            <td>{{ \Carbon\Carbon::parse($referral->created_at)->format('Y-m-d') }}</td>
                            <td>{{ $referral->name }}</td>
                            <td>{{ $referral->email }}</td>
                            <td>
                                <button type="button" class="btn btn-small btn-icon btn-primary" onclick="javascript:void(0)" disabled>
                                    <span class="icon text-white-50">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    Resend Email
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modals --}}
{{-- New Referral --}}
<div class="modal fade" id="modal-referral" tabindex="-1" role="dialog" aria-labelledby="modal-referral-label" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-referral-label">New Normal Referral</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-referral-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form-referral" method="post" action="{{ url('/referrals') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="r_name" class="col-12 col-lg-6 col-form-label">Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="text" class="form-control" id="r_name" name="name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="r_email" class="col-12 col-lg-6 col-form-label">Email<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="email" class="form-control" id="r_email" name="email" required>
                        </div>
                    </div>
                    <p>The referral code is auto-generated on submission.</p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="r_submit_btn" form="form-referral">Create and Send Invitation</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
@endsection