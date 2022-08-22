<?php

namespace App\Actions\Vendor;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\Vendors;
use App\Models\Bills;
use App\Models\PaymentReferences;


class CalculateBalanceVendor
{
    use AsAction;

    public function handle($id)
    {
        $vendor = Vendors::where('id', $id)
        ->whereHas('PaymentReferences', function($query) {
            $query->where('type', 'bill')
            ->where(function ($query) {
                $query->where('status', 'unpaid')
                  ->orWhere('status', 'partially_paid');
              });})->first();

        $balance = 0;
        $total_balance = 0;
        $total_balance_overdue = 0;
        // count receipt
        $count = 0;
        $count_overdue = 0;
        
        if($vendor){
        $payment_references = PaymentReferences::where('vendor_id', $vendor->id)
        ->where('type', 'bill')
        ->where(function ($query) {
            $query->where('status', 'unpaid')
              ->orWhere('status', 'partially_paid');
          })->get(); 

        foreach ($payment_references as $payment_reference) {
            $bills = Bills::where('payment_reference_id', $payment_reference->id)
            ->get();
            foreach($bills as $bill){
                $balance += $bill->grand_total-$bill->amount_received;
                if($bill->due_date > date('Y-m-d')){
                    $total_balance += $bill->grand_total-$bill->amount_received;
                    $count++;
                }
                else {
                    $total_balance_overdue += $bill->grand_total-$bill->amount_received;
                    $count_overdue++;
                }
            }
        }
        return ['balance' => $balance, 'count' => $count , 'total_balance' => $total_balance, 'total_balance_overdue' => $total_balance_overdue, 'count_overdue' => $count_overdue];
        }
        else {
            return ['balance' => $balance, 'count' => $count , 'total_balance' => $total_balance, 'total_balance_overdue' => $total_balance_overdue, 'count_overdue' => $count_overdue];
        }
    }
}
