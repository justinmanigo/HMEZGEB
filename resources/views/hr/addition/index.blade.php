@extends('template.index')

@section('content')

{{-- Button Group Navigation --}}
<div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
    <button type="button" class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-addition">
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
                    @foreach($additions as $addition)
                    <tr>
                        <td class="table-employee-content">{{ $addition->date }}</td>
                        <td class="table-employee-content">{{ $addition->first_name }}</td>
                        <td class="table-employee-content"><span class="badge badge-secondary">{{ $addition->type }}</span></td>
                        <td class="table-employee-content">{{ $addition->price }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="tooltip"
                                    data-placement="bottom" title="Edit">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-pen"></i>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-danger "
                                onClick='showModel({!! $addition->id !!})'>
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

{{-- Addition Modal --}}
<div class="modal fade" id="modal-addition" tabindex="-1" role="dialog" aria-labelledby="modal-addition-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-addition-label">New Addition</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{route('additions.addition.store')}}" class="ajax-submit-updated" enctype="multipart/form-data" id="form-addition" method="POST" data-message="Successfully added additions.">
                    @csrf
                    <div class="form-group row">
                        <label for="a_date" class="col-sm-3 col-lg-2 col-form-label">Date<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-9 col-lg-4">
                            <input type="date" class="form-control" id="a_date" name="date" placeholder="" value="{{date('Y-m-d')}}" >
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
                            <tbody id="a_entries">
                                {{--<tr>
                                    <td>
                                        <input class="col-8 col-lg-7" id="a_employee" name='employee'>
                                        <input type="hidden" id="a_employee_id" name="employee_id" value="">

                                    </td>
                                    <td>
                                        <input type="text" class="form-control text-right" name="price[]" placeholder="0.00" >
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
                            <label for="a_description" class="col-sm-3 col-lg-2 col-form-label">Description</label>
                            <div class="col-sm-9 col-lg-10">
                                <textarea class="form-control" id="a_description" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-addition">Save Addition</button>
            </div>
        </div>
    </div>
</div>
{{-- Delete Modal --}}
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
        frmDelete.action = 'addition/'+id;
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
<script src="/js/human_resource/select_employee_addition.js"></script>
@endsection
