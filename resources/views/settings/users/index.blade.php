@extends('template.index')

@push('styles')
<style>
    .table-item-content { 
        /** Equivalent to pt-3 */
        padding-top:1rem!important;
    }

    #thead-actions {
        /** Fixed width, increase if adding addt. buttons **/
        width:120px;
    }

    input[type="checkbox"], label {
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="d-sm-flex align-items-start justify-content-between mb-2">
    <h1>Users</h1>
    <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
        <button role="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-deposit">
            <span class="icon text-white-50">
                <i class="fas fa-pen"></i>
            </span>
            <span class="text">New</span>
        </button> 
    </div>
</div>
{{-- Button Group Navigation --}}


{{-- Page Content --}}
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                <thead>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Last Logged in</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Mohammed Ahmed</th></td>
                        <td>mohammed@hmezgeb.com</td>
                        <td>
                            <button class="btn btn-info">
                                <span class="text">Super Admin</span>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-success ">
                                <span class="text">Active</span>
                            </button>
                        </td>
                        <td>
                            <p>10-Feb-2022</p>
                        </td>
                    </tr>
                    <tr>
                        <td>Kaleab Tsegaye</th></td>
                        <td>kaleab@hmezgeb.com</td>
                        <td>
                            <button class="btn btn-info">
                                <span class="text">Admin</span>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-success ">
                                <span class="text">Active</span>
                            </button>
                        </td>
                        <td>
                            <p>10-Feb-2022</p>
                        </td>
                    </tr>
                    <tr>
                        <td>Mahlet Tesfaye</th></td>
                        <td>mahlet@hmezgeb.com</td>
                        <td>
                            <button class="btn btn-danger">
                                <span class="text">User</span>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-success ">
                                <span class="text">Active</span>
                            </button>
                        </td>
                        <td>
                            <p>12-Feb-2022</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection