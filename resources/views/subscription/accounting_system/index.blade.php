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
            {{-- <button type="button" class="btn btn-primary" 
                @if($total_acct_limit - $total_accts <= 0) disabled 
                @else data-toggle="modal" data-target="#modal-select-subscription"
                @endif>
                <span class="icon text-white-50">
                    <i class="fas fa-file-import"></i>
                </span>
                <span class="text">Create Accounting System</span>
            </button> --}}
        </div>  
        {{-- <p>
            Accounts: {{ $total_accts }} / {{ $total_acct_limit }}
            @if($total_acct_limit - $total_accts <= 0) <span class="text-danger">(Account limit reached. Please upgrade your account.)</span> @endif
        </p> --}}

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                @foreach($result as $info)
                    <a class="nav-item nav-link @if($loop->first) active @endif" id="nav-{{ $info['subscription']->id }}-tab"
                        data-toggle="tab" href="#nav-{{ $info['subscription']->id }}" role="tab" aria-controls="nav-{{ $info['subscription']->id }}"
                        aria-selected="true">Subscription # {{ $info['subscription']->id }} @if(auth()->id() == $info['subscription']->user_id) <span class='badge badge-success'>Owned</span> @endif</a>
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
            @foreach($result as $info)
                <div class="tab-pane fade show @if($loop->first) active @endif" id="nav-{{ $info['subscription']->id }}" role="tabpanel" aria-labelledby="nav-{{ $info['subscription']->id }}-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th>Name</th>
                                <th>Year</th>
                                <th>Calendar Type</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @foreach($info['accounting_systems'] as $accounting_system)
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
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- P1: Select Subscription --}}
<div class="modal fade" id="modal-select-subscription" tabindex="-1" role="dialog" aria-labelledby="modal-select-subscription-label" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-add-existing-user-label">Select Subscription to Proceed</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-select-subscription-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form-select-subscription" method="post" action="{{ url('/ajax/subscription/accounting-systems/select-subscription/') }}">
                    @csrf
                    <div id="ss_error" class="card border-danger mb-2" style="display:none">
                        <div class="card-body">
                            <p class="text-danger m-0 p-0"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ss_subscription_id" class="col-12 col-lg-6 col-form-label">Subscription<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <select class="form-control form-control-select select-subscription" id="ss_subscription_id" name="subscription_id" required>
                                {{-- @foreach($user->subscriptions as $subscription)
                                    <option value="{{ $subscription->id }}">Subscription # {{ $subscription->id }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="ss_submit_btn" form="form-select-subscription">Proceed to Onboarding</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).on('submit', '#form-select-subscription', function(e){
        e.preventDefault();
        $('button[form="form-select-subscription"]').attr('disabled', true)

        form = $(this);

        console.log(form.serialize());
        console.log(form.attr('action'));
        console.log(form.attr('method'));

        request = $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize()
        });

        request.done(function(res){
            console.log('form-select-subscription submit')
            console.log(res);
            window.location.href = `/onboarding`;
        });

        request.fail(function(res){
            console.log(res);
            $('#ss_error').show();
            $('#ss_error .text-danger').html(res.responseJSON.errors.subscription_id[0]);
        })
    })
</script>
@endpush
