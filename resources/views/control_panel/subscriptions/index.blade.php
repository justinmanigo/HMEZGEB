@extends('template.subscription')

@section('content')

<h3>Manage Subscriptions</h3>

<div class="card shadow mb-2">
    <div class="card-body">
        <div class="table-responsive">
            @if(isset($_GET['success']))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $_GET['success'] }}
                    {{-- {{ session()->get('success') }} --}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(\Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {!! \Session::get('success') !!}
                    {{-- {{ session()->get('success') }} --}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                <thead>
                    <th>ID</th>
                    <th>Owner Name</th>
                    <th>Subscription Type</th>
                    <th>Date From</th>
                    <th>Date To</th>
                    <th>Referred By</th>
                    <th>Status</th>
                    @if(auth()->user()->control_panel_role == 'admin')
                        <th>Actions</th>
                    @endif
                </thead>
                <tbody>
                    @foreach($subscriptions as $subscription)
                        <tr>
                            <td>{{ $subscription->id }}</td>
                            <td>{{ ucwords($subscription->firstName . ' ' . $subscription->lastName) }}</td>
                            <td>
                                @if($subscription->account_type == 'super admin')
                                    <span class="badge badge-success">{{ ucwords($subscription->account_type) }}</span>
                                @elseif($subscription->account_type == 'admin')
                                    <span class="badge badge-info">{{ ucwords($subscription->account_type) }}</span>
                                @elseif($subscription->account_type == 'moderator')
                                    <span class="badge badge-primary">{{ ucwords($subscription->account_type) }}</span>
                                @elseif($subscription->account_type == 'member')
                                    <span class="badge badge-secondary">{{ ucwords($subscription->account_type) }}</span>
                                @endif
                            </td>
                            <td>{{ $subscription->date_from }}</td>
                            <td>{{ $subscription->date_to }}</td>
                            <td>
                                @if(is_null($subscription->referred_by))
                                    none
                                @else
                                    {{ $subscription->referred_by }}
                                @endif
                            </td>
                            <td>
                                @if($subscription->status == 'active' && $subscription->date_to >= date('Y-m-d'))
                                    <span class="badge badge-success">{{ ucwords($subscription->status) }}</span>
                                @elseif($subscription->status == 'active' && $subscription->date_to == null && $subscription->account_type == 'super admin')
                                    <span class="badge badge-success">{{ 'Active' }}</span>
                                @elseif($subscription->status == 'active' && $subscription->date_to < date('Y-m-d'))
                                    <span class="badge badge-secondary">{{ 'Expired' }}</span>
                                @elseif($subscription->status == 'unused')
                                    <span class="badge badge-warning">{{ ucwords($subscription->status) }}</span>
                                @elseif($subscription->status == 'trial')
                                    <span class="badge badge-info">{{ ucwords($subscription->status) }}</span>
                                @elseif($subscription->status == 'suspended')
                                    <span class="badge badge-danger">{{ ucwords($subscription->status) }}</span>    
                                @endif
                            </td>
                            @if(auth()->user()->control_panel_role == 'admin')
                                <td>
                                    <button type="button" class="btn btn-sm btn-info btn-view" data-id="{{ $subscription->id }}" data-toggle="tooltip" title="View">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </button>
                                    @if($subscription->status != 'suspended' && $subscription->account_type != 'super admin')
                                        <button type="button" class="btn btn-sm btn-primary btn-activate" data-id="{{ $subscription->id }}" data-toggle="tooltip" title="Activate">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger btn-suspend" data-id="{{ $subscription->id }}" data-toggle="tooltip" title="Suspend">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-ban"></i>
                                            </span>
                                        </button>
                                    @elseif($subscription->account_type != 'super admin')
                                        <button type="button" class="btn btn-sm btn-info btn-reinstate" data-id="{{ $subscription->id }}" data-toggle="tooltip" title="Suspend">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                            </span>
                                        </button>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- modal -->
<div class="modal fade" id="modal-activate" tabindex="-1" role="dialog" aria-labelledby="modal-activate" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-activate-label">Activate Subscription</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to activate this subscription? If yes, kindly enter the expiration date.</p>
                <p class="alert alert-danger" id="error-sa" style="display:none"></p>
                <form id="form-subscription-activate" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="date_to">Expiration Date</label>
                        <input type="date" class="form-control" id="expiration_date" name="expiration_date" value="{{ now()->format('Y-m-d') }}">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Close</button>
                <button type="submit" class="btn btn-primary" form="form-subscription-activate">Yes, Activate</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-suspend" tabindex="-1" role="dialog" aria-labelledby="modal-suspend" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-suspend-label">Suspend Subscription</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to suspend this subscription?</p>
                <p class="alert alert-danger" id="error-ss" style="display:none"></p>
                <form id="form-subscription-suspend" method="POST">
                    @csrf
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Close</button>
                <button type="submit" class="btn btn-danger" form="form-subscription-suspend">Yes, Suspend</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-reinstate" tabindex="-1" role="dialog" aria-labelledby="modal-reinstate" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-reinstate-label">Reinstate Subscription</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reinstate this subscription?</p>
                <p class="alert alert-danger" id="error-sr" style="display:none"></p>
                <form id="form-subscription-reinstate" method="POST">
                    @csrf
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Close</button>
                <button type="submit" class="btn btn-primary" form="form-subscription-reinstate">Yes, Reinstate</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="modal-view" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-view-label">User Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>



@endsection

@push('scripts')
    <script src="{{ url('/js/control/template_select_user.js') }}"></script>
    <script src="{{ url('/js/control/select_existing_user.js') }}"></script>
    <script src="cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>

        $(document).on('click', '.btn-view', function(){
            //$('#form-subscription-activate').attr('action', '/control/subscriptions/activate/' + $(this).data('id'));
            $('#modal-view').modal('show');
        });

        $(document).on('click', '.btn-activate', function(){
            $('#form-subscription-activate').attr('action', '/control/subscriptions/activate/' + $(this).data('id'));
            $('#modal-activate').modal('show');
        });

        $(document).on('click', '.btn-suspend', function(){
            $('#form-subscription-suspend').attr('action', '/control/subscriptions/suspend/' + $(this).data('id'));
            $('#modal-suspend').modal('show');
        });

        $(document).on('click', '.btn-reinstate', function(){
            $('#form-subscription-reinstate').attr('action', '/control/subscriptions/reinstate/' + $(this).data('id'));
            $('#modal-reinstate').modal('show');
        });

        $(document).on('submit', '#form-subscription-activate', function(e){
            console.log('activate');
            e.preventDefault();
            $('#error-sa').hide();
            $('button[form="form-subscription-activate"]').prop('disabled', true);
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                success: function(data){
                    console.log(data);
                    if(data.success){
                        window.location.href = '{{ url("/control/subscriptions?success=") }}' + data.message;
                    }else{
                        $('button[form="form-subscription-activate"]').prop('disabled', false);
                        $('#error-sa').show().text(data.message);
                    }
                },
                error: function(data){
                    console.log(data);
                    $('button[form="form-subscription-activate"]').prop('disabled', false);
                    $('#error-sa').show().text(data.responseJSON.errors.expiration_date);
                }
            });
        });

        $(document).on('submit', '#form-subscription-suspend', function(e){
            console.log('suspend');
            e.preventDefault();
            $('button[form="form-subscription-suspend"]').prop('disabled', true);
            $('#error-ss').hide();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                success: function(data){
                    console.log(data);
                    if(data.success){
                        window.location.href = '{{ url("/control/subscriptions?success=") }}' + data.message;
                    }else{
                        $('button[form="form-subscription-suspend"]').prop('disabled', false);
                        $('#error-ss').show().text(data.responseJSON.message);
                    }
                },
                error: function(data){
                    console.log(data);
                    $('button[form="form-subscription-suspend"]').prop('disabled', false);
                    $('#error-ss').show().text(data.responseJSON.message);
                }
            });
        });

        $(document).on('submit', '#form-subscription-reinstate', function(e){
            console.log('reinstate');
            e.preventDefault();
            $('button[form="form-subscription-reinstate"]').prop('disabled', true);
            $('#error-sr').hide();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                success: function(data){
                    console.log(data);
                    if(data.success){
                        window.location.href = '{{ url("/control/subscriptions?success=") }}' + data.message;
                    }else{
                        $('button[form="form-subscription-reinstate"]').prop('disabled', false);
                        $('#error-sr').show().text(data.responseJSON.message);
                    }
                },
                error: function(data){
                    console.log(data);
                    $('button[form="form-subscription-reinstate"]').prop('disabled', false);
                    $('#error-sr').show().text(data.responseJSON.message);
                }
            });
        });

        $(document).ready(function () {
            $('#dataTables').DataTable();
            $('.dataTables_filter').addClass('pull-right');
        });

    </script>
@endpush