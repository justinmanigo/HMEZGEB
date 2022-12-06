<?php

namespace App\Http\Controllers\Vendors\Bills;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Actions\UpdateInventoryItemQuantity;
use App\Actions\Vendor\Bill\UpdateBillStatus;
use App\Actions\Vendor\Bill\StoreBillItems;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendors\Bills\StoreBillRequest;
use App\Mail\Vendors\MailVendorBill;
use App\Models\Inventory;
use App\Models\PaymentReferences;
use App\Models\Bills;
use App\Models\BillItem;
use App\Models\Vendors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDF;


class BillController extends Controller
{

    /** MAIN FUNCTIONS */

    /**
     * Stores a new entry.
     */
    public function store(StoreBillRequest $request)
    {
        // If this transaction is linked to Proforma
        if(isset($request->purchase_order)) UpdateBillStatus::run($request->purchase_order->value, 'paid');

        // Determine bill status.
        if($request->grand_total == $request->total_amount_received)
            $status = 'paid';
        else if($request->total_amount_received == 0)
            $status = 'unpaid';
        else
            $status = 'partially_paid';

        // Create BillReference Record
        $reference = PaymentReferences::create([
            'accounting_system_id' => session('accounting_system_id'),
            'vendor_id' => $request->vendor->value,
            'date' => $request->date,
            'type' => 'bill',
            'attachment' => $request->attachment,
            'remark' => $request->remark,
            'status' => $status
        ]);

        // If request has attachment, store it to file storage.
        // if($request->attachment) {
        //     $fileAttachment = time().'.'.$request->attachment->extension();
        //     $request->attachment->storeAs('public/bill-attachment'/'bill', $fileAttachment);
        // }

        // Create child database entry
        if($request->grand_total == $request->total_amount_received)
            $payment_method = 'cash';
        else
            $payment_method = 'credit';

        UpdateInventoryItemQuantity::run($request->item, $request->quantity, 'increase');
        StoreBillitems::run($request->item, $request->quantity, $reference->id);

        // Create Journal Entry
        $je = CreateJournalEntry::run($request->date, $request->remark, session('accounting_system_id'));
        // TODO: Link Bills to Journal Entry (later for Void)
        // $reference->journal_entry_id = $je->id;
        // $reference->save();

        $cash_on_hand = $request->total_amount_received;
        $account_payable = $request->grand_total - $request->total_amount_received;
        $sales = $request->sub_total;

        // Create Debit Postings
        $debit_accounts[] = CreateJournalPostings::encodeAccount($request->bill_items_for_sale);
        $debit_amount[] = $sales;

        // This checks whether to add debit_amount tax posting
        if($request->tax_total > 0) {
            $debit_accounts[] = CreateJournalPostings::encodeAccount($request->bill_vat_receivable);
            $debit_amount[] = $request->tax_total;
        }

        // Create Credit Postings

        // Check if there is withholding
        if($request->withholding_check != null) {
            $cash_on_hand -= $request->withholding;

            $credit_accounts[] = CreateJournalPostings::encodeAccount($request->bill_withholding);
            $credit_amount[] = $request->withholding;

            if($cash_on_hand < 0) {
                $account_payable += $cash_on_hand;
            }
        }

        // This determines which is which to include in credit postings
        if($status == 'paid' || $status == 'partially_paid') {
            $credit_accounts[] = CreateJournalPostings::encodeAccount($request->cash_account->value);
            $credit_amount[] = $cash_on_hand;
        }
        if($status == 'partially_paid' || $status == 'unpaid') {
            $credit_accounts[] = CreateJournalPostings::encodeAccount($request->bill_account_payable);
            $credit_amount[] = $account_payable;
        }


        CreateJournalPostings::run($je,
            $debit_accounts, $debit_amount,
            $credit_accounts, $credit_amount,
            session('accounting_system_id'));

        Bills::create([
            'payment_reference_id' => $reference->id,
            // 'withholding_payment_id' => '0', // temporary
            'purchase_order_id' => isset($request->purchase_order) ? $request->purchase_order->value : null,
            'due_date' => $request->due_date,
            'chart_of_account_id' => $request->chart_of_account_id,
            'sub_total' => $request->sub_total,
            'discount' => '0', // temporary
            'tax' => $request->tax_total,
            'grand_total' => $request->grand_total,
            'withholding' => $request->withholding_check ? $request->withholding : 0,
            'withholding_status' => 'paid', // temporary
            'payment_method' => $payment_method,
            'amount_received' => $request->total_amount_received,
        ]);

        return [
            'debit_accounts' => $debit_accounts,
            'debit_amount' => $debit_amount,
            'credit_accounts' => $credit_accounts,
            'credit_amount' => $credit_amount,
        ];
    }

    /**
     * Shows a specific entry.
     */
    public function show(Bills $bills)
    {
        return view('vendors.bills.show');
    }

    /**
     * TODO: Test this function.
     * Marks an entry as void.
     */
    public function void($id)
    {
        $bill = Bills::find($id);
        // if($bill->paymentReference->is_deposited == "yes")
        // return redirect()->back()->with('danger', "Error voiding! This transaction is already deposited.");

        // TODO: Deactivate connected modules (Add inventory, adjust Journal entry/postings).
        $bill->paymentReference->is_void = "yes";
        $bill->paymentReference->save();

        return redirect()->back()->with('success', "Successfully voided bill.");
    }

    /**
     * TODO: Test this function.
     * Reverses a voided entry.
     */
    public function revalidate($id)
    {
        $bill = Bills::find($id);
        // TODO: Revalidate connected modules (Deduct inventory, adjust Journal entry/postings).
        $bill->paymentReference->is_void = "no";
        $bill->paymentReference->save();

        return redirect()->back()->with('success', "Successfully revalidated bill.");
    }

    /**
     * TODO: Test this function.
     * Sends an email of the entry.
     */
    public function mail($id)
    {
        $bill = Bills::find($id);
        $bill_items = BillItem::where('payment_reference_id', $bill->payment_reference_id)->get();
        $emailAddress = $bill->paymentReference->vendor->email;

        Mail::to($emailAddress)->queue(new MailVendorBill ($bill_items));

        return redirect('/vendors/bills')->with('success', 'Email has been sent!');
    }

    /**
     * TODO: Test this function.
     * Prints the entry.
     */
    public function print($id)
    {
        $bill = Bills::find($id);
        $bill_items = BillItem::where('payment_reference_id', $bill->payment_reference_id)->get();

        $pdf = PDF::loadView('vendors.bills.print', compact('bill_items'));
        return $pdf->stream('bill_'.date('Y-m-d').'.pdf');
    }

    /** AJAX CALLS */

    /**
     * Returns JSON of vendor's purchase orders
     */
    public function ajaxGetVendorPurchaseOrders(Vendors $vendor, $value)
    {
        $purchase_orders = PaymentReferences::select(
            'payment_references.id as value',
            'payment_references.date',
            'purchase_orders.grand_total as amount',
            'purchase_orders.due_date',
        )
        ->leftJoin('purchase_orders', 'purchase_orders.payment_reference_id', '=', 'payment_references.id')
        ->where('vendor_id', $vendor->id)
        ->where('type', 'purchase_order')
        ->where('status', 'unpaid')
        ->get();

        return $purchase_orders;
    }
}
