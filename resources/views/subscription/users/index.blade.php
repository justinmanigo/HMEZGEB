@extends('template.subscription')

@push('styles')
    <link rel="stylesheet" href="{{ url('/css/tagify-template.css') }}">
    <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')

<h3>Manage Subscription Users</h3>

<div class="card">
    <div class="card-body">
        <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                    <span class="icon text-white-50">
                        <i class="fas fa-user"></i>
                    </span>
                    <span class="text">Add User</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-add-new-user">New User</a>
                    <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-add-existing-user">Existing User</a>
                </div>
            </div>
        </div>

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                @foreach($user->subscriptions as $subscription)
                    <a class="sub-tab nav-item nav-link @if($loop->first) active @endif" data-id="{{ $subscription->id }}" id="nav-{{ $subscription->id }}-tab"
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
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @foreach($subscription->subscriptionUsers as $subscriptionUser)
                                    <tr>
                                        <td>{{ $subscriptionUser->user->firstName . ' ' . $subscriptionUser->user->lastName }}</td>
                                        <td>{{ $subscriptionUser->user->email }}</td>
                                        <td>
                                            @if($subscriptionUser->role == 'super admin')
                                                <span class="badge badge-success">Super Admin</span>
                                            @elseif($subscriptionUser->role == 'admin')
                                                <span class="badge badge-info">Admin</span>
                                            @elseif($subscriptionUser->role == 'moderator')
                                                <span class="badge badge-primary">Moderator</span>
                                            @elseif($subscriptionUser->role == 'member')
                                                <span class="badge badge-secondary">Member</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" role="button" class="btn btn-sm btn-primary disabled">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Edit</span>
                                            </a>
                                            <a href="#" role="button" class="btn btn-sm btn-danger disabled">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                                <span class="text">Remove</span>
                                            </a>
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

{{-- Modals --}}
{{-- P1: Add New User --}}
<div class="modal fade" id="modal-add-new-user" tabindex="-1" role="dialog" aria-labelledby="modal-add-new-user-label" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-add-new-user-label">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-add-new-user-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form-add-new-user" method="post" action="{{ url('/ajax/subscription/user/add/new')}}">
                    @csrf
                    <div class="form-group row">
                        <label for="anu_subscription_id" class="col-12 col-lg-6 col-form-label">Subscription<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <select class="form-control form-control-select select-subscription" id="anu_subscription_id" name="subscription_id" required>
                                @foreach($user->subscriptions as $subscription)
                                    <option value="{{ $subscription->id }}">Subscription # {{ $subscription->id }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="anu_first_name" class="col-12 col-lg-6 col-form-label">First Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="text" class="form-control" id="anu_first_name" name="first_name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="anu_last_name" class="col-12 col-lg-6 col-form-label">Last Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="text" class="form-control" id="anu_last_name" name="last_name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="anu_email" class="col-12 col-lg-6 col-form-label">Email<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="email" class="form-control" id="anu_email" name="email" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="anu_role" class="col-12 col-lg-6 col-form-label">Role<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <select class="form-control form-control-select" id="anu_role" name="role" required>
                                <option value='' disabled hidden selected>Select Role</option>
                                <option value='admin'>Admin</option>
                                <option value='moderator'>Moderator</option>
                                <option value='member'>Member</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="anu_submit_btn" form="form-add-new-user">Create & Invite User</button>
            </div>
        </div>
    </div>
</div>

{{-- P1: Add Existing User --}}
<div class="modal fade" id="modal-add-existing-user" tabindex="-1" role="dialog" aria-labelledby="modal-add-existing-user-label" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-add-existing-user-label">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-add-existing-user-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form-add-existing-user" method="post" action="{{ url('/ajax/subscription/user/add/existing')}}">
                    @csrf
                    <div class="form-group row">
                        <label for="aeu_subscription_id" class="col-12 col-lg-6 col-form-label">Subscription<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <select class="form-control form-control-select select-subscription" id="aeu_subscription_id" name="subscription_id" required>
                                @foreach($user->subscriptions as $subscription)
                                    <option value="{{ $subscription->id }}">Subscription # {{ $subscription->id }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="aeu_user" class="col-12 col-lg-6 col-form-label">Select User<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="text" class="form-control" id="aeu_user" name="user" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="aeu_role" class="col-12 col-lg-6 col-form-label">Role<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <select class="form-control form-control-select" id="aeu_role" name="role" required>
                                <option value='' disabled hidden selected>Select Role</option>
                                <option value='admin'>Admin</option>
                                <option value='moderator'>Moderator</option>
                                <option value='member'>Member</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="anu_submit_btn" form="form-add-existing-user">Add & Invite User</button>
            </div>
        </div>
    </div>
</div>

