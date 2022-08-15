@extends('template.index')



@section('content')
<div class="d-sm-flex align-items-start justify-content-between mb-2">
    <h1>Accounting Periods</h1>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="container-fluid">
                <form id="form-accounting-periods" class="ajax-submit-updated" method="POST" action="{{ url('/settings/periods') }}" data-message="Successfully updated accounting periods.">
                    @csrf
                    @method('PUT')
                    @if(isset($_GET['success']))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $_GET['success'] }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <th style="width:60px">Month</th>
                                    <th style="width:180px">Date From</th>
                                    <th style="width:180px">Date To</th>
                                    <th class="d-none d-lg-block">Last Edited By</th>
                                </thead>
                                <tbody>
                                    @foreach($accounting_periods as $period)
                                        <tr>
                                            <td><p class="mt-1 mb-0">{{ $period->number }}</td>
                                            <td>
                                                <input type="date" class="form-control form-control-sm" name="date_from[]" value="{{ $period->date_from }}" @if($loop->first) readonly @endif>
                                                <small class="text-danger error-message error-message-date_from" style="display:none"></small>
                                            </td>
                                            <td>
                                                <input type="date" class="form-control form-control-sm" name="date_to[]" value="{{ $period->date_to }}" @if($loop->last) readonly @endif>
                                                <small class="text-danger error-message error-message-date_to" style="display:none"></small>
                                            </td>
                                            <td class="d-none d-lg-block">
                                                <p class="mt-1 mb-0">{{ $period->last_edited_by }} {{ \Carbon\Carbon::parse($period->updated_at)->diffForHumans() }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </form>
                <div class="row">
                    <button type="submit" form="form-accounting-periods" class="btn btn-primary col-12 col-md-6 col-lg-4 col-xl-3" id="btn-save-accounting-periods">Update Accounting Periods</button>
                </div>
            </div>
        </div>
    </div>                   
</div>
@endsection
