@extends('template.index')

@push('styles')

@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
@endpush

@section('content')
<div class="d-sm-flex align-items-start justify-content-between mb-2">
    <h1>Withholding</h1>
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-withholding" onclick="initCreateWithholding()">
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
        {{-- <button type="button" class="btn btn-secondary">
            <span class="icon text-white-50">
                <i class="fas fa-download"></i>
            </span>
            <span class="text">Download Excel Format</span>
        </button> --}}
    </div>  
</div>
<div class="card">
    {{-- success error --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered"  width="100%" cellspacing="0">
                <thead>
                    <th>Serial No.</th>
                    <th>Name</th>
                    <th class="text-right">Withholding Amount in %</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach($withholdings as $withholding)
                    <tr>
                        <td>{{ $withholding->id }}</th></td>
                        <td>{{ $withholding->name }}</td>
                        <td class="text-right">{{ number_format($withholding->percentage, 2) }}%</td>
                        <td>
                            <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="modal" data-target="#modal-withholding" onclick="initEditWithholding({{ $withholding->id }})">
                                <span class="icon text-white-50">
                                    <i class="fas fa-pen"></i>
                                </span>
                            </button>
                            <button type="button" class="btn btn-small btn-icon btn-danger" data-toggle="modal" data-target="#modal-withholding-delete" onclick="initDeleteWithholding({{ $withholding->id }})">
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
{{-- New Withholding --}}
<div class="modal fade" id="modal-withholding" tabindex="-1" role="dialog" aria-labelledby="modal-withholding-label" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-withholding-label">New Withholding</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-withholding-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form-withholding" method="post" action="{{ route('settings.withholding.store') }}">
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
                <button type="submit" class="btn btn-primary" id="t_submit_btn" form="form-withholding">Save Withholding</button>
            </div>
        </div>
    </div>
</div>

{{--  Delete Modal --}}
<div class="modal fade" id="modal-withholding-delete" tabindex="-1" role="dialog" aria-labelledby="Modal Delete Withholding">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-customer-label">Delete Withholding</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure to delete this record?
                <form id="form-withholding-delete" class="" action="" method="POST">
                    @method('DELETE')
                    @csrf
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger" form="form-withholding-delete">Delete Withholding</button>
            </div>
        </div>
    </div>
</div>

{{-- Import Modal --}}
<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="Modal Import Withholding">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-customer-label">Import Withholding</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-import-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form-import" method="post" action="{{ route('settings.withholding.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row container">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" name="file">
                            <label class="custom-file-label" for="file">Choose file</label>
                          </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="i_submit_btn" form="form-import">Import Withholding</button>
            </div>
        </div>
    </div>
</div>

{{-- Export Modal CSV or PDF--}}

<div class="modal fade" id="modal-export" tabindex="-1" role="dialog" aria-labelledby="Modal Export Withholding">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-customer-label">Export Withholding</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-export-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form-export" method="post" action="{{ route('settings.withholding.export') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="e_type" class="col-12 col-lg-6 col-form-label">Type<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <select class="form-control" id="e_type" name="type" required>
                                <option value="csv">CSV</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="e_submit_btn" form="form-export">Export Withholding</button>
            </div>
        </div>
    </div>
</div>

<script>
    // $(document).ready(function () {
    //     $('#dataTables').DataTable();
    //     $('.dataTables_filter').addClass('pull-right');
    // });
   
    // add the file name only in file input field
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    function initEditWithholding(id)
    {
        $("#form-withholding").hide();
        $("#modal-withholding-spinner").show();
        $("#t_http_method").val("PUT");
        $("#form-withholding").attr("action", "/settings/withholding/" + id)
        $("#t_submit_btn").html("Update Withholding").attr("disabled", 'disabled');
        $("#modal-withholding-label").html("Edit Withholding");
        
        // Get data from server.
        var request = $.ajax({
            url: "/ajax/settings/withholding/get/" + id,
            method: "GET",
        });
            
        request.done(function(res, status, jqXHR ) {
            $("#form-withholding").show();
            $("#modal-withholding-spinner").hide();
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

    function initCreateWithholding()
    {
        $("#t_http_method").val("POST");
        $("#form-withholding").attr("action", "{{ route('settings.withholding.store') }}")
        $("#t_submit_btn").html("Save Withholding");
        $("#modal-withholding-label").html("New Withholding");

        $("#t_name").val("");
        $("#t_percentage").val("");
        $("#t_submit_btn").removeAttr("disabled");
    }

    function initDeleteWithholding(id)
    {
        $("#form-withholding-delete").attr("action", "/settings/withholding/" + id);
    }

</script>
@endsection
