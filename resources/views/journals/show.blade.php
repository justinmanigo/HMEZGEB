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
{{-- Button Group Navigation --}}
<div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
    <a href="{{ route('journals.index') }}" role="button" class="btn btn-secondary">
        <span class="icon text-white-50">
            <i class="fas fa-pen"></i>
        </span>
        <span class="text">Back</span>
    </a> 
</div>

{{-- Page Content --}}
<div class="card">
    <div class="card-body">
        <table class="table table-borderless table-sm">
            <tr>
                <td style="width:200px">Date</td>
                <td><strong>{{ $journalVoucher->journalEntry->date }}</strong></td>
            </tr>
            <tr>
                <td>Reference Number</td>
                <td><strong>{{ $journalVoucher->id }}</strong></td>
            </tr>
            <tr>
                <td>Notes</td>
                <td><strong>{{ $journalVoucher->journalEntry->notes }}</strong></td>
            </tr>
        </table>

        
        
        
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <th>Account No. & Name</th>
                    <th>Description</th>
                    <th class="text-right">Debit</th>
                    <th class="text-right">Credit</th>
                </thead>
                <tbody>
                    @foreach($journalVoucher->journalEntry->journalPostings as $posting)
                    <tr>
                        <td>
                            {{ $posting->chartOfAccount->chart_of_account_no . ' - ' . $posting->chartOfAccount->account_name }}
                        </td>
                        <td>
                            {{ $posting->description }}
                        </td>
                        {{-- debit --}}
                        @if($posting->type == 'debit')
                        <td class="text-right">
                            {{ number_format($posting->amount, 2) }}
                        </td>
                        <td></td>
                        @elseif($posting->type == 'credit')
                        {{-- credit --}}
                        <td></td>
                        <td class="text-right">
                            {{ number_format($posting->amount, 2) }}
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <th colspan="2" class="text-right">Total</th>
                    <th class="text-right">{{ number_format($totalDebit, 2) }}</th>
                    <th class="text-right">{{ number_format($totalCredit, 2) }}</th>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection