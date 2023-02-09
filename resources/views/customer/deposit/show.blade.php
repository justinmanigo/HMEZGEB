@extends('template.index')

@section('content')
{{-- Button Group Navigation --}}
<div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
    <a href="{{ url('/customers/deposits') }}" role="button" class="btn btn-secondary">
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
                <td><strong>{{ $deposit->deposit_ticket_date }}</strong></td>
            </tr>
            <tr>
                <td>Bank Account</td>
                <td><strong>{{ $deposit->chartOfAccount->chart_of_account_no }} - {{ $deposit->chartOfAccount->account_name }}</strong></td>
            </tr>
            <tr>
                <td>Reference Number</td>
                <td><strong>{{ $deposit->reference_number }}</strong></td>
            </tr>
            <tr>
                <td>Remark</td>
                <td><strong>{{ $deposit->remark }}</strong></td>
            </tr>
        </table>

        <h2>Deposited Transactions</h2>
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <th>Receipt Ref. ID</th>
                    <th>Description</th>
                    <th class="text-right">Amount</th>
                    <th style="width:168px">Actions</th>
                </thead>
                <tbody>
                    @foreach($deposit->depositItems as $item)
                    <tr>
                        <td>
                            {{ $item->receiptCashTransaction->receipt_reference_id }}
                        </td>
                        <td>
                            @if($item->receiptCashTransaction->receiptReference->type == 'receipt')
                                Receipt for <b>{{ $item->receiptCashTransaction->receiptReference->customer->name }}</b>
                            @elseif($item->receiptCashTransaction->receiptReference->type == 'advance_revenue')
                                Advance Revenue for <b>{{ $item->receiptCashTransaction->receiptReference->customer->name }}</b>
                            @elseif($item->receiptCashTransaction->receiptReference->type == 'credit_receipt')
                                Credit Receipt for <b>{{ $item->receiptCashTransaction->receiptReference->customer->name }}</b>
                            @else
                                Sale
                            @endif
                        </td>
                        <td class="text-right">
                            Birr {{ number_format($item->receiptCashTransaction->amount_received, 2) }}
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm disabled">
                                <span class="icon text-white-50">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-secondary btn-sm disabled">
                                <span class="icon text-white-50">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </a>
                            <button class="btn btn-secondary btn-sm" disabled>
                                <span class="icon text-white-50">
                                    <i class="fas fa-print"></i>
                                </span>
                            </button>
                            @if(!$item->is_void)
                                <!-- void -->
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-void-confirmation" disabled onclick="voidModal({{$item->id}}, 'depositItem')">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-ban"></i>
                                    </span>
                                </button>
                            @else
                                <!-- make it active -->
                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-reactivate-confirmation" disabled onclick="reactivateModal({{$item->id}}, 'depositItem')">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-check"></i>
                                    </span>
                                </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tbody>
                    <tr>
                        <td colspan="2" class="text-right">Total Amount</td>
                        <td class="text-right">Birr {{ number_format($total_amount, 2) }}</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Marked Void</td>
                        <td class="text-right text-danger">Birr {{ number_format($total_void_amount, 2) }}</td>
                        <td class="text-right"></td>
                    </tr>
                </tbody>
                <tfoot>
                    <th colspan="2" class="text-right">Current Amount</th>
                    <th class="text-right">Birr {{ number_format($total_amount - $total_void_amount, 2) }}</th>
                    <th class="text-right"></th>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
