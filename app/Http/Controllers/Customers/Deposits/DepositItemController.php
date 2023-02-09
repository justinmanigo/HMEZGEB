<?php

namespace App\Http\Controllers\Customers\Deposits;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Actions\Customer\Receipt\CreateReceiptReference;
use App\Actions\Customer\Receipt\DeterminePaymentMethod;
use App\Actions\Customer\Receipt\DetermineReceiptStatus;
use App\Actions\Customer\Receipt\StoreReceiptItems;
use App\Actions\Customer\Receipt\UpdateReceiptStatus;
use App\Actions\UpdateInventoryItemQuantity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Receipt\StoreCreditReceiptRequest;
use App\Http\Requests\Customer\Receipt\StoreProformaRequest;
use App\Mail\Customers\MailCustomerProforma;
use App\Models\CreditReceipts;
use App\Models\Customers;
use App\Models\Proformas;
use App\Models\ReceiptCashTransactions;
use App\Models\ReceiptItem;
use App\Models\ReceiptReferences;
use App\Models\AdvanceRevenues;
use App\Models\Receipts;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Customers\MailCustomerCreditReceipt;
use App\Http\Requests\Customer\Receipt\StoreAdvanceRevenueRequest;
use App\Http\Requests\Customer\Receipt\StoreReceiptRequest;
use App\Mail\Customers\MailCustomerAdvanceRevenue;
use App\Mail\Customers\MailCustomerReceipt;
use App\Models\BankAccounts;
use App\Models\DepositItems;
use App\Models\Deposits;
use App\Models\Inventory;
use App\Models\Notification;
use App\Models\Transactions;

class DepositItemController extends Controller
{
    /**
     * TODO: Implement function
     */
    public function show(DepositItems $item)
    {

    }

    public function void(DepositItems $item)
    {
        // If the deposit is a direct deposit, mark the receipt reference as void.
        if($item->deposit->is_direct_deposit == true) {
            $item->receiptCashTransaction->receiptReference->is_void = true;
            $item->receiptCashTransaction->receiptReference->save();
        }

        $item->is_void = true;
        $item->save();

        $item->journalEntry->is_void = true;
        $item->journalEntry->save();

        return redirect()->back()->with('success', 'Deposit item successfully marked void.');
    }

    public function reactivate(DepositItems $item)
    {
        $item->receiptCashTransaction;
        
        // If the deposit is a direct deposit, reactivate the receipt reference.
        if($item->deposit->is_direct_deposit == true) {
            $item->receiptCashTransaction->receiptReference->is_void = false;
            $item->receiptCashTransaction->receiptReference->save();
        }

        // Check if the receipt reference it originated was marked void.
        // If so, return an error. Otherwise, reactive the deposit item.
        else if($item->receiptCashTransaction->receiptReference->is_void) {
            return redirect()->back()->with('error', 'Cannot reactivate deposit item. The receipt reference it originated was marked void.');
        }

        
        

        $item->is_void = false;
        $item->save();
        $item->journalEntry->is_void = false;
        $item->journalEntry->save();

        return redirect()->back()->with('success', 'Deposit item successfully reactivated.');
    }

    /**
     * TODO: Implement function
     */
    public function mail(DepositItems $item)
    {

    }

    /**
     * TODO: Implement function
     */
    public function print(DepositItems $item)
    {

    }
}