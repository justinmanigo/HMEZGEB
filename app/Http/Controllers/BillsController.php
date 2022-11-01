<?php

namespace App\Http\Controllers;

use App\Actions\CreateJournalEntry;
use App\Actions\CreateJournalPostings;
use App\Actions\UpdateInventoryItemQuantity;
use App\Actions\Vendor\Bill\StoreBillItems;
use App\Actions\Vendor\Bill\UpdateBillStatus;
use App\Actions\Vendor\CalculateBalanceVendor;
use App\Http\Requests\Vendor\Bill\StoreBillRequest;
use App\Http\Requests\Vendor\Bill\StorePurchaseOrderRequest;
use App\Models\Bills;
use App\Models\Vendors;
use App\Models\PaymentReferences;
use App\Models\BillItem;
use App\Models\PurchaseOrders;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Mail\Vendors\MailVendorBill;
use App\Mail\Vendors\MailVendorPurchaseOrder;
use Illuminate\Support\Facades\Mail;
use PDF;


class BillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = PaymentReferences::leftJoin('vendors', 'vendors.id', '=', 'payment_references.vendor_id')
            ->leftJoin('bills', 'bills.payment_reference_id', '=', 'payment_references.id')
            ->leftJoin('purchase_orders', 'purchase_orders.payment_reference_id', '=', 'payment_references.id')
            ->leftJoin('cost_of_goods_sold', 'cost_of_goods_sold.payment_reference_id', '=', 'payment_references.id')
            ->leftJoin('expenses', 'expenses.payment_reference_id', '=', 'payment_references.id')
            // where subquery
            ->where(function ($query) {
                $query->where('payment_references.type', '=', 'bill')
                    ->orWhere('payment_references.type', '=', 'purchase_order')
                    ->orWhere('payment_references.type', '=', 'cogs')
                    ->orWhere('payment_references.type', '=', 'expense');
            })
            ->where('payment_references.accounting_system_id', session('accounting_system_id'))
            ->select(
                'vendors.name',
                'payment_references.id',
                'payment_references.vendor_id',
                'payment_references.type',
                'payment_references.date',
                'payment_references.status',
                'payment_references.is_void',
                'bills.amount_received as bill_amount',
                'purchase_orders.grand_total as purchase_order_amount',
                'cost_of_goods_sold.amount_received as cost_of_goods_sold_amount',
                'expenses.total_amount_received as expenses_amount'
            )
            ->get();

        // count advance revenues
        $vendors = Vendors::where('accounting_system_id', session('accounting_system_id'))->get();

        $total_balance = 0;
        $total_balance_overdue = 0;
        $count = 0;
        $count_overdue = 0;

        foreach($vendors as $vendor){
            $total_balance += CalculateBalanceVendor::run($vendor->id)['total_balance'];
            $total_balance_overdue += CalculateBalanceVendor::run($vendor->id)['total_balance_overdue'];
            $count += CalculateBalanceVendor::run($vendor->id)['count'];
            $count_overdue += CalculateBalanceVendor::run($vendor->id)['count_overdue'];
        }

        return view('vendors.bills.index', [
            'transactions' => $transactions,
            'total_balance' => $total_balance,
            'total_balance_overdue' => $total_balance_overdue,
            'count' => $count,
            'count_overdue' => $count_overdue,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /** === STORE BILLS === */

    public function storeBill(StoreBillRequest $request)
    {
        // return $request;

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
            $credit_accounts[] = CreateJournalPostings::encodeAccount($request->bill_cash_on_hand);
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
            'withholding' => '0', // temporary
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

    public function storePurchaseOrder(StorePurchaseOrderRequest $request)
    {
        // Create Payment Reference Record
        $reference = PaymentReferences::create([
            'accounting_system_id' => session('accounting_system_id'),
            'vendor_id' => $request->vendor->value,
            'date' => $request->date,
            'type' => 'purchase_order',
            'attachment' => $request->attachment,
            'remark' => $request->remark,
            'status' => 'unpaid',
        ]);

        // Create Purchase Order Record
        //  if($request->attachment) {
        //      $fileAttachment = time().'.'.$request->attachment->extension();
        //      $request->attachment->storeAs('public/bill-attachment', $fileAttachment);
        //  }

        StoreBillitems::run($request->item, $request->quantity, $reference->id);

        return PurchaseOrders::create([
            'payment_reference_id' => $reference->id,
            'due_date' => $request->due_date,
            'sub_total' => $request->sub_total,
            'tax' => $request->tax_total,
            'grand_total' => $request->grand_total,
            // image upload
            'attachment' => isset($fileAttachment) ? $fileAttachment : null,
        ]);
    }

    // Void
    public function voidBill($id)
    {
        $bill = Bills::find($id);
        // if($bill->paymentReference->is_deposited == "yes")
        // return redirect()->back()->with('danger', "Error voiding! This transaction is already deposited.");

        // TODO: Deactivate connected modules (Add inventory, adjust Journal entry/postings).
        $bill->paymentReference->is_void = "yes";
        $bill->paymentReference->save();

        return redirect()->back()->with('success', "Successfully voided bill.");
    }

    public function voidPurchaseOrder($id)
    {
        $purchaseOrder = PurchaseOrders::find($id);
        // if($purchaseOrder->paymentReference->is_deposited == "yes")
        // return redirect()->back()->with('danger', "Error voiding! This transaction is already deposited.");
        $purchaseOrder->paymentReference->is_void = "yes";
        $purchaseOrder->paymentReference->save();

        return redirect()->back()->with('success', "Successfully voided purchase order.");
    }

    // Void
    public function reactivateBill($id)
    {
        $bill = Bills::find($id);
        // TODO: Reactivate connected modules (Deduct inventory, adjust Journal entry/postings).
        $bill->paymentReference->is_void = "no";
        $bill->paymentReference->save();

        return redirect()->back()->with('success', "Successfully reactivated bill.");
    }

    public function reactivatePurchaseOrder($id)
    {
        $purchase_order = PurchaseOrders::find($id);
        $purchase_order->paymentReference->is_void = "no";
        $purchase_order->paymentReference->save();

        return redirect()->back()->with('success', "Successfully reactivated purchase order.");
    }

    // send Email
    public function sendMailBill($id)
    {
        $bill = Bills::find($id);
        $bill_items = BillItem::where('payment_reference_id', $bill->payment_reference_id)->get();
        $emailAddress = $bill->paymentReference->vendor->email;

        Mail::to($emailAddress)->queue(new MailVendorBill ($bill_items));

        return redirect()->route('bills.bills.index')->with('success', 'Email has been sent!');
    }

    public function sendMailPurchaseOrder($id)
    {
        $purchaseOrder = PurchaseOrders::find($id);
        $emailAddress = $purchaseOrder->paymentReference->vendor->email;

        Mail::to($emailAddress)->queue(new MailVendorPurchaseOrder ($purchaseOrder));

        return redirect()->route('bills.bills.index')->with('success', 'Email has been sent!');
    }

    // Print
    public function printBill($id)
    {
        $bill = Bills::find($id);
        $bill_items = BillItem::where('payment_reference_id', $bill->payment_reference_id)->get();

        $pdf = PDF::loadView('vendors.bills.print', compact('bill_items'));
        return $pdf->stream('bill_'.date('Y-m-d').'.pdf');
    }

    public function printPurchaseOrder($id)
    {
        $purchase_order = PurchaseOrders::find($id);

        $pdf = PDF::loadView('vendors.bills.purchase_order.print', compact('purchase_order'));
        return $pdf->stream('purchase_order_'.date('Y-m-d').'.pdf');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bills  $bills
     * @return \Illuminate\Http\Response
     */
    public function show(Bills $bills)
    {
        return view('vendors.bills.show');
    }

    public function showPurchaseOrder($id)
    {
        $purchaseOrders = PurchaseOrders::find($id);
        return view('vendors.bills.purchase_order.show', compact('purchaseOrders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bills  $bills
     * @return \Illuminate\Http\Response
     */
    public function edit(Bills $bills)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bills  $bills
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bills $bills)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bills  $bills
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bills $bills)
    {
        //
    }


}