{{-- P2: Assign Accounting Systems to User --}}
<div class="modal fade" id="modal-add-access-user" tabindex="-1" role="dialog" aria-labelledby="modal-add-access-user-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-add-existing-user-label">Assign Accounting Systems to User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-add-existing-user-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form-add-access-user" method="post" action="">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-lg-3 col-xl-2">
                            <h5>User Details</h5>
                            <p>
                                Name:<br>
                                <strong id="aau_name">Test User</strong>
                            </p>
                            <p>
                                Subscription ID:<br>
                                <strong id="aau_subscription_id">0</strong>
                            </p>
                        </div>
                        <div class="col-xs-12 col-lg-9 col-xl-10">
                            <div class="card border-success mb-3">
                                <div class="card-body">
                                    <p class="text-success m-0 p-0">Successfully added a subscription user.</p>
                                </div>
                            </div>
                            
                            <p>Assign this user access to certain accounting systems of this subscription.</p>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <th></th>
                                        <th>Accounting System</th>
                                        <th>Accounting Year</th>
                                        <th>Calendar Type</th>
                                    </thead>
                                    <tbody id="aau_accounting_systems">
                                        {{-- <tr>
                                            <td>
                                                <div class="form-group form-check">
                                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                </div>
                                            </td>
                                            <td>
                                                <label class="form-check-label" for="exampleCheck1">Test Accounting System</label>
                                            </td>
                                            <td>2022</td>
                                            <td>Gregorian</td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="anu_submit_btn" form="form-add-access-user">Assign Accounting System Access</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="https://unpkg.com/@yaireo/tagify"></script>
    <script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <script src="{{ url('/js/subscription/template_select_user.js') }}"></script>
    <script src="{{ url('/js/subscription/select_existing_user.js') }}"></script>
    <script>
        // Automatically update subscription selection on forms when navigating between them.
        $(document).on('click', '.sub-tab', function(e){
            console.log(this.dataset.id);
            $('.select-subscription option[value="'+this.dataset.id+'"]').prop('selected', true);
        });

        // Event when form-add-new-user is submitted.
        $(document).on('submit', '#form-add-new-user', function(e){
            e.preventDefault();

            $('#form-add-new-user button[type="submit"]').prop('disabled', true);

            console.log($(this).serialize());
            console.log($(this).attr('action'));
            console.log($(this).attr('method'));

            request = $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
            });

            request.done(function(res){
                console.log(res);

                $('#modal-add-new-user').modal('hide');
                $('#modal-add-access-user').modal('show');

                $('#aau_name').text(res.user.firstName + ' ' + res.user.lastName);
                $('#aau_subscription_id').text(res.subscription_id);

                $('#form-add-access-user').attr('action', `/ajax/subscription/user/add/access/${res.subscription_user.id}`);

                printAccountingSystems(res.subscription_id);
            });

            request.fail(function(res){
                console.log(res);

                if(res.status != 422)
                {
                    console.log(res.responseJSON.message);
                    // generateToast(jqXHR.responseJSON.message, 'bg-danger');
                    // closeButtonElement.click();
                }
                else
                {
                    console.log(res.responseJSON.errors);
                    showFormErrorsUpdated(res.responseJSON.errors, $(this).attr('id'));
                }
            });

            request.always(function(){
                $('#form-add-new-user button[type="submit"]').prop('disabled', true);
            });
        });

        // Event when form-add-existing-user is submitted.
        $(document).on('submit', '#form-add-existing-user', function(e){
            e.preventDefault();
            console.log($(this).serialize());
            console.log($(this).attr('action'));
            console.log($(this).attr('method'));

            request = $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
            });

            request.done(function(res){
                console.log(res);

                $('#modal-add-existing-user').modal('hide');
                $('#modal-add-access-user').modal('show');

                $('#aau_name').text(res.user.firstName + ' ' + res.user.lastName);
                $('#aau_subscription_id').text(res.subscription_id);

                $('#form-add-access-user').attr('action', `/ajax/subscription/user/add/access/${res.subscription_user.id}`);

                printAccountingSystems(res.subscription_id);     
            });

            request.fail(function(res){
                console.log(res);

                if(res.status != 422)
                {
                    console.log(res.responseJSON.message);
                    // generateToast(jqXHR.responseJSON.message, 'bg-danger');
                    // closeButtonElement.click();
                }
                else
                {
                    console.log(res.responseJSON.errors);
                    showFormErrorsUpdated(res.responseJSON.errors, $(this).attr('id'));
                }
            });

            request.always(function(){
                $('#form-add-new-user button[type="submit"]').prop('disabled', true);
            });
        });

        function printAccountingSystems(subscription_id)
        {
            var success = false;
            request = $.ajax({
                url: `/ajax/subscription/user/get/accounting-systems/${subscription_id}`,
                method: 'GET',
                data: {
                    subscription_id: subscription_id,
                },
            });

            request.done(function(res){
                success = true;
                console.log(res);

                $('#aau_accounting_systems').html('');

                res.forEach(function(as){
                    // add row to table
                    $('#aau_accounting_systems').append(
                        '<tr>'+
                            '<td>'+
                                '<div class="form-group form-check">'+
                                    '<input type="checkbox" class="form-check-input" id="exampleCheck1">'+
                                '</div>'+
                            '</td>'+
                            '<td>'+
                                '<label class="form-check-label" for="exampleCheck1">'+as.name+'</label>'+
                            '</td>'+
                            '<td>'+
                                '<label class="form-check-label" for="exampleCheck1">'+as.accounting_year+'</label>'+
                            '</td>'+
                            '<td>'+
                                '<label class="form-check-label" for="exampleCheck1">'+as.calendar_type+'</label>'+
                            '</td>'+
                        '</tr>'
                    );
                });
            });

            // request.fail(function(res){
            //     // console.log(res);
            // });

            console.log(`printAccountingSystems: ${success}`);
            return success;
        }
    </script>
    
@endpush