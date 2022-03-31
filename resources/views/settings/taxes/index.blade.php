@extends('template.index')

@push('styles')

@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
@endpush

@section('content')
<div class="d-sm-flex align-items-start justify-content-between mb-2">
    <h1>Taxes</h1>
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tax" onclick="initCreateTax()">
            <span class="icon text-white-50">
                <i class="fas fa-file-import"></i>
            </span>
            <span class="text">New</span>
        </button>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-import">
            <span class="icon text-white-50">
                <i class="fas fa-file-import"></i>
            </span>
            <span class="text">Import</span>
        </button>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-export">
            <span class="icon text-white-50">
                <i class="fas fa-download"></i>
            </span>
            <span class="text">Export</span>
        </button>
        <button type="button" class="btn btn-secondary">
            <span class="icon text-white-50">
                <i class="fas fa-download"></i>
            </span>
            <span class="text">Download Excel Format</span>
        </button>
    </div>  
</div>
<div class="card">
    <div class="card-body">
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered"  width="100%" cellspacing="0">
                <thead>
                    <th>Serial No.</th>
                    <th>Name</th>
                    <th class="text-right">Tax Amount in %</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach($taxes as $tax)
                    <tr>
                        <td>{{ $tax->id }}</th></td>
                        <td>{{ $tax->name }}</td>
                        <td class="text-right">{{ number_format($tax->percentage, 2) }}%</td>
                        <td>
                            <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="modal" data-target="#modal-tax" onclick="initEditTax({{ $tax->id }})">
                                <span class="icon text-white-50">
                                    <i class="fas fa-pen"></i>
                                </span>
                            </button>
                            <button type="button" class="btn btn-small btn-icon btn-danger" data-toggle="modal" data-target="#modal-tax-delete" onclick="initDeleteTax({{ $tax->id }})">
                                <span class="icon text-white-50">
                                    <i class="fas fa-trash"></i>
                                </span>
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
{{-- New Tax --}}
<div class="modal fade" id="modal-tax" tabindex="-1" role="dialog" aria-labelledby="modal-tax-label" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-tax-label">New Tax</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-tax-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form-tax" method="post" action="{{ route('settings.store') }}">
                    @csrf
                    <input type="hidden" id="t_http_method" name="_method" value="POST">
                    <div class="form-group row">
                        <label for="t_name" class="col-12 col-lg-6 col-form-label">Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="text" class="form-control" id="t_name" name="name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="t_percentage" class="col-12 col-lg-6 col-form-label">Percentage<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="number" step="0.01" class="form-control" id="t_percentage" name="percentage" placeholder="0.00">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="t_submit_btn" form="form-tax">Save Tax</button>
            </div>
        </div>
    </div>
</div>

{{--  Delete Modal --}}
<div class="modal fade" id="modal-tax-delete" tabindex="-1" role="dialog" aria-labelledby="Modal Delete Tax">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-customer-label">Delete Tax</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure to delete this record?
                <form id="form-tax-delete" class="" action="" method="POST">
                    @method('DELETE')
                    @csrf
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger" form="form-tax-delete">Delete Tax</button>
            </div>
        </div>
    </div>
</div>

<script>
    // $(document).ready(function () {
    //     $('#dataTables').DataTable();
    //     $('.dataTables_filter').addClass('pull-right');
    // });

    function initEditTax(id)
    {
        $("#form-tax").hide();
        $("#modal-tax-spinner").show();
        $("#t_http_method").val("PUT");
        $("#form-tax").attr("action", "/settings/taxes/" + id)
        $("#t_submit_btn").html("Update Tax").attr("disabled", 'disabled');
        $("#modal-tax-label").html("Edit Tax");
        
        // Get data from server.
        var request = $.ajax({
            url: "/ajax/settings/taxes/get/" + id,
            method: "GET",
        });
            
        request.done(function(res, status, jqXHR ) {
            $("#form-tax").show();
            $("#modal-tax-spinner").hide();
            $("#t_submit_btn").removeAttr("disabled");

            console.log("Request successful.");
            console.log(res);
            $("#t_name").val(res.name);
            $("#t_percentage").val(res.percentage);
        });
        
        request.fail(function(jqXHR, status, error) {
            console.log("Request failed.");
        });

    }

    function initCreateTax()
    {
        $("#t_http_method").val("POST");
        $("#form-tax").attr("action", "{{ route('settings.store') }}")
        $("#t_submit_btn").html("Save Tax");
        $("#modal-tax-label").html("New Tax");

        $("#t_name").val("");
        $("#t_percentage").val("");
        $("#t_submit_btn").removeAttr("disabled");
    }

    function initDeleteTax(id)
    {
        $("#form-tax-delete").attr("action", "/settings/taxes/" + id);
    }

</script>
@endsection
