@extends('template.index')

@push('styles')
<style>
    .table-employee-content { 
        /** Equivalent to pt-3 */
        padding-top:1rem!important;
    }

    #thead-actions {
        /** Fixed width, increase if adding addt. buttons **/
        width:120px;
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
    <button type="button" class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-deduction">
        <span class="icon text-white-50">
            <i class="fas fa-pen"></i>
        </span>
        <span class="text">New</span>
    </button>   
</div>
{{-- Page Content --}}
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
        @if(session()->has('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session()->get('danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">    
                <thead>
                    <th>Date</th>
                    <th>Employee Name</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th id="thead-actions">Actions</th>
                </thead>
                <tbody>
                    @foreach($deductions as $deduction)
                    <tr>
                        <td>{{ $deduction->date }}</td>
                        <td>{{ $deduction->first_name }}</td>
                        <td>{{ $deduction->type }}</td>
                        <td>{{ $deduction->price }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="tooltip"
                                    data-placement="bottom" title="Edit">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-pen"></i>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-danger "
                                onClick='showModel({!! $deduction->id !!})'>
                                <span class="icon text-white-50">
                                    <i class="fas fa-trash"></i>
                                </span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Deduction Modal --}}
<div class="modal fade" id="modal-deduction" tabindex="-1" role="dialog" aria-labelledby="modal-deduction-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-deduction-label">New Deduction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{route('deductions.deduction.store')}}" class="ajax-submit-updated" enctype="multipart/form-data"  id="form-deduction" method="POST" data-message="Successfully added deductions.">
                    @csrf
                    <div class="form-group row">
                        <label for="d_date" class="col-sm-3 col-lg-2 col-form-label">Date<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="date" class="form-control" id="d_date" name="date" placeholder="" value="{{date('Y-m-d')}}">
                            <p class="text-danger error-message error-message-date" style="display:none"></p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                            <thead>
                              
                                <th>Employee Name</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </thead>
                            <tbody id="d_entries">
                               {{-- <tr>
                                    <td>
                                    <input class="col-8 col-lg-7" id="d_employee" name='employee'>
                                        <input type="hidden" id="d_employee_id" name="employee_id" value="">

                                    </td>
                                    <td>
                                        <input type="text" class="form-control text-right" name="price[]" placeholder="0.00" required>
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
                            <label for="d_description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                            <div class="col-sm-9 col-lg-10">
                                <textarea class="form-control" id="d_description" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-deduction">Save Deduction</button>
            </div>
        </div>
    </div>
</div>
{{-- Delete Deduction --}}
<div class="modal fade" id="deleteConfirmationModel" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-customer-label">Delete Deduction</h5>
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
        frmDelete.action = 'deduction/'+id;
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
<script src="/js/human_resource/select_employee_deduction.js"></script>
@endsection