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
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tax">
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
                    <th>S. No</th>
                    <th>Description</th>
                    <th>Tax Amount in %</th>
                </thead>
                <tbody>
                    <tr>
                        <td>1.</th></td>
                        <td>Tax Amount in %</td>
                        <td> 0.00%</td>
                    </tr>
                    <tr>
                        <td>2.</th></td>
                        <td>TOT</td>
                        <td> 2.00%</td>
                    </tr>
                    <tr>
                        <td>3.</th></td>
                        <td>VAT</td>
                        <td> 15.00%</td>
                    </tr>
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
                <form id="form-tax" method="post" action="{{ route('settings.store') }}">
                    @csrf
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
                <button type="submit" class="btn btn-primary" form="form-tax">Save Tax</button>
            </div>
        </div>
    </div>
</div>

<script>
        $(document).ready(function () {
            $('#dataTables').DataTable();
            $('.dataTables_filter').addClass('pull-right');
        });
</script>
@endsection
