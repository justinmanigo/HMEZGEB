@extends('template.account')

@section('accounts_content')

<h1>Edit User Permissions</h1>

@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session()->get('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<form id="form_permissions" method="post" action="/account/users/{{ $user_id }}/permissions">
    @csrf
    @method('PUT')
    <div class="table-responsive">
        <div class="card-columns">

            @for($i = 0; $i < count($modules); $i++)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ ucwords($modules[$i]->name) }}</h5>
                    <div class="submodules">

                        @for($j = 0; $j < count($permissions[$i]); $j++)
                        <div id="submodule_{{ $permissions[$i][$j]->id }}" class="row mb-2">
                            <div class="col-8">
                                <p class="mt-2 mb-0">{{ ucwords($permissions[$i][$j]->name) }}</p>
                            </div>
                            <div class="col-4">
                                <input type="hidden" name="submodule_id[]" value="{{ $permissions[$i][$j]->id }}">
                                <select name="access_level[]" class="form-control">
                                    <option value="none" @if($permissions[$i][$j]->access_level == null) selected=selected @endif>None</option>
                                    <option value="r" @if($permissions[$i][$j]->access_level == 'r') selected=selected @endif>Read Only</option>
                                    <option value="rw" @if($permissions[$i][$j]->access_level == 'rw') selected=selected @endif>Read & Write</option>
                                </select>
                            </div>
                        </div>
                        @endfor

                    </div>
                </div>
            </div>
            @endfor

            
        </div>
    </div>

    <button type="submit" class="btn btn-primary form-control">Submit</button>
</form>

@endsection

@section('accounts_script')
{{-- <script src="js/account/update_info.js"></script> --}}
@endsection