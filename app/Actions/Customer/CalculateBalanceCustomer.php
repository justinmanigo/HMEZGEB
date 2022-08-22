<?php

namespace App\Actions\Customer;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\Customers;
use App\Models\Receipts;
use App\Models\ReceiptReferences;

class CalculateBalanceCustomer
{
    use AsAction;

    public function handle($id)
    {
        $customer = Customers::where('id', $id)
        ->whereHas('receiptReference', function($query) {
            $query->where('type', 'receipt')
            ->where(function ($query) {
                $query->where('status', 'unpaid')
                  ->orWhere('status', 'partially_paid');
              });})->first();

        $balance = 0;
        $total_balance = 0;
        $total_balance_past = 0;
        // count receipt
        $count = 0;
        $count_overdue = 0;
        
        if($customer){
        $receipt_references = ReceiptReferences::where('customer_id', $customer->id)
        ->where('type', 'receipt')
        ->where(function ($query) {
            $query->where('status', 'unpaid')
              ->orWhere('status', 'partially_paid');
          })->get(); 

        foreach ($receipt_references as $receipt_reference) {
            $receipts = Receipts::where('receipt_reference_id', $receipt_reference->id)
            ->get();
            foreach($receipts as $receipt){
                $balance += $receipt->grand_total-$receipt->total_amount_received;
                if($receipt->due_date > date('Y-m-d')){
                    $total_balance += $receipt->grand_total-$receipt->total_amount_received;
                    $count++;
                }
                else {
                    $total_balance_past += $receipt->grand_total-$receipt->total_amount_received;
                    $count_overdue++;
                }
            }
        }
 
        return ['balance' => $balance, 'count' => $count , 'total_balance' => $total_balance, 'total_balance_past' => $total_balance_past, 'count_overdue' => $count_overdue];
        }
        else {
            return ['balance' => $balance, 'count' => $count , 'total_balance' => $total_balance, 'total_balance_past' => $total_balance_past, 'count_overdue' => $count_overdue];
        }
    }
}