@extends('template.subscription')

@push('styles')
<style>
    .grid-container {
        display: grid;
        grid-template-columns: auto 44px;
    }

    h5 {
        line-height:20px;
    }
</style>
@endpush

@section('content')

<div class="container-fluid">
    <div class="row">
        <h4 class="mb-4">Choose an Accounting System</h4>
    </div>

    @foreach($accountingSystems as $account)
    <div class="row">
        <div class="card col-12 col-sm-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4 mb-2">
            <div class="card-body">
                <div class="grid-container">
                    <div>
                        <h5 class="m-0">{{ $account->name }}</h5>
                        <small class="m-0">Subscription # {{ $account->subscription_id }} | {{ $account->user_first_name . ' ' . $account->user_last_name }}</small>
                    </div>
                    <div>
                        <button class="btn btn-primary m-0 accounting_system_item" data-id="{{ $account->accounting_system_id }}">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw text-gray-400"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection

@push('scripts')
<script>
    $(document).on('click', '.accounting_system_item', function(e) {
        console.log($(this).data('id'));
        var accounting_system_id = $(this).data('id');

        $('.accounting_system_item').attr('disabled', true);

        var request = $.ajax({
            url: "/switch",
            method: "POST",
            data: {
                accounting_system_id: accounting_system_id,
                _token: "{{ csrf_token() }}",
                _method: "PUT",
            }
        });

        request.done(function(data) {
            console.log(data);
            window.location.href = "/";
        });

        request.fail(function(jqXHR, textStatus) {
            console.log(jqXHR);
        });

        request.always(function() {
            $('.accounting_system_item').attr('disabled', false);
        });
    });
</script>
@endpush