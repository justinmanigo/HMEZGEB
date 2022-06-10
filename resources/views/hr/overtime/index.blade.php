@extends('template.index')

@push('styles')
<style>
    .table-employee-content {
        /** Equivalent to pt-3 */
        padding-top: 1rem !important;
    }

    #thead-actions {
        /** Fixed width, increase if adding addt. buttons **/
        width: 120px;
    }


    /*
            TEMPORARY
        */
    /* Suggestions items */
    .tagify__dropdown.employees-list .tagify__dropdown__item {
        padding: .5em .7em;
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 0 1em;
        grid-template-areas: "avatar name"
            "avatar email";
    }

    .tagify__dropdown.employees-list .tagify__dropdown__item:hover .tagify__dropdown__item__avatar-wrap {
        transform: scale(1.2);
    }

    .tagify__dropdown.employees-list .tagify__dropdown__item__avatar-wrap {
        grid-area: avatar;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        overflow: hidden;
        background: #EEE;
        transition: .1s ease-out;
    }

    .tagify__dropdown.employees-list strong {
        grid-area: name;
        width: 100%;
        align-self: center;
    }

    .tagify__dropdown.employees-list span {
        grid-area: email;
        width: 100%;
        font-size: .9em;
        opacity: .6;
    }

    .tagify__dropdown.employees-list .addAll {
        border-bottom: 1px solid #DDD;
        gap: 0;
    }


    /* Tags items */
    .tagify__tag {
        white-space: nowrap;
    }

    .tagify__tag:hover .tagify__tag__avatar-wrap {
        transform: scale(1.6) translateX(-10%);
    }

    .tagify__tag .tagify__tag__avatar-wrap {
        width: 16px;
        height: 16px;
        white-space: normal;
        border-radius: 50%;
        background: silver;
        margin-right: 5px;
        transition: .12s ease-out;
    }
</style>

<script src="https://unpkg.com/@yaireo/tagify"></script>
<script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />

@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
@endpush

@section('content')

{{-- Button Group Navigation --}}
<div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
    <button type="button" class="btn btn-primary" href="javascript:void(0)" data-toggle="modal"
        data-target="#modal-overtime">
        <span class="icon text-white-50">
            <i class="fas fa-pen"></i>
        </span>
        <span class="text">New</span>
    </button>
</div>
@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session()->get('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if(session()->has('danger'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session()->get('danger') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
{{-- Page Content --}}
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                <thead>
                    <th id="thead-actions">Actions</th>
                    <th>Date</th>
                    <th>Employee Name</th>
                    <th>Type</th>
                    <th>Price</th>
                </thead>
                <tbody>
                    @foreach ($overtimes as $overtime)
                    <tr>
                        <td>
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="tooltip"
                                    data-placement="bottom" title="Edit">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-pen"></i>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-danger "
                                onClick='showModel({!! $overtime->id !!})'>
                                <span class="icon text-white-50">
                                    <i class="fas fa-trash"></i>
                                </span>
                                </button>
                            </div>
                        </td>
                        <td>{{ $overtime->date }}</td>
                        <td>{{ $overtime->first_name }}</td>
                        <td>{{ $overtime->type }}</td>
                        <td>{{ $overtime->price }}</td>
                    </tr>
                    @endforeach
                    </tr> 
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Deduction Modal --}}
<div class="modal fade" id="modal-overtime" tabindex="-1" role="dialog" aria-labelledby="modal-overtime-label"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-overtime-label">New Overtime</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{route('overtime.store')}}" id="form-overtime" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-8 d-flex">
                            <label for="o_date col-6" >Date<span
                                    class="text-danger ml-1">*</span></label>
                                <input type="date" class="form-control col-8 ml-3" id="o_date" name="date" placeholder="" value="{{date('Y-m-d')}}" required>
                        </div>
                        <div class="col-md-4">
                            <input class="form-check-input" type="checkbox" name="is_weekend_holiday" id="weekend_holiday" value="yes">
                            <label class="form-check-label" for="weekend_holiday">
                                Weekend/Holiday
                            </label>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                            <thead>

                                <th>Employee Name</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Actions</th>
                            </thead>
                            <tbody id="ot_entries">
                                {{-- <tr>
                                    <td>

                                        <input class="col-8 col-lg-7" id="ot_employee" name='employee'>
                                        <input type="hidden" id="ot_employee_id" name="employee_id" value="">

                                    </td>
                                    <td>
                                        <input type="time" class="form-control text-right" name="from[]" required>
                                    </td>
                                    <td>
                                        <input type="time" class="form-control text-right" name="to[]" required>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-icon btn-danger" data-toggle="tooltip"
                                            data-placement="bottom" title="Delete">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-small btn-icon btn-primary"
                                            data-toggle="tooltip" data-placement="bottom" title="Edit">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-plus"></i>
                                            </span>
                                        </button>
                                    </td>
                                </tr>--}}

                            </tbody>
                        </table>

                        <div class="form-group row">
                            <label for="o_description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                            <div class="col-sm-9 col-lg-10">
                                <textarea class="form-control" id="o_description" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-overtime">Save Overtime</button>
            </div>
        </div>
    </div>
</div>
{{-- Delete Overtime --}}
<div class="modal fade" id="deleteConfirmationModel" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-customer-label">Delete Overtime</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
			<div class="modal-body">Are you sure to delete this record?</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" onClick="dismissModel()">Cancel</button>
				<form id="delete-frm" class="" action="" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger">Delete</button>
                </form>
			</div>
		</div>
	</div>
</div>

<script>
    var controller;
    $(document).ready(function() {
        $('#dataTables').DataTable();
        $('.dataTables_filter').addClass('pull-right');
    });
    function showModel(id) {
        var frmDelete = document.getElementById("delete-frm");
        frmDelete.action = 'overtime/'+id;
        var confirmationModal = document.getElementById("deleteConfirmationModel");
        confirmationModal.style.display = 'block';
        confirmationModal.classList.remove('fade');
        confirmationModal.classList.add('show');
    }
    
    function dismissModel() {
        var confirmationModal = document.getElementById("deleteConfirmationModel");
        confirmationModal.style.display = 'none';
        confirmationModal.classList.remove('show');
        confirmationModal.classList.add('fade');
    }
</script>


<script src="/js/human_resource/template_select_employee.js"></script>
<script src="/js/human_resource/select_employee_overtime.js"></script>
@endsection