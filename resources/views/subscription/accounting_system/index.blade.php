@extends('template.subscription')

@push('styles')

@endpush

@push('scripts')

@endpush

@section('content')

<h3>Manage Accounting Systems</h3>

<div class="card">
    <div class="card-body">
        <div id="ss_error" class="card border-danger mb-2" style="display:none">
            <div class="card-body">
                <p class="text-danger m-0 p-0"></p>
            </div>
        </div>

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
                    <div class="btn-group mt-4 mb-1" role="group">
                        <form class="cas-select-subscription" 
                            @if($info['subscription']->account_limit - count($info['accounting_systems']) > 0 && auth()->id() == $info['subscription']->user_id)
                                action="{{ url('/ajax/subscription/accounting-systems/select-subscription/') }}"
                                method="POST"
                                data-id="{{ $info['subscription']->id }}"
                            @endif
                        >
                            @csrf
                            <button type="submit" class="btn btn-primary" 
                                @if($info['subscription']->account_limit - count($info['accounting_systems']) <= 0 || 
                                    $info['subscription']->user_id != auth()->id() ||
                                    $info['subscription']->date_to < now()->format('Y-m-d')) 
                                    disabled 
                                @endif>
                                <span class="icon text-white-50">
                                    <i class="fas fa-file-import"></i>
                                </span>
                                <span class="text">Create Accounting System</span>
                            </button>
                        </form>
                    </div>  
                    <p>
                        Accounts: {{ count($info['accounting_systems']) }} / {{ $info['subscription']->account_limit }}
                        @if($info['subscription']->account_limit - count($info['accounting_systems']) <= 0)
                            <span class="text-danger">(Account limit reached. Please upgrade your account.)</span> 
                        @elseif($info['subscription']->user_id != auth()->id())
                            <span class="text-warning">(Only the owner can add accounting systems to this subscription.)</span>
                        @endif
                    </p>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th>Name</th>
                                <th>Year</th>
                                <th>Calendar Type</th>
                                {{-- <th>Actions</th> --}}
                            </thead>
                            <tbody>
                                @foreach($info['accounting_systems'] as $accounting_system)
                                    <tr>
                                        <td>
                                            {{ $accounting_system->name }}
                                            @if($accounting_system->hasAccess)
                                                <span class='badge badge-success'>🗸</span>
                                            @endif
                                        </td>
                                        <td>{{ $accounting_system->accounting_year }}</td>
                                        <td>
                                            @if($accounting_system->calendar_type == 'gregorian')
                                                <span class="badge badge-primary">Gregorian</span>
                                            @elseif($accounting_system->calendar_type == 'ethiopian')
                                                <span class="badge badge-success">Ethiopian</span>
                                            @endif
                                        </td>
                                        {{-- <td>
                                            @if(!$accounting_system->hasAccess)
                                            
                                            @else

                                            @endif
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <small>Checkmark indicates that you have access to that accounting system.</small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).on('submit', '.cas-select-subscription', function(e){
        e.preventDefault();

        var subscription_id = $(this).data('id');
        form = $(this);
        console.log('submit select subscription new')
        console.log(subscription_id);

        request = $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: `${form.serialize()}&subscription_id=${subscription_id}`
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
    });
</script>
@endpush
