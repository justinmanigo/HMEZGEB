<?php

namespace App\Actions;

use App\Models\AccountingSystem;
use App\Models\AccountingSystemUser;
use App\Models\Settings\ChartOfAccounts\JournalEntries;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateAccountingSystem
{
    use AsAction;

    public function handle($request, $subscription, $subscription_user)
    {
        $accounting_system = $this->create($request, $subscription);
        
        $as_user = $this->addUserAndPermission($accounting_system->id, $subscription_user->id);
        
        GenerateAccountingPeriods::run($accounting_system->id, $request->calendar_type, $request->accounting_year, $as_user->id);

        $this->initTaxes($accounting_system->id);
        $this->initWithholding($accounting_system->id);
        $this->initOvertimePayrollRules($accounting_system->id);
        $this->initIncomeTaxPayrollRules($accounting_system->id);
        $this->initChartOfAccounts($accounting_system->id);
        $this->initJournalEntry($accounting_system->id);

        return [
            'accounting_system' => $accounting_system,
            'accounting_system_user' => $as_user,
        ];
    }

    private function create($request, $subscription)
    {
        return AccountingSystem::create([
            'name' => $request->name,
            'subscription_id' => $subscription->id,
            'vat_number' => $request->vat_number,
            'tin_number' => $request->tin_number,
            'business_type' => $request->business_type,
            'address' => $request->address,
            'po_box' => $request->po_box,
            'city' => $request->city,
            'country' => $request->country,
            'mobile_number' => $request->mobile_number,
            'telephone_1' => $request->telephone_1,
            'telephone_2' => $request->telephone_2,
            'fax' => $request->fax,
            'website' => $request->website,
            'contact_person' => $request->contact_person,
            'contact_person_position' => $request->contact_person_position,
            'contact_person_mobile_number' => $request->contact_person_mobile_number,
            'calendar_type' => $request->calendar_type,
            'accounting_year' => $request->accounting_year,
            'settings_inventory_type' => 'average',
        ]);
    }

    /**
     * Company Info
     * - Details are updated directly within the Accounting System Info
     */

    /**
     * Accounting Periods
     * - An action class is dedicated for this purprose.
     *   See: GenerateAccountingPeriods Action Class.
     */

    /**
     * Users
     */
    private function addUserAndPermission($id, $subscription_user_id)
    {
        $user = AccountingSystemUser::create([
            'accounting_system_id' => $id,
            'subscription_user_id' => $subscription_user_id,
            // 'role' => $role == 'super admin' ? 'admin' : $role,
            //! Temporarily disabled due to changes in database structure.
        ]);

        // Loop permissions
        for($j = 1; $j <= 24; $j++)
        {
            $permissions[] = [
                'accounting_system_user_id' => $user->id,
                'access_level' => 'rw',
                'sub_module_id' => $j,
            ];
        }

        DB::table('permissions')->insert($permissions);

        return $user;
    }

    /**
     * Taxes
     */
    private function initTaxes($id)
    {
        DB::table('taxes')->insert([
            [
                'accounting_system_id' => $id,
                'name' => 'Non-TAX',
                'percentage' => 0,
            ],
            [
                'accounting_system_id' => $id,
                'name' => 'TOT 2%',
                'percentage' => 2,
            ],
            [
                'accounting_system_id' => $id,
                'name' => 'TOT 10%',
                'percentage' => 10,
            ],
            [
                'accounting_system_id' => $id,
                'name' => 'VAT',
                'percentage' => 15,
            ],
        ]);
    }

    /**
     * DEPRECATED: Withholding
     */
    private function initWithholding($id)
    {
        DB::table('withholdings')->insert([
            [
                'accounting_system_id' => $id,
                'name' => 'Withholding',
                'percentage' => 2,
            ]
        ]);
    }

    /**
     * Overtime Payroll Rules
     */
    private function initOvertimePayrollRules($id)
    {
        $overtime_payroll_rules[] = [
            'accounting_system_id' => $id,
            'working_days' => 26,
            'working_hours' => 8,
            'day_rate' => 1.25,
            'night_rate' => 1.50,
            'holiday_weekend_rate' => 2.00
        ];

        DB::table('overtime_payroll_rules')->insert($overtime_payroll_rules);
    }

    /**
     * Income Tax Payroll Rules
     */
    private function initIncomeTaxPayrollRules($id)
    {
        DB::table('income_tax_payroll_rules')->insert([
            [
                'accounting_system_id' => $id,
                'income' => 10900,
                'rate' => 35,
                'deduction' => 1500
            ],
            [
                'accounting_system_id' => $id,
                'income' => 7800,
                'rate' => 30,
                'deduction' => 955
            ],
            [
                'accounting_system_id' => $id,
                'income' => 5250,
                'rate' => 25,
                'deduction' => 565
            ],
            [
                'accounting_system_id' => $id,
                'income' => 3200,
                'rate' => 20,
                'deduction' => 302.5
            ],
            [
                'accounting_system_id' => $id,
                'income' => 1650,
                'rate' => 15,
                'deduction' => 142.5
            ],
            [
                'accounting_system_id' => $id,
                'income' => 600,
                'rate' => 10,
                'deduction' => 60
            ],
        ]);
    }    

    /**
     * Chart of Accounts
     */
    private function initChartOfAccounts($id)
    {
        DB::table('chart_of_accounts')->insert([
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '1',
                'chart_of_account_no' => '1010',
                'account_name' => 'Cash on Hand'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '1',
                'chart_of_account_no' => '1011',
                'account_name' => 'Advance Payment'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '1',
                'chart_of_account_no' => '1020',
                'account_name' => 'Petty Cash'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '2',
                'chart_of_account_no' => '1110',
                'account_name' => 'Accounts Receivable'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '1',
                'chart_of_account_no' => '1111',
                'account_name' => 'Allowance for Uncollectable'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '6',
                'chart_of_account_no' => '1120',
                'account_name' => 'Employees Advance'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '6',
                'chart_of_account_no' => '1200',
                'account_name' => 'Owner\'s Receivable'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '6',
                'chart_of_account_no' => '1201',
                'account_name' => 'Debtor\'s Staff'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '6',
                'chart_of_account_no' => '1202',
                'account_name' => 'CPO Receivable'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '6',
                'chart_of_account_no' => '1204',
                'account_name' => 'VAT Receivable'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '6',
                'chart_of_account_no' => '1300',
                'account_name' => 'Prepaid Rent'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '6',
                'chart_of_account_no' => '1400',
                'account_name' => 'Prepaid Tax'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '5',
                'chart_of_account_no' => '1420',
                'account_name' => 'Merchandise Inventory'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '4',
                'chart_of_account_no' => '1510',
                'account_name' => 'Office Furniture'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '3',
                'chart_of_account_no' => '1511',
                'account_name' => 'Accumulated Dep. of Office Furniture'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '4',
                'chart_of_account_no' => '1520',
                'account_name' => 'Computer'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '3',
                'chart_of_account_no' => '1521',
                'account_name' => 'Accumulated Dep. of Computer'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '4',
                'chart_of_account_no' => '1530',
                'account_name' => 'Automobile'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '3',
                'chart_of_account_no' => '1531',
                'account_name' => 'Accumulated Dep. of Automobile'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '4',
                'chart_of_account_no' => '1540',
                'account_name' => 'Land'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '12',
                'chart_of_account_no' => '2000',
                'account_name' => 'Accounts Payable'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '14',
                'chart_of_account_no' => '2101',
                'account_name' => 'Salary Payable'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '14',
                'chart_of_account_no' => '2102',
                'account_name' => 'Income Tax Payable'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '14',
                'chart_of_account_no' => '2103',
                'account_name' => 'Pension Fund Payable'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '14',
                'chart_of_account_no' => '2104',
                'account_name' => 'VAT Payable'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '14',
                'chart_of_account_no' => '2105',
                'account_name' => 'Withholding Tax Payable'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '14',
                'chart_of_account_no' => '2106',
                'account_name' => 'Cost Sharing Payable'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '14',
                'chart_of_account_no' => '2107',
                'account_name' => 'Profit Tax Payable'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '14',
                'chart_of_account_no' => '2108',
                'account_name' => 'Payable to Owner'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '14',
                'chart_of_account_no' => '2109',
                'account_name' => 'Other Current Liability'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '13',
                'chart_of_account_no' => '2200',
                'account_name' => 'Loan Payable'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '14',
                'chart_of_account_no' => '2300',
                'account_name' => 'Accrued Payable'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '14',
                'chart_of_account_no' => '2400',
                'account_name' => 'Dividend Payable'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '14',
                'chart_of_account_no' => '2500',
                'account_name' => 'Dividend Tax Payable'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '7',
                'chart_of_account_no' => '3100',
                'account_name' => 'Equity Doesn\'t Closed'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '8',
                'chart_of_account_no' => '3101',
                'account_name' => 'Equity Retained Earning'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '7',
                'chart_of_account_no' => '3102',
                'account_name' => 'Dividend'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '15',
                'chart_of_account_no' => '4100',
                'account_name' => 'Sales'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '17',
                'chart_of_account_no' => '4101',
                'account_name' => 'Sales Return'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '17',
                'chart_of_account_no' => '4102',
                'account_name' => 'Sales Discount'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '16',
                'chart_of_account_no' => '4103',
                'account_name' => 'Other Income'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '10',
                'chart_of_account_no' => '5100',
                'account_name' => 'Cost of Goods Sold'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '10',
                'chart_of_account_no' => '5110',
                'account_name' => 'Freight Charge'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6101',
                'account_name' => 'Salary Expenses'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6102',
                'account_name' => 'Transportation Allowance'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6103',
                'account_name' => 'Medical and Related Expense'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6104',
                'account_name' => 'Representation Allowance'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6105',
                'account_name' => 'Over Time Expenses'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6106',
                'account_name' => 'Per Dime Expense'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6107',
                'account_name' => 'Commission Expense'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6108',
                'account_name' => 'Audit Fee Expense'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6109',
                'account_name' => 'Rent Expenses'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6110',
                'account_name' => 'Bank Service Charge'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6111',
                'account_name' => 'Office Cleaning Expenses'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6112',
                'account_name' => 'Office Supplies Expenses'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6113',
                'account_name' => 'Fuel Expenses'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6114',
                'account_name' => 'Loading Unloading Expenses'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6115',
                'account_name' => 'Miscellaneous Expenses'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6116',
                'account_name' => 'Advertising Expenses'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6117',
                'account_name' => 'Telephone Expenses'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6118',
                'account_name' => 'Water and Electric Expense (Utility)'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6119',
                'account_name' => 'Insurance Expense'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6120',
                'account_name' => 'Training Education Expense'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6121',
                'account_name' => 'Car Running Expense'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6122',
                'account_name' => 'Uniform Expense'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6123',
                'account_name' => 'Entertainment Expense'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6124',
                'account_name' => 'Interest Expenses'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6125',
                'account_name' => 'Repair and Maintenance Expense'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6126',
                'account_name' => 'Pension Fund Expense'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6127',
                'account_name' => 'License Renewal'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6128',
                'account_name' => 'Depreciation Expense'
            ],
            [
                'accounting_system_id' => $id,
                'chart_of_account_category_id' => '11',
                'chart_of_account_no' => '6129',
                'account_name' => 'Amortization Expense'
            ],
            
        ]);
    }

    /**
     * Journal Entries
     */
    private function initJournalEntry($id)
    {
        // Get first date of accounting year
        $accounting_periods = \App\Models\Settings\ChartOfAccounts\AccountingPeriods::where('accounting_system_id', $id)->get();

        $firstDate = $accounting_periods[0]->date_from;

        JournalEntries::create([
            'date' => $firstDate,
            'accounting_system_id' => $id,
            'notes' => 'Beginning Balance',
        ]);
    }

    /**
     * Defaults
     */
    private function initDefaults($id)
    {
        // Query Cash on Hand
        $cash_on_hand = DB::table('chart_of_accounts')
            ->where('accounting_system_id', $id)
            ->where('chart_of_account_no', '1010')->first();

        // Query VAT Payable
        $vat_payable = DB::table('chart_of_accounts')
            ->where('accounting_system_id', $id)
            ->where('chart_of_account_no', '2104')->first();

        // Query Sales
        $sales = DB::table('chart_of_accounts')
            ->where('accounting_system_id', $id)
            ->where('chart_of_account_no', '4100')->first();

        // Query Account Receivable
        $account_receivable = DB::table('chart_of_accounts')
            ->where('accounting_system_id', $id)
            ->where('chart_of_account_no', '1110')->first();

        // Query Sales Discount
        $sales_discount = DB::table('chart_of_accounts')
            ->where('accounting_system_id', $id)
            ->where('chart_of_account_no', '4102')->first();

        // Query Withholding
        $withholding = DB::table('chart_of_accounts')
            ->where('accounting_system_id', $id)
            ->where('chart_of_account_no', '2105')->first();

        // Query Advance Payment
        $advance_payment = DB::table('chart_of_accounts')
            ->where('accounting_system_id', $id)
            ->where('chart_of_account_no', '1011')->first();

        // Query Items for Sale
        $items_for_sale = DB::table('chart_of_accounts')
            ->where('accounting_system_id', $id)
            ->where('chart_of_account_no', '4100')->first();

        // Query Freight Charge Expense
        $freight_charge = DB::table('chart_of_accounts')
            ->where('accounting_system_id', $id)
            ->where('chart_of_account_no', '5110')->first();

        // Query VAT Receivable
        $vat_receivable = DB::table('chart_of_accounts')
            ->where('accounting_system_id', $id)
            ->where('chart_of_account_no', '1204')->first();

        // Query Account Payable
        $account_payable = DB::table('chart_of_accounts')
            ->where('accounting_system_id', $id)
            ->where('chart_of_account_no', '2000')->first();

        // Query Salary Payable
        $salary_payable = DB::table('chart_of_accounts')
            ->where('accounting_system_id', $id)
            ->where('chart_of_account_no', '2101')->first();

        // Query Commission Payment
        $commission_payment = DB::table('chart_of_accounts')
            ->where('accounting_system_id', $id)
            ->where('chart_of_account_no', '6107')->first();

        // Preset Defaults
        DB::table('accounting_systems')
            ->where('id', $id)
            ->update([
                // Receipts
                'receipt_cash_on_hand' => $cash_on_hand->id,
                'receipt_vat_payable' => $vat_payable->id,
                'receipt_sales' => $sales->id,
                'receipt_account_receivable' => $account_receivable->id,
                'receipt_sales_discount' => $sales_discount->id,
                'receipt_withholding' => $withholding->id,

                // Advance Revenue
                'advance_receipt_cash_on_hand' => $cash_on_hand->id,
                'advance_receipt_advance_payment' => $advance_payment->id,

                // Credit Receipts
                'credit_receipt_cash_on_hand' => $cash_on_hand,
                'credit_receipt_account_receivable' => $account_receivable,

                // Bills
                'bill_cash_on_hand' => $cash_on_hand,
                'bill_items_for_sale' => $items_for_sale,
                'bill_freight_charge_expense' => $freight_charge,
                'bill_vat_receivable' => $vat_receivable,
                'bill_account_payable' => $account_payable,
                'bill_withholding' => $withholding,

                // Payments
                'payment_cash_on_hand' => $cash_on_hand,
                'payment_vat_receivable' => $vat_receivable,
                'payment_account_payable' => $account_payable,
                'payment_withholding' => $withholding,
                'payment_salary_payable' => $salary_payable,
                'payment_commission_payment' => $commission_payment,
            ]);
    }
}
