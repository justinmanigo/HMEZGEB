<?php

use Illuminate\Support\Facades\Route;

use App\Models\User;

// Home
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReferralsController;

// Customer module
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepositController;
// Banking module
use App\Http\Controllers\BankAccountsController;
use App\Http\Controllers\TransfersController;
use App\Http\Controllers\DepositsController;
use App\Http\Controllers\TransactionsController;  
// Vendor module
use App\Http\Controllers\BillsController;
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\PaymentsController; 
// Journal module
use App\Http\Controllers\JournalVouchersController; 
// Human Resource module

// Inventory module
use App\Http\Controllers\InventoryController; 
// Settings module


use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;   
use Illuminate\Support\Facades\Auth;

// Human Resource Module
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\AdditionController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\LoanController;

// Settings
use App\Http\Controllers\Settings\TaxController;
use App\Http\Controllers\Settings\ManageUsersController;
use App\Http\Controllers\Settings\ChartOfAccountsController;
use App\Http\Controllers\Settings\PayrollRulesController;

// Account Settings
use App\Http\Controllers\AccountSettings\AccountSettingsController;

// Reports
use App\Http\Controllers\ReportsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'middleware' => 'auth',
], function(){
    /**
     * Switch Accounting Systems
     */
    Route::get('/switch', [HomeController::class, 'viewAccountingSystems']);
    Route::put('/switch', [HomeController::class, 'switchAccountingSystem']);
    
    Route::group([
        'middleware' => 'auth.accountingsystem',
    ], function(){
        /**
         * Home
         */
        Route::get('/', [HomeController::class, 'index']);
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        
        /**===================== ACCOUNT MODULES =====================**/

        /**
         * Referral Module
         */
        Route::group([
            'as' => 'referrals.'
        ], function(){
            Route::get('/referrals', [ReferralsController::class, 'index'])->name('index');
            Route::post('/referrals', [ReferralsController::class, 'storeNormalReferral'])->name('store.normal');
            Route::put('/referrals', [ReferralsController::class, 'storeAdvancedReferral'])->name('store.advanced');
        });

        /**
         * Account Settings Module
         */
        Route::group([
            'as' => 'account.'
        ], function() {
            // HTTP
            Route::get('/account/', [AccountSettingsController::class, 'index'])->name('index');
            Route::post('/account/2fa/confirm', [AccountSettingsController::class, 'confirm2FA'])->name('confirm2FA');

            // AJAX
            Route::post('/ajax/account/show/recoverycodes', [AccountSettingsController::class, 'showRecoveryCodes']);
            Route::put('/ajax/account/update/username', [AccountSettingsController::class, 'updateUsername']);
            Route::put('/ajax/account/update/email', [AccountSettingsController::class, 'updateEmail']);
            Route::put('/ajax/account/update/password', [AccountSettingsController::class, 'updatePassword']);
        });

        /**===================== SIDEBAR MODULES =====================**/

        /**
         * Customers Module
         */
        Route::group([
            // TODO: Disallow access if user does not have privileges (R/RW) through a custom middleware.
        ], function(){

            /**
             * Customers > Receipts
             */
            Route::group([
                'as'=>'receipts.'
            ], function(){
                Route::get('/customers/receipts/', [ReceiptController::class, 'index'])->name('receipt.index');
                
                // Store
                Route::post('/receipt',[ReceiptController::class,'storeReceipt'])->name('receipt.store');
                Route::post('/advance-receipt',[ReceiptController::class,'storeAdvanceRevenue'])->name('advanceReceipt.store');
                Route::post('/credit-receipt',[ReceiptController::class,'storeCreditReceipt'])->name('creditReceipt.store');
                Route::post('/proforma',[ReceiptController::class,'storeProforma'])->name('proforma.store');
        
                Route::delete('/receipt/{id}', [ReceiptController::class, 'destroy']);
                Route::get('/receipt/{id}', [ReceiptController::class, 'edit']);
                Route::put('/receipt/{id}', [ReceiptController::class, 'update']);
        
                /** AJAX Calls */
                Route::get('/ajax/customer/receipt/proforma/search/{customer}/{value}', [ReceiptController::class, 'ajaxSearchCustomerProforma']);
                Route::get('/ajax/customer/receipt/proforma/get/{proforma}', [ReceiptController::class, 'ajaxGetProforma']);
            });
        
            /**
             * Customers > Customers
             */
            Route::group([
                'as'=>'customers.'
            ], function(){ 
                Route::get('/customers/customers/', [CustomerController::class, 'index']);
                Route::post('/customers/customers/', [CustomerController::class, 'store']); 
                Route::get('/customers/customers/{id}', [CustomerController::class, 'edit']);
                Route::put('/customers/customers/{id}', [CustomerController::class, 'update']);
                Route::delete('/customers/customers/{id}', [CustomerController::class, 'destroy']);
                
                Route::get('/select/search/customer/{query}', [CustomerController::class, 'queryCustomers']);
                Route::get('/ajax/customer/receipts/topay/{customer}', [CustomerController::class, 'ajaxGetReceiptsToPay']);
            });
        
            /**
             * Customers > Deposits
             */
            Route::group([
                'as'=>'deposits.'
            ], function(){ 
                Route::get('/customers/deposits/', [DepositController::class, 'index']);
                Route::get('/ajax/customer/deposit/bank/search/{query}', [DepositController::class, 'ajaxSearchBank']);
            });
        });

        /**
         * Vendors Module
         */
        Route::group([
            // TODO: Disallow access if user does not have privileges (R/RW) through a custom middleware.
        ], function(){
            
            /**
             * Vendors > Bills
             */
            Route::group([
                'as'=>'bills.'
            ], function(){ 
                // HTML
                Route::get('/vendors/bills/', [BillsController::class, 'index'])->name('bill.index');
                Route::post('/bill',[BillsController::class,'storeBill'])->name('bill.store');
                Route::get('/individual-bill',[BillsController::class,'show'])->name('bill.show');
                Route::post('/purchaseorder',[BillsController::class,'storePurchaseOrder'])->name('purchaseOrder.store');
            });
        
            /**
             * Vendors > Payments
             */
            Route::group([
                'as'=>'payments.'
            ], function(){ 
                // HTML
                Route::get('/vendors/payments',[PaymentsController::class,'index']);
                Route::post('/payment/bill',[PaymentsController::class,'storeBillPayment'])->name('billPayment.store');
                Route::post('/payment/income_tax',[PaymentsController::class,'storeIncomeTaxPayment'])->name('incomeTax.store');  
                Route::post('/payment/pension',[PaymentsController::class,'storePensionPayment'])->name('pension.store');
                Route::post('/payment/withholding',[PaymentsController::class,'storeWithholdingPayment'])->name('withholdingPayment.store');
        
                // AJAX
                Route::get('/ajax/vendor/payments/topay/{vendor}', [VendorsController::class, 'ajaxGetPaymentsToPay']);
                Route::get('/ajax/vendor/withholding/topay/{vendor}', [VendorsController::class, 'ajaxGetWithholdingToPay']);
            });
        
            /**
             * Vendors > Vendors
             */
            Route::group([
                'as'=>'vendors.'
            ], function(){ 
                // HTML
                Route::get('/vendors/vendors/',[VendorsController::class,'index']);
                Route::get('/vendors/{id}',[VendorsController::class,'edit'])->name('vendors.edit');
                Route::post('/vendors/{id}',[VendorsController::class,'update'])->name('vendors.update');
                Route::delete('/vendors/{id}',[VendorsController::class,'destroy'])->name('vendors.destroy');
                Route::post('/vendors', [VendorsController::class, 'store'])->name('vendors.store');
                
                // AJAX
                Route::get('/select/search/vendor/{query}', [VendorsController::class, 'queryVendors']);
            });
        });

        /**
         * Banking Module
         */
        Route::group([
            // TODO: Disallow access if user does not have privileges (R/RW) through a custom middleware.
        ], function(){

            /**
             * Banking > Accounts
             */
            Route::group([
                'as'=>'accounts.'
            ], function(){ 
                // HTML
                Route::get('/banking/accounts', [BankAccountsController::class, 'index'])->name('bank.accounts');
            
                // RESOURCE
                Route::resource('/banking/accounts', BankAccountsController::class);
            });
        
            /**
             * Banking > Transfer
             */
            Route::group([
                'as'=>'transfers.'
            ], function(){ 
                // HTML
                Route::get('/banking/transfer', [TransfersController::class, 'index'])->name('bank.transfers');
            });
        
            /**
             * Banking > Deposits
             * Same content as Customer > Deposits
             */
            Route::group([
                'as'=>'deposits.'
            ], function(){ 
                // HTML
                Route::get('/banking/deposits', [DepositController::class, 'index'])->name('bank.deposits');
            });
        
            /**
             * Banking > Transactions
             */
            Route::group([
                'as'=>'transactions.'
            ], function(){ 
                // HTML
                Route::get('/banking/transactions', [TransactionsController::class, 'index']);
            });

            /**
             * TODO: Banking > Bank Reconcilation
             */
            
        });

        /**
         * Journal Vouchers Module
         */
        Route::group([
            // TODO: Disallow access if user does not have privileges (R/RW) through a custom middleware.
            'as'=>'journals.'
        ], function(){ 
            // HTML
            Route::get('/jv/', [JournalVouchersController::class, 'index'])->name('index');
            Route::get('/journals/{journalVoucher}', [JournalVouchersController::class, 'show'])->name('show');
            Route::post('/journals', [JournalVouchersController::class, 'store'])->name('store');
        });

        /**
         * Inventory Module
         */
        Route::group([
            // TODO: Disallow access if user does not have privileges (R/RW) through a custom middleware.
            'as'=>'inventory.'
        ], function(){ 
            // HTML
            Route::get('/inventory/', [InventoryController::class, 'index']);
            Route::post('/inventory', [InventoryController::class, 'store']);
            Route::get('/inventory/{inventory}', [InventoryController::class, 'edit']);
            Route::put('/inventory/{inventory}', [InventoryController::class, 'update']);
        
            // AJAX
            Route::get('/select/search/inventory/{query}', [InventoryController::class, 'ajaxSearchInventory']);
        });

        /**
         * Human Resource Module
         */
        Route::group([
            // TODO: Disallow access if user does not have privileges (R/RW) through a custom middleware.
        ], function(){

            /**
             * Human Resource > Payrolls
             */
            Route::group([
                'as' => 'payrolls.'
            ], function(){
                // HTML
                Route::get('/hr/payrolls', [PayrollController::class, 'index']);
            });
        
            /**
             * Human Resource > Employees
             */
            Route::group([
                'as' => 'employees.'
            ], function(){
                // HTML
                Route::get('/hr/employees', [EmployeeController::class, 'index'])->name('index');
                Route::post('/employee', [EmployeeController::class, 'store'])->name('store');
                Route::get('/employee/{id}', [EmployeeController::class, 'edit']);
                Route::put('/employee/{employee}', [EmployeeController::class, 'update'])->name('update');
                Route::delete('/employee/{employee}', [EmployeeController::class, 'destroy'])->name('destroy');

                // AJAX
                Route::get('/select/search/employee/{query}', [EmployeeController::class, 'queryEmployees']);
                Route::get('/ajax/hr/employees/get/{employee}', [EmployeeController::class, 'ajaxGetEmployee']);
                Route::get('/ajax/employee/commission/topay/{employee}', [EmployeeController::class, 'ajaxSearchCommission']);
            });
        
            /**
             * Human Resource > Overtime
             */
            Route::group([
                'as' => 'overtime.'
            ], function(){
                // HTML
                Route::get('/hr/overtime', [OvertimeController::class, 'index']);
                Route::post('/overtime', [OvertimeController::class, 'store'])->name('store');
                Route::delete('/overtime/{id}', [OvertimeController::class, 'destroy']);
            });
        
            /**
             * Human Resource > Additions
             */
            Route::group([
                'as' => 'additions.'
            ], function(){
                // HTML
                Route::get('/hr/addition', [AdditionController::class, 'index']);
                Route::post('/addition', [AdditionController::class, 'store'])->name('store');
                Route::delete('/addition/{id}', [AdditionController::class, 'destroy']);
            });
        
            /**
             * Human Resource > Deductions
             */
            Route::group([
                'as' => 'deductions.'
            ], function(){
                // HTML
                Route::get('/hr/deduction', [DeductionController::class, 'index']);
                Route::post('/deduction', [DeductionController::class, 'store'])->name('store');
                Route::delete('/deduction/{id}', [DeductionController::class, 'destroy']);
            });
        
            /**
             * Human Resource > Loans
             */
            Route::group([
                'as' => 'loans.'
            ], function(){
                // HTML
                Route::get('/hr/loan', [LoanController::class, 'index']);
                Route::post('/loan', [LoanController::class, 'store'])->name('store');
                Route::delete('/loan/{id}', [LoanController::class, 'destroy']);
            });
        });

        /**
         * Reports Module
         */
        Route::group([
            'as' => 'reports.',
            'prefix' => 'reports'
        ], function() {
            // HTTP
            // Views
            Route::get('/customers', [ReportsController::class, 'customers'])->name('customers');
            Route::get('/vendors', [ReportsController::class, 'vendors'])->name('vendors');
            Route::get('/sales', [ReportsController::class, 'sales'])->name('sales');
            Route::get('/entries', [ReportsController::class, 'entries'])->name('entries');
            Route::get('/financial_statement', [ReportsController::class, 'financial_statement'])->name('financial_statement');
            
            // pdf
            // customers
            Route::post('/customers/aged_receivable/pdf', [ReportsController::class, 'agedReceivablePDF'])->name('aged_receivable.pdf');
            Route::post('/customers/cash_receipts_journal/pdf', [ReportsController::class, 'cashReceiptsJournalPDF'])->name('cash_receipts_journal.pdf');
            Route::post('/customers/ledgers/pdf', [ReportsController::class, 'customerLedgersPDF'])->name('customer_ledgers.pdf');

            // vendors
            Route::post('/vendors/aged_payables/pdf', [ReportsController::class, 'agedPayablesPDF'])->name('aged_payables.pdf');
            Route::post('/vendors/cash_disbursements_journal/pdf', [ReportsController::class, 'cashDisbursementsJournalPDF'])->name('cash_disbursements_journal.pdf');
            Route::post('/vendors/cash_requirements/pdf', [ReportsController::class, 'cashRequirementsPDF'])->name('cash_requirements.pdf');
            Route::post('/vendors/ledgers/pdf', [ReportsController::class, 'vendorLedgersPDF'])->name('vendor_ledgers.pdf');
            
            // sales
            Route::post('/sales/pdf', [ReportsController::class, 'salesPDF'])->name('sales.pdf');
            
            // entries
            Route::post('/entries/bill/pdf', [ReportsController::class, 'billPDF'])->name('bill.pdf');
            Route::post('/entries/general_journal/pdf', [ReportsController::class, 'generalJournalPDF'])->name('general_journal.pdf');
            Route::post('/entries/general_ledger/pdf', [ReportsController::class, 'generalLedgerPDF'])->name('general_ledger.pdf');
            Route::post('/entries/payment/pdf', [ReportsController::class, 'paymentPDF'])->name('payment.pdf');
            Route::post('/entries/receipt/pdf', [ReportsController::class, 'receiptPDF'])->name('receipt.pdf');
            Route::post('/entries/journal_voucher/pdf', [ReportsController::class, 'journalVoucherPDF'])->name('journal_voucher.pdf');

            
            // financial statement
            Route::post('/financial_statement/balance/pdf', [ReportsController::class, 'balanceSheetPDF'])->name('balance_sheet.pdf');
            Route::post('/financial_statement/balance/zero_account/pdf', [ReportsController::class, 'balanceSheetZeroAccountPDF'])->name('balance_sheet_zero_account.pdf');
            Route::post('/financial_statement/income_statement_single/pdf', [ReportsController::class, 'incomeStatementSinglePDF'])->name('income_statement_single.pdf');
            Route::post('/financial_statement/income_statement_multiple/pdf', [ReportsController::class, 'incomeStatementMultiplePDF'])->name('income_statement_multiple.pdf');
        });

        /**
         * Settings Module
         */
        Route::group([
            'as' => 'settings.'
        ], function() {

            /**
             * Settings > Company Info
             */
            Route::group([
                'as' => 'company.'
            ], function(){
                // HTTP
                Route::view('/settings/company', 'settings.company_info.index')->name('index');
            });

            /**
             * Settings > Users
             */
            Route::group([
                'as' => 'users.'
            ], function() {
                // HTTP
                Route::get('/settings/users', [ManageUsersController::class, 'index'])->name('manageUsers');
                Route::get('/settings/users/{accountingSystemUser}/permissions', [ManageUsersController::class, 'editPermissions'])->name('editPermissions');
                Route::put('/settings/users/{accountingSystemUser}/permissions', [ManageUsersController::class, 'updatePermissions'])->name('updatePermissions');
            });

            /**
            * Settings > Themes
            */
            Route::group([
                'as' => 'themes.'
            ], function() {
                // HTTP
                Route::view('/settings/themes', 'settings.themes.index')->name('index');
            });

            /**
            * Settings > Taxes
            */
            Route::group([
                'as' => 'tax.'
            ], function() {
                // HTTP
                Route::get('/settings/taxes', [TaxController::class, 'index'])->name('index');
                Route::post('/settings/taxes', [TaxController::class, 'store'])->name('store');
                Route::put('/settings/taxes/{tax}', [TaxController::class, 'update'])->name('update');
                Route::delete('/settings/taxes/{tax}', [TaxController::class, 'destroy'])->name('destroy');

                // AJAX
                Route::get('/ajax/settings/taxes/get/{tax}', [TaxController::class, 'ajaxGetTax']);
            });

            /**
            * Settings > Withholding
            */
            Route::group([
                'as' => 'withholding.'
            ], function(){
                // HTTP
                Route::view('/settings/withholding', 'settings.withholding.index')->name('index');
            });


            /**
            * Settings > Payroll Rules
            */
            Route::group([
                'as' => 'payroll.'
            ], function(){
                // HTTP
                Route::get('/settings/payroll', [PayrollRulesController::class, 'index'])->name('index');
                Route::post('/settings/payroll/update/incometax', [PayrollRulesController::class, 'updateIncomeTaxRules'])->name('updateIncomeTaxRules');
                Route::post('/settings/payroll/update/overtime', [PayrollRulesController::class, 'updateOvertimeRules'])->name('updateOvertimeRules');
            });

            /**
            * Settings > Chart of Accounts
            */
            Route::group([
                'as' => 'coa.'
            ], function() {
                // HTTP
                Route::get('/settings/coa', [ChartOfAccountsController::class, 'index'])->name('index');
                Route::post('/settings/coa', [ChartOfAccountsController::class, 'store'])->name('store');
                
                // AJAX
                Route::get('/ajax/settings/coa/search/{query}', [ChartOfAccountsController::class, 'ajaxSearchCOA']);
                Route::get('/ajax/settings/coa_categories/search', [ChartOfAccountsController::class, 'ajaxSearchCategories']);
                Route::get('/ajax/settings/coa_categories/search/{query}', [ChartOfAccountsController::class, 'ajaxSearchCategories']);
                Route::get('/ajax/settings/coa/beginning-balance', [ChartOfAccountsController::class, 'ajaxGetCOAForBeginningBalance']);
                Route::post('/ajax/settings/coa/beginning-balance', [ChartOfAccountsController::class, 'storeBeginningBalance']);
            });

            /**
            * Settings > Inventory
            */
            Route::group([
                'as' => 'inventory.'
            ], function(){
                // HTTP
                Route::view('/settings/inventory', 'settings.inventory.index')->name('index');
            });

            /**
            * Settings > Defaults
            */
            Route::group([
                'as' => 'defaults.'
            ], function(){
                // HTTP
                Route::view('/settings/defaults', 'settings.defaults.index')->name('index');
            });
        });
    });
});

Route::post('/userlogin', function (Request $request){
   

    $credentials = $request->only('email', 'password');
    Log::info($credentials);
    //  $accessCode = User::where('email',$request->email)->first();
    // Log::info($accessCode);

    // if (Hash::check($request->password, 'test')) {
    //     session(['adminauthenticated' => 'true']);
    //     Log::info("sod");
    // }else{
    //     Log::info("wa sod");
    // }

    
    if (Auth::attempt($credentials)) {
        // if success login
        Log::info("sod");
        session(['adminauthenticated' => 'true']);
        

        // return redirect()->intended('/dashboard');
        return redirect()->intended('/home');
    }else{
        Log::info(" wa sod");
        return redirect()->route('logins')->with('error', "Invalid user credentials.");
    }
    // if failed login

})->name('userlogin');
