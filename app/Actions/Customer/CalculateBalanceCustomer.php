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
        $customer_count = 0;
        
        if($customer){
        $customer_count++;

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
            }
        }
 
        return ['balance' => $balance, 'customer_count' => $customer_count];
        }
        else{
            return ['balance' => $balance, 'customer_count' => $customer_count];
        }
    }
}